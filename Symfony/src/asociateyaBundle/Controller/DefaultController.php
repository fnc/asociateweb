<?php

namespace asociateyaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use asociateyaBundle\Entity\Emprendimiento;

class DefaultController extends Controller
{
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();

      $query = $em->getRepository("asociateyaBundle:Emprendimiento")->createQueryBuilder('e')->andwhere('e.estado = :estado')->orderBy("e.id", 'DESC')->setMaxResults(3);
      $parameters['estado']=1;
      $emprendimientosNuevos = $query->setParameters($parameters)->getQuery()->getResult();

      return $this->render('asociateyaBundle:asociateYa:index.html.twig', array('emprendimientos' => $emprendimientosNuevos));
    }
}
