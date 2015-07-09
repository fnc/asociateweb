<?php

namespace asociateyaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('asociateyaBundle:Default:index.html.twig', array('name' => $name));
    }
}
