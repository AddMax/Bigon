<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ExtraController extends AbstractController
{
    public function extra($parameter)
    {
        return new Response($parameter);
    }
}
