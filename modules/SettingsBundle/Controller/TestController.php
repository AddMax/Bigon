<?php

namespace kudin\SettingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController extends AbstractController
{
    public function testAction(Request $request): Response
    {
    return new Response('test',200);
    }

}
