<?php

namespace asociateyaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('asociateyaBundle:asociateYa:index.html.twig');// array('name' => $name));
    }
}
