<?php

namespace asociateyaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use asociateyaBundle\Entity\Usuario;
use asociateyaBundle\Entity\Emprendimiento;

/**
 * Notificacion controller.
 *
 */
class NotificacionController extends Controller
{
   /**
   * Lists all Notificacion entities.
   *
   */
   public function indexAction()
   {
      $em = $this->getDoctrine()->getManager();

      $notificacionesComentario = $em->getRepository('asociateyaBundle:NuevoComentario')->findByUsuario($this->getUser());

      return $this->render('asociateyaBundle:Notificacion:notificacionesComentarios.html.twig', array(
           'notificacionesComentario' => $notificacionesComentario,
      ));
   }
}
