<?php

namespace App\Controller\Administration;

use Psr\Log\LoggerInterface;
use App\Model\User\Entity\User;
use App\Model\User\UseCase\Edit;
use App\Model\User\UseCase\Create;
use App\Model\User\UseCase\Remove;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\ReadModel\Administration\User\UserFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/users", name="admin_users")
 */

class UsersController extends AbstractController
{
    private const PER_PAGE = 50;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * @Route("/list", name=".list")
     * @param Request $request
     * @param UserFetcher $fetcher
     * @return Response
     */
    public function list(Request $request, UserFetcher $fetcher): Response
    {
        $pagination = $fetcher->all(
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'desc')
        );

        return $this->render('administration/users/list.html.twig', [
            'pagination'=> $pagination,
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Create\Handler $handler): Response
    {
        $command = new Create\Command();

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Сохранено успешно');
                return $this->redirectToRoute('admin_users.list');
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(),['exception'=>$e]);
                // $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('administration/users/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param User $user
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(User $user, Request $request, Edit\Handler $handler): Response
    {
        // if ($user->getId() === $this->getUser()->getId()) {
        //     $this->addFlash('error', 'Unable to edit yourself.');
        //     return $this->redirectToRoute('users.show', ['id' => $user->getId()]);
        // }

        $command = Edit\Command::fromUser($user);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Изменения внесены успешно');
                return $this->redirectToRoute('admin_users.list');
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(),['exception'=>$e]);
                // $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('administration/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

        /**
     * @Route("/{id}/delete", name=".delete")
     * @param User $user
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(User $user, Request $request, Remove\Handler $handler): Response
    {
        try {
            $handler->handle($user);
            $this->addFlash('success', 'Учетная запись успешно удалена');
        } catch (\DomainException $e) {
            $this->logger->error($e->getMessage(),['exception'=>$e]);
            // $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_users.list');

    }
}
