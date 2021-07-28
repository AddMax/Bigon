<?php

namespace App\Controller\EducationalProcess;

use Psr\Log\LoggerInterface;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Model\EducationalProcess\UseCase\EducationalSchedule\Edit;
use App\Model\EducationalProcess\Entity\EducationalPlan\EducationalPlan;

/**
 * @Route("/education/schedule", name="education_schedule")
 */

class EducationalScheduleController extends AbstractController
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
    public function show(EducationalPlan $educationalPlan, Request $request, Edit\Handler $handler): Response
    {
        $command = new Edit\Command($educationalPlan);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                // dump($form); die;

                $handler->handle($command);
                $this->addFlash('success', 'Создано успешно');
                return $this->redirectToRoute('education_plan.show', ['id' => $educationalPlan->getId()]);
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                // $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('educational_process/educational_graph/show.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // /**
    //  * @Route("/{id}/show/", methods={"GET", "POST"}, name=".show")
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function show(EducationalPlan $educationalPlan, Request $request, Edit\Handler $handler): Response
    // {
    //     $command = new Edit\Command($educationalPlan);

    //     $form = $this->createForm(Edit\Form::class, $command);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         try {
    //             $handler->handle($command);
    //             $this->addFlash('success', 'Создано успешно');
    //             return $this->redirectToRoute('education_plan.show', ['id' => $educationalPlan->getId()]);
    //         } catch (\DomainException $e) {
    //             $this->logger->error($e->getMessage(), ['exception' => $e]);
    //             // $this->errors->handle($e);
    //             $this->addFlash('error', $e->getMessage());
    //         }
    //     }

    //     dump($command->educationalSchedule);

    //     return $this->render('educational_process/educational_schedule/show.html.twig', [
    //         'form' => $form->createView(),
    //         'educationalSchedule' => $command->educationalSchedule,
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/show/api/", methods="GET", name=".show.api")
    //  * @param EducationalPlan $educationalPlan
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function showAPI(EducationalPlan $educationalPlan, Request $request): Response
    // {
    //     $po=[':','','=','//'];

    //     $week = 52;
    //     $cours = 4;
    //     $w = array_map( function($n) use ($po){
    //         return $po[array_rand($po)];
    //     }, array_fill(1, $week, ''));
    //     $a = array_fill(1, $cours, $w);

    //     return $this->json($a,200);
    // }

    /**
     * @Route("/week", methods="POST", name=".week")
     * @param Request $request
     * @return Response
     */
    public function week(Request $request): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('photo', DropzoneType::class)
            ->add('message', Type\TextType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();

            return new Response('Data ajax! - ' . $datas['message'], 200);
        }

        // render just the form for AJAX, there is a validation error
        if ($request->isXmlHttpRequest()) {

            return $this->render('_form.html.twig', [
                'form' => $form->createView()
            ]);
        }

        return new Response('This is not ajax!', 400);
    }
}
