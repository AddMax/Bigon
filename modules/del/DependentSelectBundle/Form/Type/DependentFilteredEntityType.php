<?php

namespace Evercode\DependentSelectBundle\Form\Type;

use Evercode\DependentSelectBundle\Form\DataTransformer\EntityToIdTransformer;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DependentFilteredEntityType extends AbstractType
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'empty_value' => '',
            'entity_alias' => null,
            'parent_field' => null,
            'fallback_parent_field' => null,
            'compound' => false,
            'excluded_entity_id' => null,
            'choice_translation_domain' => false,
            'choice_title_translation_part' => null,
            'callback_parameters' => [],
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entities = $this->container->getParameter('dependent_select.dependent_filtered_entities');
        $options['class'] = $entities[$options['entity_alias']]['class'];
        $options['property'] = $entities[$options['entity_alias']]['property'];

        $options['no_result_msg'] = $entities[$options['entity_alias']]['no_result_msg'];

        $builder->addViewTransformer(new EntityToIdTransformer(
            $this->container->get('doctrine')->getManager(),
            $options['class']
        ), true);

        $builder->setAttribute('parent_field', $options['parent_field']);
        $builder->setAttribute('fallback_parent_field', $options['fallback_parent_field']);
        $builder->setAttribute('entity_alias', $options['entity_alias']);
        $builder->setAttribute('no_result_msg', $options['no_result_msg']);
        $builder->setAttribute('empty_value', $options['empty_value']);
        $builder->setAttribute('choice_translation_domain', $options['choice_translation_domain']);
        $builder->setAttribute('choice_title_translation_part', $options['choice_title_translation_part']);

        $builder->setAttribute('excluded_entity_id', $options['excluded_entity_id']);
        $builder->setAttribute('callback_parameters', $options['callback_parameters']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['parent_field'] = $form->getConfig()->getAttribute('parent_field');
        $view->vars['fallback_parent_field'] = $form->getConfig()->getAttribute('fallback_parent_field');
        $view->vars['entity_alias'] = $form->getConfig()->getAttribute('entity_alias');
        $view->vars['no_result_msg'] = $form->getConfig()->getAttribute('no_result_msg');
        $view->vars['empty_value'] = $form->getConfig()->getAttribute('empty_value');
        $view->vars['choice_translation_domain'] = $form->getConfig()->getAttribute('choice_translation_domain');
        $view->vars['choice_title_translation_part'] = $form->getConfig()->getAttribute('choice_title_translation_part');

        $view->vars['excluded_entity_id'] = $form->getConfig()->getAttribute('excluded_entity_id');
        $view->vars['callback_parameters'] = $form->getConfig()->getAttribute('callback_parameters');
    }
}