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
      $notificacionesNuevoResultado = $em->getRepository('asociateyaBundle:NuevoEstadoResultado')->findByUsuario($this->getUser());
      $notificacionesNuevaInversion = $em->getRepository('asociateyaBundle:NuevaInversion')->findByUsuario($this->getUser());
      $notificacionesEmprendedorAceptado = $em->getRepository('asociateyaBundle:EmprendedorAceptado')->findByUsuario($this->getUser());
      $notificacionesEmprendimientoAceptado = $em->getRepository('asociateyaBundle:EmprendimientoAceptado')->findByUsuario($this->getUser());
      $notificacionesEmprendimientoCancelado = $em->getRepository('asociateyaBundle:EmprendimientoCancelado')->findByUsuario($this->getUser());
      $notificacionesEmprendimientoAprobado = $em->getRepository('asociateyaBundle:EmprendimientoAprobado')->findByUsuario($this->getUser());

      return $this->render('asociateyaBundle:Notificacion:notificacionesComentarios.html.twig', array(
           'notificacionesComentario' => $notificacionesComentario,
           'notificacionesNuevoResultado' => $notificacionesNuevoResultado,
           'notificacionesNuevaInversion' => $notificacionesNuevaInversion,
           'notificacionesEmprendedorAceptado' => $notificacionesEmprendedorAceptado,
           'notificacionesEmprendimientoAceptado' => $notificacionesEmprendimientoAceptado,
           'notificacionesEmprendimientoCancelado' => $notificacionesEmprendimientoCancelado,
           'notificacionesEmprendimientoAprobado' => $notificacionesEmprendimientoAprobado,
      ));
   }
}
