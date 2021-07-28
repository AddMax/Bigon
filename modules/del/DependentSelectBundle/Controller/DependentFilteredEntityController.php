<?php

namespace Evercode\DependentSelectBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

class DependentFilteredEntityController extends Controller
{
    const DQL_PARAMETER_PREFIX = 'param_';

    /**
     * @return Response
     */
    public function getOptionsAction(Request $request)
    {
        $translator = $this->get('translator');

        $entity_alias = $request->get('entity_alias');
        //parent_id can have multiple identifiers
        $parent_id = $request->get('parent_id');
        $fallbackParentId = $request->get('fallback_parent_id');
        $empty_value = $request->get('empty_value');

        $excludedEntityId = $request->get('excluded_entity_id');
        $isTranslationDomainEnabled = $request->get('choice_translation_domain');
        $choiceTitleTranslationPart = $request->get('choice_title_translation_part');
        $callbackParameters = json_decode($request->get('callback_parameters'), true);

        $entities = $this->get('service_container')->getParameter('dependent_select.dependent_filtered_entities');
        $entity_inf = $entities[$entity_alias];

        $selectedResultService = $entity_inf['selected_result_service'];

        //set the fallback
        if ($entity_inf['fallback_alias'] !== null && !empty($fallbackParentId) && empty($parent_id)) {
            $parent_id = $fallbackParentId;
            $entity_inf = $entities[$entity_inf['fallback_alias']];
        }

        if ($entity_inf['role'] !== 'IS_AUTHENTICATED_ANONYMOUSLY') {
            if (false === $this->get('security.authorization_checker')->isGranted($entity_inf['role'])) {
                throw new AccessDeniedException();
            }
        }

        $repository = $this->getDoctrine()->getRepository($entity_inf['class']);

        /** @var QueryBuilder $qb */
        $qb = $repository->createQueryBuilder('e');

        //if many to many
        if ($entity_inf['many_to_many']['active']) {
            //make (array)$joinTableResults from many_to_many entity to use it into IN (:results) of entity's $qb
            /** @var EntityRepository $manyToManyEntityRepository */
            $manyToManyEntityRepository = $this->getDoctrine()->getRepository($entity_inf['many_to_many']['entity']);

            $qbjt = $manyToManyEntityRepository->createQueryBuilder('jt');

            if ($parent_id) {
                $qbjt
                    ->where('jt.'.$entity_inf['parent_property'].' IN (:parent_id)')
                    ->setParameter('parent_id', $parent_id);
            } elseif ($entity_inf['many_to_many']['callback_if_empty_parent']) {
                //add callback from target entity repository if no arguments given and the callback is specified
                $manyToManyEntityRepository->{$entity_inf['many_to_many']['callback_if_empty_parent']}($qbjt);
            }

            $results = $qbjt->getQuery()->getResult();

            $joinTableResults = [];
            foreach ($results as $result) {
                $getter = $this->getGetterName($entity_inf['many_to_many']['property']);
                $joinTableResults[] = $result->$getter()->getId(); //TODO: fix it
            }

            $qb
                ->andWhere('e.id IN (:results)')
                ->setParameter('results', $joinTableResults);
        } else {
            if ($entity_inf['grandparent_property']) {
                $qb
                    ->leftJoin('e.'.$entity_inf['parent_property'], 'parent')
                    ->where('parent.'.$entity_inf['grandparent_property'].' = :parent_id');
            } else {
                $qb
                    ->where('e.'.$entity_inf['parent_property'].' = :parent_id');
            }

            $qb
                ->setParameter('parent_id', $parent_id);
        }

        // $qb
            // ->andWhere('e.id != :excluded_entity_id')
            // ->setParameter('excluded_entity_id', $excludedEntityId);

        //add the filters to a query
        foreach ($entity_inf['child_entity_filters'] as $key => $filter) {
            $parameterName = self::DQL_PARAMETER_PREFIX.$filter['property'].$key;

            $qb
                ->andWhere('e.'.$filter['property'].' '.$filter['sign'].' :'.$parameterName)
                ->setParameter($parameterName, $filter['value']);
        }

        $qb
            ->orderBy('e.'.$entity_inf['order_property'], $entity_inf['order_direction']);

        if (null !== $entity_inf['callback']) {
            $repository = $qb->getEntityManager()->getRepository($entity_inf['class']);

            if (!method_exists($repository, $entity_inf['callback'])) {
                throw new \InvalidArgumentException(sprintf('Callback function "%s" in Repository "%s" does not exist.', $entity_inf['callback'], get_class($repository)));
            }

            //dql callback starts here
            if (!empty($callbackParameters)) {
                call_user_func([$repository, $entity_inf['callback']], $qb, $callbackParameters);
            } else {
                call_user_func([$repository, $entity_inf['callback']], $qb);
            }
        }

        $results = $qb->getQuery()->getResult();

        $selectedResultId = null;

        if ($selectedResultService) {
            $selectedResultId = $this->get($selectedResultService)->findOptionIdToSelect($results);
        }

        if (empty($results)) {
            return new Response('<option value="">'.$translator->trans($entity_inf['no_result_msg']).'</option>');
        }

        $html = '';

        if ($empty_value !== false) {
            $html .= '<option value="">'.$translator->trans($empty_value).'</option>';
        }

        $getter = $this->getGetterName($entity_inf['property']);

        foreach ($results as $key => $result) {
            if ($entity_inf['property']) {
                $res = $result->$getter();
            } else {
                $res = (string) $result;
            }

            //check if translation is enabled
            if ($isTranslationDomainEnabled) {
                if ($choiceTitleTranslationPart) {
                    $res = $translator->trans((string) $choiceTitleTranslationPart).str_replace($choiceTitleTranslationPart, '', $res);
                } else {
                    $res = $translator->trans((string) $res);
                }
            }

            $optionString = '<option value="%d">%s</option>';

            //auto select first result (if it's enabled in the config.yml)
            if (($entity_inf['auto_select_first_result'] && $key === 0) || $result->getId() === $selectedResultId) {
                $optionString = '<option value="%d" selected>%s</option>';
            }

            $html = $html.sprintf($optionString, $result->getId(), $res);
        }

        return new Response($html);
    }

    /**
     * @return Response
     */
    public function getJSONAction(Request $request)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->get('doctrine.orm.entity_manager');

        $entity_alias = $request->get('entity_alias');
        $parent_id = $request->get('parent_id');

        $entities = $this->get('service_container')->getParameter('dependent_select.dependent_filtered_entities');
        $entity_inf = $entities[$entity_alias];

        if ($entity_inf['role'] !== 'IS_AUTHENTICATED_ANONYMOUSLY') {
            if (false === $this->get('security.authorization_checker')->isGranted($entity_inf['role'])) {
                throw new AccessDeniedException();
            }
        }

        $term = $request->get('term');
        $maxRows = $request->get('maxRows', 20);

        $like = '%'.$term.'%';

        $property = $entity_inf['property'];
        if (!$entity_inf['property_complicated']) {
            $property = 'e.'.$property;
        }

        $qb = $em->createQueryBuilder()
            ->select('e')
            ->from($entity_inf['class'], 'e')
            ->where('e.'.$entity_inf['parent_property'].' = :parent_id')
            ->setParameter('parent_id', $parent_id)
            ->orderBy('e.'.$entity_inf['order_property'], $entity_inf['order_direction'])
            ->setParameter('like', $like)
            ->setMaxResults($maxRows);

        if ($entity_inf['case_insensitive']) {
            $qb->andWhere('LOWER('.$property.') LIKE LOWER(:like)');
        } else {
            $qb->andWhere($property.' LIKE :like');
        }

        $results = $qb->getQuery()->getResult();

        $res = [];
        foreach ($results as $r) {
            $res[] = [
                'id' => $r->getId(),
                'text' => (string) $r,
            ];
        }

        return new Response(json_encode($res));
    }

    /**
     * @param string $property
     *
     * @return string
     */
    private function getGetterName($property)
    {
        $parts = explode('_', $property);
        $parts = array_map(
            function ($part) {
                return ucfirst($part);
            },
            $parts
        );
        $parts = implode($parts);
        $name = 'get'.$parts;

        return $name;
    }
}
