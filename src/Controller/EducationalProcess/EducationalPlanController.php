<?php

namespace App\Controller\EducationalProcess;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Model\EducationalProcess\UseCase\EducationalPlan\Create;
use App\Model\EducationalProcess\UseCase\EducationalPlan\Edit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlan;
use App\ReadModel\EducationalProcess\EducationalPlan\EducationalPlanFetcher;

/**
 * @Route("/education/plan", name="education_plan")
 */

class EducationalPlanController extends AbstractController
{
    private const PER_PAGE = 50;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/", name="")
     * @param Request $request
     * @param EducationalPlanFetcher $fetcher
     * @return Response
     */
    public function list(Request $request, EducationalPlanFetcher $fetcher): Response
    {
        $pagination = $fetcher->all(
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'id'),
            $request->query->get('direction', 'desc')
        );

        return $this->render('educational_process/educational_plan/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/create/", name=".create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request, Create\Handler $handler): Response
    {
        $command = new Create\Command();

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $educationalPlan = $handler->handle($command);
                $this->addFlash('success', 'Создано успешно');
                return $this->redirectToRoute('education_plan.show', ['id' => $educationalPlan->getId()]);
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                // $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('educational_process/educational_plan/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show/", methods="GET", name=".show")
     * @param Request $request
     * @return Response
     */
    public function show(EducationalPlan $educationalPlan, Request $request): Response
    {
        return $this->render('educational_process/educational_plan/show.html.twig', [
            'data_show' => 'Data-Show',
            'educationalPlan' => $educationalPlan
        ]);
    }

    /**
     * @Route("/{id}/edit/", methods="GET", name=".edit")
     * @param Request $request
     * @return Response
     */
    public function edit(EducationalPlan $educationalPlan, Request $request): Response
    {
        $command = Edit\Command::fromEducationalPlan($educationalPlan);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                // $educationalPlan = $handler->handle($command);
                $this->addFlash('success', 'Создано успешно');
                return $this->redirectToRoute('education_plan.show', ['id' => $educationalPlan->getId()]);
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                // $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('educational_process/educational_plan/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
