<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ComDaufinBundle:Default:index.html.twig');
    }

}