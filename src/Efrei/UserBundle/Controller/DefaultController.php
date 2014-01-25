<?php

namespace Efrei\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EfreiUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
