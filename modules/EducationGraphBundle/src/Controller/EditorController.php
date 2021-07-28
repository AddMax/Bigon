<?php

namespace kudin\EducationGraphBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/graph/editor", name="graph_editor.") 
 */
class EditorController extends AbstractController
{
    private function emptyDatas()
    {
        $po = [':', '', '=', '//'];

        $week = 52;
        $courses = 4;
        $a = [];
        for ($cours = 1; $cours <= $courses; $cours++) {

            $w = array_map(function ($n, $k) use ($po) {
                return [
                    'week' => $k,
                    'val' => $po[array_rand($po)]
                ];
            }, array_fill(1, $week, ''), array_keys(array_fill(1, $week, '')));

            $a[] = $w;
        }
        return $a;
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        $serializer = $this->get('serializer');

        $inputed = $this->emptyDatas();
        dump($inputed);

        return $this->render('@EducationGraph/base.html.twig', [
            'inputed' => $serializer->serialize(is_array($inputed) ? $inputed : [], 'json'),
        ]);
        // return new Response('Privet');
    }
}
