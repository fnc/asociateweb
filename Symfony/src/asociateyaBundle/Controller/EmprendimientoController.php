<?php

namespace asociateyaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use asociateyaBundle\Entity\Emprendimiento;
use asociateyaBundle\Entity\Inversion;
use asociateyaBundle\Entity\Comentario;
use asociateyaBundle\Form\EmprendimientoType;
use asociateyaBundle\Form\EmprendimientoEditType;
use asociateyaBundle\Form\ComentarioType;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * Emprendimiento controller.
 *
 */
class EmprendimientoController extends Controller
{


    /**
     * Aprueba a un emprendedor
     * estado = 1
     *
     */
    public function aprobarAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);



        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendedor entity.');
        }

        $entity->setEstado(1);
        $entity->setFechaCreacion(new \DateTime());

        //TODO agregar plazo por parametro
        $entity->setFechaFinalizacion(new \DateTime('+5 day'));

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

        $entities = $em->getRepository('asociateyaBundle:Emprendimiento')->findAll();

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
   ->where('e.nombre = :nombre') 
   ->setParameter('nombre', $palabraClave . '%')
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

        return $this->render('asociateyaBundle:Emprendimiento:listado.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Emprendimiento entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Emprendimiento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
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




        $cantidadAcciones = $request->request->get('cantidad');


        //Creo la nueva inversion
        $inversion = new Inversion();
        $inversion->setUsuario($this->getUser());
        $inversion->setEmprendimiento($entity);
        $inversion->setFechaEmision(new \DateTime());
        $inversion->setCantidadAcciones($cantidadAcciones);
        //Estado:  1= pendiente   2= acreditado
        $inversion->setEstado(0);
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
                    "quantity" => (int)$cantidadAcciones,
                    "unit_price" => 1
                )
            ),
            "back_urls" => array(
                    "success" => "success",
                    "pending" => "localhost:8000".$this->generateUrl('emprendimiento_pagoPendiente'),
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
    public function pagoPendienteAction()
    {
            $request = $this->getRequest();
            $request->query->get('collection_id');//ES EL ID DEL PAGO // get a $_GET parameter
            $request->query->get('preference_id');
            $request->query->get('collection_status');
            $request->query->get('external_reference');
            $request->query->get('payment_type');
            $request->query->get('merchant_order_id');
            //$request->request->get('myParam'); // get a $_POST parameter


        return $this->render('asociateyaBundle::ay_mensaje.html.twig', array(
            'mensaje'      => "Tu pago esta pendiente de acreditación"." ".$request->query->get('payment_type')." ".$request->query->get('collection_id'))
        );
    }

}
