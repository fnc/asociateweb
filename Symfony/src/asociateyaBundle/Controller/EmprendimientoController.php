<?php

namespace asociateyaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use asociateyaBundle\Entity\Emprendimiento;
use asociateyaBundle\Entity\Usuario;
use asociateyaBundle\Entity\Inversion;
use asociateyaBundle\Entity\Comentario;
use asociateyaBundle\Form\EmprendimientoType;
use asociateyaBundle\Form\EmprendimientoEditType;
use asociateyaBundle\Form\ComentarioType;
use Symfony\Component\HttpFoundation\Session\Session;
use asociateyaBundle\Controller\mercadopago;



/**
 * Emprendimiento controller.
 *
 */
class EmprendimientoController extends Controller
{


    /**
     * Acepta a un emprendimiento
     * estado = 1
     *
     */
    public function aprobarAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);

        $valorAccion = (int) $request->request->get('valor_accion');
        $plazo = (int) $request->request->get('plazo');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendedor entity.');
        }

        $totalAcciones = (int)($entity->getMonto() / $valorAccion);

        $entity->setEstado(1);
        $entity->setFechaCreacion(new \DateTime());
        $entity->setTotalAcciones($totalAcciones);
        $entity->setAccionesRestantes($totalAcciones);
        $entity->setPrecioAccion($valorAccion);

        //TODO agregar plazo por parametro
        $entity->setFechaFinalizacion(new \DateTime('+'.$plazo.' day'));

        $em->flush();

        return $this->redirect($this->generateUrl('emprendedor_pendientes'));
    }


    /**
     * Lists all Emprendimiento entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('asociateyaBundle:Emprendimiento')->findAll();

        return $this->render('asociateyaBundle:Emprendimiento:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Muestra formulario de busqueda y resultados
     *
     */
    public function buscarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('asociateyaBundle:Emprendimiento')->findByEstado(1);

        return $this->render('asociateyaBundle:Emprendimiento:buscar.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Muestra formulario de busqueda y resultados
     *
     */
    public function buscarPalabraAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $palabraClave = $request->request->get('search_field');

        $entities = $em->getRepository("asociateyaBundle:Emprendimiento")->createQueryBuilder('e')
   ->where('e.nombre LIKE :nombre AND e.estado = :estado') 
   ->setParameters(array('nombre'=>'%'.$palabraClave . '%', 'estado'=>1))
   ->getQuery()
   ->getResult();


        return $this->render('asociateyaBundle:Emprendimiento:buscar.html.twig', array(
            'entities' => $entities,
        ));
    }



    /**
     * Lista emprendimientos propios.
     *
     */
    public function listadoAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('asociateyaBundle:Emprendimiento')->findByEmprendedor($this->getUser()->getEmprendedor());

        $participo = $em->getRepository('asociateyaBundle:Inversion')
            ->createQueryBuilder('e')
            ->where('e.usuario = :usuario') 
            ->setParameter('usuario',$this->getUser())
            ->groupBy('e.emprendimiento')
            ->getQuery()
            ->getResult();

        return $this->render('asociateyaBundle:Emprendimiento:listado.html.twig', array(
            'entities' => $entities,
            'participo' => $participo,
        ));
    }

    /**
     * Creates a new Emprendimiento entity.
     *
     */
    public function createAction(Request $request)
    {
        
        $this->denyAccessUnlessGranted('ROLE_EMPRENDEDOR', null, 'Esta funcion es solo para Emprendedores!');

        $entity = new Emprendimiento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        //Estados 0=pendienteaceptar  1=aceptado 2=aprobado(financiado) 3=canceladoPagoPendiente 4=CanceladoPagoAcreditado
        // 5=vencidoCon80Fincanciado(decide el emprendedor)  6= aprobado con pagos pendientes
        $entity->setEstado(0);
        $entity->setAccionesRestantes($entity->getTotalAcciones());
        $entity->setRanking(0);
        $entity->setFechaCreacion(new \DateTime());
        $entity->setEmprendedor($this->getUser()->getEmprendedor());

        if ($form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $entity->getRutaImagen();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $imagesDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/emprendimientos';
            $file->move($imagesDir, $fileName);

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $entity->setRutaImagen($fileName);


            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('emprendimiento_listado'));
        }

        return $this->render('asociateyaBundle:Emprendimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Emprendimiento entity.
     *
     * @param Emprendimiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Emprendimiento $entity)
    {
        $form = $this->createForm(new EmprendimientoType(), $entity, array(
            'action' => $this->generateUrl('emprendimiento_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Aplicar','attr' => array('class' => 'boton_submit')));

        return $form;
    }

    /**
     * Displays a form to create a new Emprendimiento entity.
     *
     */
    public function newAction()
    {
        $this->denyAccessUnlessGranted('ROLE_EMPRENDEDOR', null, 'Esta funcion es solo para Emprendedores!');

        $entity = new Emprendimiento();
        $form   = $this->createCreateForm($entity);

        return $this->render('asociateyaBundle:Emprendimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Emprendimiento entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);
        $comentarios = $em->getRepository('asociateyaBundle:Comentario')->findByEmprendimiento($id);
        
        $comentarioNuevo = new Comentario();
        $formComentario   = $this->createCreateComentarioForm($comentarioNuevo,$id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Emprendimiento:show.html.twig', array(
            'entity'      => $entity,
            'comentarios' => $comentarios,
            'formComentario' => $formComentario->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Emprendimiento entity.
    *
    * @param Emprendimiento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Emprendimiento $entity)
    {
        $form = $this->createForm(new EmprendimientoEditType(), $entity, array(
            'action' => $this->generateUrl('emprendimiento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar','attr' => array('class' => 'boton_submit')));

        return $form;
    }

    /**
     * Displays a form to edit an existing Emprendimiento entity.
     *
     */
    public function editAction($id)
    {

        //SOLAMENTE EL CONTROLADOR DE EMPRENDIMIENTOS PUEDE EDITAR EMPRENDIMIENTOS EN LA WEB
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Emprendimiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Edits an existing Emprendimiento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
             $em->flush();

            return $this->redirect($this->generateUrl('emprendimiento_edit', array('id' => $id)));
        }


        return $this->render('asociateyaBundle:Emprendimiento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Emprendimiento entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('emprendimiento'));
    }

    /**
     * Creates a form to delete a Emprendimiento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('emprendimiento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Crea un comentario.
     *
     */
    public function comentarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);


        $entity = new Comentario();
        $form = $this->createCreateComentarioForm($entity, $id);
        $form->handleRequest($request);
        $entity->setEmprendimiento($emprendimiento);
        $entity->setUsuario($this->getUser());
        $entity->setFechaCreacion(new \DateTime());
        $entity->setLeido(0);

        


            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            
 

        return $this->redirect($this->generateUrl('emprendimiento_show',array('id' => $id)));

    }

    /**
     * Creates a form to create a Emprendimiento entity.
     *
     * @param Emprendimiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateComentarioForm(Comentario $entity, $id)
    {
        $form = $this->createForm(new ComentarioType(), $entity, array(
            'action' => $this->generateUrl('emprendimiento_comentar',array('id' => $id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Comentar','attr' => array('class' => 'boton_submit')));

        return $form;
    }




    /**
     * Displays a form to edit an existing Emprendimiento entity.
     *
     */
    public function asociarseAction($id)
    {

        //SOLAMENTE EL CONTROLADOR DE EMPRENDIMIENTOS PUEDE EDITAR EMPRENDIMIENTOS EN LA WEB
        $this->denyAccessUnlessGranted('ROLE_INVERSOR', null, 'Unable to access this page!');

        $session = new Session();
        $session->set('name', 'Drak');


        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
        }


        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Emprendimiento:asociarse.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        $entity = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
        }




        $cantidadAcciones = (int) $request->request->get('cantidad');


        //Creo la nueva inversion
        $inversion = new Inversion();
        $inversion->setUsuario($this->getUser());
        $inversion->setEmprendimiento($entity);
        $inversion->setFechaEmision(new \DateTime());
        $inversion->setCantidadAcciones($cantidadAcciones);
        //Estado:  1= pendiente   2= acreditado 3=refunded
        $inversion->setEstado(0);
        $entity->setAccionesRestantes(((int)$entity->getAccionesRestantes())-$cantidadAcciones);
        $em->persist($inversion);
        $em->flush();

        require_once ('mercadopago.php');

        $mp = new \MP ("813635953433843","42DSugNu5tAKsQMj6QicKloh6Jvege3D");
        
        //$mp = new MP("YOUR_CLIENT_ID", "YOUR_CLIENT_SECRET");

        $preference_data = array(
            "items" => array(
                array(
                    "title" => "Inversion en ". $entity->getNombre().$session->get('name').$cantidadAcciones,
                    "description" =>  $entity->getDescripcionCorta(),
                    "picture_url" => $this->container->getParameter('kernel.root_dir').'/../web/uploads/emprendimientos'.$entity->getrutaimagen(),
                    "currency_id" => "ARS",
                    "quantity" => $cantidadAcciones,
                    "unit_price" => (int)$entity->getPrecioAccion(),
                )
            ),
            "back_urls" => array(
                    "success" => "success",
                    "pending" => "localhost:8000".$this->generateUrl('emprendimiento_pagoPendiente',array('idInversion'=>$inversion->getId())),
                    "failure" => "failure",

                ),
            "notification_url" => "186.136.173.35"
        );

        $preference = $mp->create_preference($preference_data);

        return $this->render('asociateyaBundle:Emprendimiento:confirmacionPago.html.twig', array(
            'entity'      => $entity,
            'initPoint' => $preference["response"]["init_point"],
        ));
    }
    

    /**
     * Muestra pagina con mensaje de pago pendiente
     *
     */
    public function pagoPendienteAction($idInversion)
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

            $inversion = $em->getRepository('asociateyaBundle:Inversion')->find($idInversion);
            $inversion->setEstado(1);//pago pendiente
            $inversion->setIdPago($idDePago);
            $inversion->setIdUsuarioMP($paymentInfo["response"]["collection"]["payer"]["id"]);
            $em->flush();


        return $this->render('asociateyaBundle::ay_mensaje.html.twig', array(
            'mensaje'      => "Tu pago esta pendiente de acreditación")
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


        return $this->render('asociateyaBundle:Emprendimiento:pagosControlador.html.twig', array(
            'pagos' => $searchResult)
        );
    }

    /**
     * Muestra pagina con mensaje de pago pendiente
     *
     */
    public function pagarGananciasAction(Request $request)
    {
        require_once ('mercadopago.php');        
        $mp = new \MP ("813635953433843","42DSugNu5tAKsQMj6QicKloh6Jvege3D");



        return $this->render('asociateyaBundle:Emprendimiento:pagosControlador.html.twig', array(
            'pagos' => $searchResult)
        );
    }

    /**
     * Muestra pagina con el boton de mercadopago par que el emprendedor pague a asociateya los refunds
     *
     */
    public function confirmarPagoRefundAction(Request $request,$id)
    {

        $this->denyAccessUnlessGranted('ROLE_EMPRENDEDOR', null, 'Unable to access this page!');


        //Obtengo info para trabajar
        $session = $request->getSession();

        $em = $this->getDoctrine()->getManager();

        $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);

        if (!$emprendimiento) {
            throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
        }

        if ((int)$emprendimiento->getTotalAcciones()-(int)$emprendimiento->getAccionesRestantes()==0) {
            $emprendimiento->setEstado(4);//candelado

            $em->flush();

            return $this->render('asociateyaBundle::ay_mensaje.html.twig', array(
                'mensaje'      => "Se ha cancelado el emprendimiento.")
        );
        }

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
                    "success" => "localhost:8000".$this->generateUrl('emprendimiento_pagoAcreditadoRefund',array('idEmprendimiento'=>$emprendimiento->getId())),
                    "pending" => "localhost:8000".$this->generateUrl('emprendimiento_pagoPendienteRefund',array('idEmprendimiento'=>$emprendimiento->getId())),
                    "failure" => "failure",

                ),
            "notification_url" => "186.136.173.35"
        );

        $preference = $mp->create_preference($preference_data);

        $em->flush();

        return $this->render('asociateyaBundle:Emprendimiento:confirmacionPago.html.twig', array(
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

            //TODO devolver dinero de cada inversion
            $inversiones = $emprendimiento->getInversiones();

            require_once ('mercadopago.php');

            $mp = new MP ("813635953433843", "42DSugNu5tAKsQMj6QicKloh6Jvege3D");


            foreach ($inversiones as $inversion) {
                
                $resultado = $mp->refund_payment($inversion->getIdPago());

                $inversion->setEstado(3);//refunded

                $comisionRefund = (float)$inversion->getCantidadAcciones()*(float)$emprendimiento->getPrecioAccion()*(0.0495);

                //TODO completar bien la info del pago

                $payment_data = array(
                    "transaction_amount" => $comisionRefund,
                    "token" => "42DSugNu5tAKsQMj6QicKloh6Jvege3D",
                    "description" => "Devolucion a usuario ".$inversion->getUsuario()->getNombreUsuario()." por la cancelacion del emprendimiento ".$emprendimiento->getNombre() ,
                    "installments" => 1,
                    "payer" => array ("id" => "12345678"),
                    "payment_method_id" => "visa",
                    "application_fee" => 0
                    );

                $payment = $mp->post("/v1/payments", $payment_data);

                //print_r($resultado["status"]);

            }

            $em->flush();


        return $this->render('asociateyaBundle::ay_mensaje.html.twig', array(
            'mensaje'      => "Tu pago fue acreditado")
        );
    }


}
