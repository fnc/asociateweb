<?php

namespace asociateyaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use asociateyaBundle\Entity\Emprendimiento;
use asociateyaBundle\Entity\Usuario;
use asociateyaBundle\Entity\Inversion;
use asociateyaBundle\Entity\Comentario;
use asociateyaBundle\Entity\NuevaInversion;
use asociateyaBundle\Entity\NuevoEstadoResultado;
use asociateyaBundle\Entity\EmprendimientoAprobado;
use asociateyaBundle\Entity\EmprendimientoCancelado;
use asociateyaBundle\Entity\Pago;
use asociateyaBundle\Entity\PagoInversion;
use asociateyaBundle\Form\EmprendimientoType;
use asociateyaBundle\Form\EmprendimientoEditType;
use asociateyaBundle\Form\ComentarioType;
use Symfony\Component\HttpFoundation\Session\Session;
use asociateyaBundle\Controller\mercadopago;



/**
 * Inversion controller.
 *
 */
class InversionController extends Controller
{

   /**
   * Lista las inversiones del usuario logueado.
   *
   */
   public function indexAction()
   {
      $this->denyAccessUnlessGranted('ROLE_INVERSOR', null, 'Unable to access this page!');

      $em = $this->getDoctrine()->getManager();

      $inversiones = $em->getRepository('asociateyaBundle:Inversion')->findByUsuario($this->getUser());

      return $this->render('asociateyaBundle:Inversion:index.html.twig', array(
           'inversiones' => $inversiones,
      ));
   }

   /**
   * Lista las inversiones de un emprendimiento.
   *
   */
   public function porEmprendimientoAction($emprendimientoId)
   {
      $this->denyAccessUnlessGranted('ROLE_INVERSOR', null, 'Unable to access this page!');

      $em = $this->getDoctrine()->getManager();

      $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($emprendimientoId);

      $inversiones = $em->getRepository('asociateyaBundle:Inversion')->findByEmprendimiento($emprendimiento);

      return $this->render('asociateyaBundle:Inversion:index.html.twig', array(
           'inversiones' => $inversiones,
      ));
   }

    /**
     * Muestra pagina con el boton de mercadopago
     *
     */
    public function confirmarPagoAction(Request $request,$id)
    {

        //SOLAMENTE EL CONTROLADOR DE EMPRENDIMIENTOS PUEDE EDITAR EMPRENDIMIENTOS EN LA WEB
        $this->denyAccessUnlessGranted('ROLE_INVERSOR', null, 'Unable to access this page!');


        //Obtengo info para trabajar
        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();


        $cantidadAcciones = (int) $request->request->get('cantidad');

        $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);
        if (!$emprendimiento) {
            throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
        }


        if($cantidadAcciones>$emprendimiento->getAccionesRestantes()){
            return $this->render('asociateyaBundle::ay_mensaje_malo.html.twig', array('mensaje' => "No Hay suficientes acciones disponibles, solo quedan ".$emprendimiento->getAccionesRestantes()." acciones.")
            );
        }




        require_once ('mercadopago.php');

        $mp = new \MP ("813635953433843","42DSugNu5tAKsQMj6QicKloh6Jvege3D");

        //$mp = new MP("YOUR_CLIENT_ID", "YOUR_CLIENT_SECRET");

        $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

        $preference_data = array(
            "items" => array(
                array(
                    "title" => "Inversion en ". $emprendimiento->getNombre(),
                    "description" =>  $emprendimiento->getDescripcionCorta(),
                    "picture_url" => $baseurl."/uploads/emprendimientos/".$emprendimiento->getrutaimagen(),
                    "currency_id" => "ARS",
                    "quantity" => $cantidadAcciones,
                    "unit_price" => (int)$emprendimiento->getPrecioAccion(),
                )
            ),
            "back_urls" => array(
                    "success" => $baseurl.$this->generateUrl('inversion_pagoAcreditado',array('idEmprendimiento'=>$id)),
                    "pending" => $baseurl.$this->generateUrl('inversion_pagoPendiente',array('idEmprendimiento'=>$id)),
                    "failure" => "failure",

                ),
            "notification_url" => "186.136.173.35"
        );

        $preference = $mp->create_preference($preference_data);

        return $this->render('asociateyaBundle:Emprendimiento:confirmacionPago.html.twig', array(
            'emprendimiento'      => $emprendimiento,
            'initPoint' => $preference["response"]["init_point"],
        ));
    }


    /**
     * Muestra pagina con mensaje de pago pendiente
     *
     */
    public function pagoPendienteAction($idEmprendimiento)
    {
            $request = $this->getRequest();
            $request->query->get('collection_id');//ES EL ID DEL PAGO // get a $_GET parameter
            $request->query->get('preference_id');
            $request->query->get('collection_status');
            $request->query->get('external_reference');
            $request->query->get('payment_type');
            $request->query->get('merchant_order_id');
            //$request->request->get('myParam'); // get a $_POST parameter

            require_once ('mercadopago.php');

            $mp = new \MP ("813635953433843", "42DSugNu5tAKsQMj6QicKloh6Jvege3D");
            $idDePago=$request->query->get('collection_id');
            $paymentInfo = $mp->get_payment ($idDePago);
            $preference = $mp->get_preference($request->query->get('preference_id'));
            $cantidadAcciones = $preference["response"]["items"][0]["quantity"];

            $em = $this->getDoctrine()->getManager();


            //Verificacion de pago existente
            $pago = $em->getRepository('asociateyaBundle:PagoInversion')->findOneByIdMp($idDePago);
            if($pago){
               throw $this->createNotFoundException('El pago con id de mercadopago '.$idDePago.' ya fue registrado anteriormente.');
            }



            //TODO Busco una inversion en este emprendimiento por este usuario (cambiar idInversion por idEmprendimiento)
            //y si no encuentra, creo una. Lo mismo en el metodo de abajo.
            $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($idEmprendimiento);
            if (!$emprendimiento) {
                throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
            }
            //Si ya invirtio en este emprendimiento no creo una inversion nueva!!
            $inversion = $em->getRepository('asociateyaBundle:Inversion')->findOneBy(array('usuario' => $this->getUser(), 'emprendimiento' => $emprendimiento));

            if($inversion){
               //Actualizo la inversion
               $inversion->setCantidadAcciones($inversion->getCantidadAcciones()+$cantidadAcciones);
            }
            else{
               //Creo la nueva inversion
               $inversion = new Inversion();
               $inversion->setUsuario($this->getUser());
               $inversion->setEmprendimiento($emprendimiento);
               $inversion->setFechaEmision(new \DateTime());
               //TODO obtener el quantity
               $inversion->setCantidadAcciones($cantidadAcciones);
               //Estado: 0= no se realizo el pago 1= pendiente   2= acreditado 3=refunded
               $em->persist($inversion);
            }
            $emprendimiento->setAccionesRestantes(((int)$emprendimiento->getAccionesRestantes())-$cantidadAcciones);
            $em->flush();


            $notificacion = new NuevaInversion();
            $notificacion->setUsuario($emprendimiento->getEmprendedor()->getUsuario());
            $notificacion->setFechaCreacion(new \DateTime());
            $notificacion->setInversion($inversion);
            $em->persist($notificacion);
            $em->flush();

            //CREA UN PAGO Y PONE ESTO DE ABAJO, EN EL PAGO VA EL MONTO PAGADO. TODOS LOS PAGOS ASOCIADOS A UNA INVERSION EN ALGUN MOMENTO VAN A TENER QUE ESTAR ACREDITADOS
            // sumando lso montos de los pagos acreditados se puede saber cuantas acciones acreditadas hay actualmente (dividiendo por el precio de accion)
            $pago = new PagoInversion();
            $pago->setInversion($inversion);
            $pago->setEstado(1);//pago pendiente
            $pago->setIdMp($idDePago);
            $pago->setIdMPUser($paymentInfo["response"]["collection"]["payer"]["id"]);
            $pago->setMonto($paymentInfo["response"]["collection"]["transaction_amount"]);
            $pago->setFechaEmision(new \DateTime());
            //TODO Bug, por alguna razon tambien se setea la fecha de cobro. Esto es porque el script inicial esta mal armado
            $em->persist($pago);

            //verificacion emprendimiento aprobado
            if($inversion->getEmprendimiento()->getAccionesRestantes()==0){

                    $inversion->getEmprendimiento()->setEstado(6);//aprobado con pagos pendientes
            }

            $em->flush();


        return $this->render('asociateyaBundle::ay_mensaje.html.twig', array(
            'mensaje'      => "Tu pago esta pendiente de acreditación")
        );
    }

   /**
   * Muestra pagina con mensaje de pago Acreditado
   *
   */
   public function pagoAcreditadoAction($idEmprendimiento)
   {
            $request = $this->getRequest();
            $request->query->get('collection_id');//ES EL ID DEL PAGO // get a $_GET parameter
            $request->query->get('preference_id');
            $request->query->get('collection_status');
            $request->query->get('external_reference');
            $request->query->get('payment_type');
            $request->query->get('merchant_order_id');
            //$request->request->get('myParam'); // get a $_POST parameter

            require_once ('mercadopago.php');

            $mp = new \MP ("813635953433843", "42DSugNu5tAKsQMj6QicKloh6Jvege3D");
            $idDePago=$request->query->get('collection_id');
            $paymentInfo = $mp->get_payment ($idDePago);
            $preference = $mp->get_preference($request->query->get('preference_id'));
            $cantidadAcciones = $preference["response"]["items"][0]["quantity"];

            $em = $this->getDoctrine()->getManager();

            //Verificacion de pago existente
            $pago = $em->getRepository('asociateyaBundle:PagoInversion')->findOneByIdMp($idDePago);
            if($pago){
               throw $this->createNotFoundException('El pago con id de mercadopago '.$idDePago.' ya fue registrado anteriormente.');
            }

            //TODO Busco una inversion en este emprendimiento por este usuario (cambiar idInversion por idEmprendimiento)
            //y si no encuentra, creo una. Lo mismo en el metodo de abajo.
            $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($idEmprendimiento);
            if (!$emprendimiento) {
               throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
            }
            //Si ya invirtio en este emprendimiento no creo una inversion nueva!!
            $inversion = $em->getRepository('asociateyaBundle:Inversion')->findOneBy(array('usuario' => $this->getUser(), 'emprendimiento' => $emprendimiento));

            if($inversion){
               //Actualizo la inversion
               $inversion->setCantidadAcciones($inversion->getCantidadAcciones()+$cantidadAcciones);
            }
            else{
               //Creo la nueva inversion
               $inversion = new Inversion();
               $inversion->setUsuario($this->getUser());
               $inversion->setEmprendimiento($emprendimiento);
               $inversion->setFechaEmision(new \DateTime());
               //TODO obtener el quantity
               $inversion->setCantidadAcciones($cantidadAcciones);
               //Estado: 0= no se realizo el pago 1= pendiente   2= acreditado 3=refunded
               $em->persist($inversion);
            }
            $emprendimiento->setAccionesRestantes(((int)$emprendimiento->getAccionesRestantes())-$cantidadAcciones);
            $em->flush();


            $notificacion = new NuevaInversion();
            $notificacion->setUsuario($emprendimiento->getEmprendedor()->getUsuario());
            $notificacion->setFechaCreacion(new \DateTime());
            $notificacion->setInversion($inversion);
            $em->persist($notificacion);
            $em->flush();


            // CREAR UN PAGO Y PONER ESTO DE ABAJO, EN EL PAGO VA EL MONTO PAGADO. TODOS LOS PAGOS ASOCIADOS A UNA INVERSION EN ALGUN MOMENTO VAN A TENER QUE ESTAR ACREDITADOS
            // sumando lso montos de los pagos acreditados se puede saber cuantas acciones acreditadas hay actualmente (dividiendo por el preci ode accion)
            //TODO no olvidarse de las notificaciones NIPC
            $pago = new PagoInversion();
            $pago->setInversion($inversion);
            $pago->setEstado(2);//pago Acreditado
            $pago->setIdMp($idDePago);
            $pago->setIdMPUser($paymentInfo["response"]["collection"]["payer"]["id"]);
            $pago->setMonto($paymentInfo["response"]["collection"]["transaction_amount"]);
            $pago->setFechaEmision(new \DateTime());
            $pago->setFechaCobro(new \DateTime());
            $em->persist($pago);


            //verificacion emprendimiento aprobado
            if($inversion->getEmprendimiento()->getAccionesRestantes()==0){
              //TODO este if esta mal tengo que ver las inversiones si esta todas acreditadas(uso getEstado en inversion)
              $retval = false;
              foreach ($inversion->getEmprendimiento()->getInversiones() as $unaInversion) {
                if ($unaInversion->getEstado()=="Pendiente") {
                  $retval = true;
                }
              }
                if($retval){
                    $inversion->getEmprendimiento()->setEstado(6);//aprobado con pagos pendientes
                }
                else{
                    $inversion->getEmprendimiento()->setEstado(2);//aprobado con pagos acreditados
                    $notificacionEmprendimiento = new EmprendimientoAprobado();
                    $notificacionEmprendimiento->setUsuario($inversion->getEmprendimiento()->getEmprendedor()->getUsuario());
                    $notificacionEmprendimiento->setFechaCreacion(new \DateTime());
                    $notificacionEmprendimiento->setEmprendimiento($inversion->getEmprendimiento());
                    $em->persist($notificacionEmprendimiento);
                }
            }

            $em->flush();


        return $this->render('asociateyaBundle::ay_mensaje.html.twig', array(
            'mensaje'      => "Tu pago fue acreditado exitosamente!")
        );
    }

/**
 * maneja la notificacion de mercadopago cuando se acredita un pago
 *http://localhost:8000/inversion/pagoAceditadoRetrasado?collection_id=1775916360
 *
 */
public function pagoAcreditadoRetrasadoAction( Request $request )
{
        $request = $this->getRequest();
        $request->query->get('collection_id');//ES EL ID DEL PAGO // get a $_GET parameter
        $request->query->get('preference_id');
        $request->query->get('collection_status');
        $request->query->get('external_reference');
        $request->query->get('payment_type');
        $request->query->get('merchant_order_id');
        //$request->request->get('myParam'); // get a $_POST parameter

        require_once ('mercadopago.php');

        $mp = new \MP ("813635953433843", "42DSugNu5tAKsQMj6QicKloh6Jvege3D");
        $idDePago=$request->query->get('collection_id');
        $paymentInfo = $mp->get_payment ($idDePago);


        $em = $this->getDoctrine()->getManager();
//TODO verificar la payment info que de verdad este acreditada

        $pago = $em->getRepository('asociateyaBundle:PagoInversion')->findOneByIdMp($idDePago);

        if($pago){
          $pago->setEstado(2);//pago Acreditado
          $pago->setFechaCobro(new \DateTime());
          $inversion = $pago->getInversion();

          //verificacion emprendimiento aprobado
          if($inversion->getEmprendimiento()->getAccionesRestantes()==0){
            //TODO este if esta mal tengo que ver las inversiones si esta todas acreditadas(uso getEstado en inversion)
            $retval = false;
            foreach ($inversion->getEmprendimiento()->getInversiones() as $unaInversion) {
              if ($unaInversion->getEstado()=="Pendiente") {
                $retval = true;
              }
            }
              if($retval){
                  $inversion->getEmprendimiento()->setEstado(6);//aprobado con pagos pendientes
              }
              else{
                  $inversion->getEmprendimiento()->setEstado(2);//aprobado con pagos acreditados
                  $notificacionEmprendimiento = new EmprendimientoAprobado();
                  $notificacionEmprendimiento->setUsuario($inversion->getEmprendimiento()->getEmprendedor()->getUsuario());
                  $notificacionEmprendimiento->setFechaCreacion(new \DateTime());
                  $notificacionEmprendimiento->setEmprendimiento($inversion->getEmprendimiento());
                  $em->persist($notificacionEmprendimiento);
              }
          }

          $em->flush();
        }


    return $this->render('asociateyaBundle::ay_mensaje.html.twig', array(
        'mensaje'      => "Tu pago fue acreditado exitosamente!")
    );
}




    /**
     * Muestra pagina con mensaje de pago pendiente
     *
     */
    public function pagosControlAction()
    {
        require_once ('mercadopago.php');
        $mp = new \MP ("813635953433843","42DSugNu5tAKsQMj6QicKloh6Jvege3D");
        // Filtros de la consulta
        $filters = array(
            "range" => "date_created",
            "begin_date" => "2014-10-21T00:00:00Z",
            "end_date" => "NOW",
            //"operation_type" => "regular_payment"
        );

        $searchResult = $mp->search_payment($filters);


        return $this->render('asociateyaBundle:Inversion:pagosControlador.html.twig', array(
            'pagos' => $searchResult)
        );
    }

    /**
     * Muestra pagina con mensaje de pago pendiente
     *
     */
    public function pagarGananciasAction(Request $request,$id)
    {
        $em = $this->get('doctrine')->getManager();

        $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);



        if (!$emprendimiento) {

        }

        //recorrer inversiones

        $inversiones = $emprendimiento->getInversiones();

        $porGanancia = (float) $request->request->get('ganancia');

        return $this->render('asociateyaBundle:Emprendimiento:pagoGanancias.html.twig', array(
            'emprendimiento' => $emprendimiento,
            'inversiones' => $inversiones,
            'porGanancia' => $porGanancia)
        );
    }


    /**
     * Muestra pagina con mensaje de pago pendiente
     *
     */
    public function pagarGananciasNotificarAction($id)
    {
        $em = $this->get('doctrine')->getManager();

        $usuario = $em->getRepository('asociateyaBundle:Usuario')->find($id);


        //mandar mail de notificacion
        $message = \Swift_Message::newInstance()
        ->setSubject("Se le han acreditado ganancias.")
        ->setFrom('noreply@asociateya.com')
        ->setTo($usuario->getEmail())
        ->setBody($this->renderView('asociateyaBundle:Emails:notificacionGanancias.html.twig',
                 array()
             ),
            'text/html'
        );
        $this->get('mailer')->send($message);


        return $this->render('asociateyaBundle::ay_mensaje.html.twig', array(
                'mensaje'      => "Se notificado correctamente"));
    }

    /**
     * Muestra pagina con el boton de mercadopago par que el emprendedor pague a asociateya los refunds
     *
     */
    public function confirmarPagoRefundAction(Request $request,$id)
    {

        $this->denyAccessUnlessGranted('ROLE_EMPRENDEDOR', null, 'Unable to access this page!');
        //TODO REVISAR LO RELACIONADO CON CANCELAR

        //Obtengo info para trabajar
        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();

        $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);

        if (!$emprendimiento) {
            throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
        }

        //SI NADIE INVIRTIO AUN
        if ((int)$emprendimiento->getTotalAcciones()-(int)$emprendimiento->getAccionesRestantes()==0) {
            $emprendimiento->setEstado(4);//candelado

            $em->flush();

            return $this->render('asociateyaBundle::ay_mensaje.html.twig', array('mensaje'      => "Se ha cancelado el emprendimiento."));
        }

        //SI HAY INVERSIONES HECHAS

        $montoAPagar =  ((float)$emprendimiento->getTotalAcciones()-(float)$emprendimiento->getAccionesRestantes())*(float)$emprendimiento->getPrecioAccion()*(0.0495);
        $emprendimiento->setEstado(3);//candelado pendiente de pago
        $inversionesADarDeBaja = $em->getRepository('asociateyaBundle:Inversion')
            ->createQueryBuilder('e')
            ->where('e.emprendimiento = :emprendimiento')
            ->setParameter('emprendimiento',$emprendimiento)
            ->groupBy('e.emprendimiento')
            ->getQuery()
            ->getResult();



        require_once ('mercadopago.php');

        $mp = new \MP ("813635953433843","42DSugNu5tAKsQMj6QicKloh6Jvege3D");

        //$mp = new MP("YOUR_CLIENT_ID", "YOUR_CLIENT_SECRET");

        $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();

        $preference_data = array(
            "items" => array(
                array(
                    "title" => "Comision por cancelacion de emprendimiento". $emprendimiento->getNombre(),
                    "currency_id" => "ARS",
                    "quantity" => 1,
                    "unit_price" => $montoAPagar,
                )
            ),
            "back_urls" => array(
                    "success" => $baseurl.$this->generateUrl('inversion_pagoAcreditadoRefund',array('idEmprendimiento'=>$emprendimiento->getId())),
                    "pending" => $baseurl.$this->generateUrl('inversion_pagoPendienteRefund',array('idEmprendimiento'=>$emprendimiento->getId())),
                    "failure" => "failure",

                ),
            "notification_url" => $baseurl //TODO poner controlador que reciba la notificacion de acreditado
        );

        $preference = $mp->create_preference($preference_data);

        $em->flush();

        return $this->render('asociateyaBundle:Emprendimiento:confirmacionPagoRefund.html.twig', array(
            'entity'      => $emprendimiento,
            'initPoint' => $preference["response"]["init_point"],
        ));
    }

     /**
     * Muestra pagina con mensaje de pago pendiente del refund
     *
     */
    public function pagoPendienteRefundAction($idEmprendimiento)
    {
            $request = $this->getRequest();
            $request->query->get('collection_id');//ES EL ID DEL PAGO // get a $_GET parameter

            $idDePago=$request->query->get('collection_id');

            $em = $this->getDoctrine()->getManager();

            $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($idEmprendimiento);

            $emprendimiento->setIdRefund($idDePago);

            $emprendimiento->setEstado(3);//canceladoPagoPendiente

            $em->flush();

        return $this->render('asociateyaBundle::ay_mensaje.html.twig', array(
            'mensaje'      => "Tu pago esta pendiente de acreditación")
        );
    }

    /**
     * Muestra pagina con mensaje de pago aceditado del refund
     *
     */
    public function pagoAcreditadoRefundAction($idEmprendimiento)
    {
            $request = $this->getRequest();

            $request->query->get('collection_id');//ES EL ID DEL PAGO // get a $_GET parameter

            $idDePago=$request->query->get('collection_id');

            $em = $this->getDoctrine()->getManager();

            $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($idEmprendimiento);

            $emprendimiento->setIdRefund($idDePago);

            $emprendimiento->setEstado(4);//canceladoPagoAcreditado



            //devolver dinero de cada inversion
            $inversiones = $emprendimiento->getInversiones();

            require_once ('mercadopago.php');

            $mp = new MP ("813635953433843", "42DSugNu5tAKsQMj6QicKloh6Jvege3D");


            foreach ($inversiones as $inversion) {
               foreach ($inversion->getPagos() as $pago ) {

                   $resultado = $mp->refund_payment($pago->getIdMp());

                   $pago->setEstado(3);//refunded

                   //TODO esto no se usa porque el refund aparentemente devuelve la comision
                   $comisionRefund = (float)$pago->getMonto()*(0.0495);

                   $notificacionEmprendimiento = new EmprendimientoCancelado();
                   $notificacionEmprendimiento->setUsuario($inversion->getUsuario());
                   $notificacionEmprendimiento->setFechaCreacion(new \DateTime());
                   $notificacionEmprendimiento->setEmprendimiento($inversion->getEmprendimiento());
                   $em->persist($notificacionEmprendimiento);
               }
            }

            $em->flush();


        //mandar mail de notificacion
        $message = \Swift_Message::newInstance()
        ->setSubject("Se ha dado de baja el emprendimiento ".$emprendimiento->getNombre())
        ->setFrom('noreply@asociateya.com')
        ->setTo($emprendimiento->getEmprendedor()->getUsuario()->getEmail())
        ->setBody($this->renderView('asociateyaBundle:Emails:notificacionBajaEmprendimiento.html.twig',
                 array()
             ),
            'text/html'
        );
        $this->get('mailer')->send($message);


        return $this->render('asociateyaBundle::ay_mensaje.html.twig', array(
            'mensaje'      => "Tu pago fue acreditado")
        );
    }


}
