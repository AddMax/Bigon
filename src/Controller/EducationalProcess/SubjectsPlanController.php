<?php

namespace App\Controller\EducationalProcess;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlan;

/**
 * @Route("/education/subjects", name="education_subjects")
 */

class SubjectsPlanController extends AbstractController
{

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/{id}/show/", methods={"GET", "POST"}, name=".show") 
     * @param Request $request
     * @return Response
     */
    public function show(EducationalPlan $educationalPlan, Request $request): Response
    {
        // $command = new Edit\Command($educationalPlan);

        // $form = $this->createForm(Edit\Form::class, $command);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     try {
        //         dump($form); die();
        //         // $handler->handle($command);
        //         $this->addFlash('success', 'Создано успешно');
        //         return $this->redirectToRoute('education_plan.show', ['id' => $educationalPlan->getId()]);
        //     } catch (\DomainException $e) {
        //         $this->logger->error($e->getMessage(), ['exception' => $e]);
        //         // $this->errors->handle($e);
        //         $this->addFlash('error', $e->getMessage());
        //     }
        // }


        return $this->render('educational_process/subjects_plan/show.html.twig', [
            // 'form' => $form->createView(),
            // 'educationalSchedule' => $command->educationalSchedule,
        ]);
    }
}
