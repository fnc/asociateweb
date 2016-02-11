<?php

namespace asociateyaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use asociateyaBundle\Entity\Emprendimiento;
use asociateyaBundle\Entity\Usuario;
use asociateyaBundle\Entity\Inversion;
use asociateyaBundle\Entity\Comentario;
use asociateyaBundle\Entity\Notificacion;
use asociateyaBundle\Entity\NuevoComentario;
use asociateyaBundle\Entity\EmprendimientoAceptado;
use asociateyaBundle\Entity\EmprendimientoAprobado;
use asociateyaBundle\Entity\EmprendimientoCancelado;
use asociateyaBundle\Entity\NuevoEstadoResultado;
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


        if ($valorAccion <= 0) {
            return $this->render('asociateyaBundle::ay_mensaje_malo.html.twig', array('mensaje' => "Debe ingresar un valor de accion mayor a 0"));
        }

        if ($plazo<=0) {
            return $this->render('asociateyaBundle::ay_mensaje_malo.html.twig', array('mensaje' => "Debe ingresar un plazo mayor a 0."));
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendedor entity.');
        }

        $totalAcciones = (int)($entity->getMonto() / $valorAccion);

        $entity->setEstado(1);
        $entity->setFechaCreacion(new \DateTime());
        $entity->setTotalAcciones($totalAcciones);
        $entity->setAccionesRestantes($totalAcciones);
        $entity->setPrecioAccion($valorAccion);

        // agregar plazo por parametro
        $entity->setFechaFinalizacion(new \DateTime('+'.$plazo.' day'));



       $notificacionEmprendimiento = new EmprendimientoAceptado();
       $notificacionEmprendimiento->setUsuario($entity->getEmprendedor()->getUsuario());
       $notificacionEmprendimiento->setFechaCreacion(new \DateTime());
       $notificacionEmprendimiento->setEmprendimiento($entity);
       $em->persist($notificacionEmprendimiento);

       $em->flush();

        return $this->redirect($this->generateUrl('emprendedor_pendientes'));
    }

    /**
     * Rechaza un emprendimiento
     *
     */
    public function rechazarAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendedor entity.');
        }

      $em->remove($entity);

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
     * Muestra formulario de busqueda
     *
     */
    public function buscarAction()
    {
        $em = $this->getDoctrine()->getManager();

        if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {

          $entities = $em->getRepository('asociateyaBundle:Emprendimiento')->findAll();

        }
        else{

            $entities = $em->getRepository('asociateyaBundle:Emprendimiento')->findByEstado(1);
        }

        $categorias = $em->getRepository('asociateyaBundle:Categoria')->findAll();

        return $this->render('asociateyaBundle:Emprendimiento:buscar.html.twig', array(
            'entities' => $entities,
            'categorias' => $categorias,
        ));
    }

    /**
     * Devuelve resultados de busqueda
     *
     */
    public function buscarFiltroAction(Request $request)
    {
      $palabra = $request->query->get('palabra');
      $categorias = $request->query->get('categoria');
      $precioDesde = $request->query->get('precioDesde');
      $precioHasta = $request->query->get('precioHasta');
      $em = $this->getDoctrine()->getManager();

      $query = $em->getRepository("asociateyaBundle:Emprendimiento")->createQueryBuilder('e');
      $parameters = null;

         if($categorias){
            foreach ($categorias as $key => $categoria) {

               $cat = $em->getRepository('asociateyaBundle:Categoria')->findByNombre($categoria);
               if(!$cat){
                  //no se encontro la categoria
               }
               $query= $query->andWhere(':categoria'.$key.' MEMBER OF e.categorias' );
               $parameters['categoria'.$key]= $cat;
            }
         }

         if($precioHasta){
            $query= $query->andWhere('e.precioAccion <= :precioHasta');
            $parameters['precioHasta']= $precioHasta;
         }

         if($precioDesde){
            $query= $query->andWhere('e.precioAccion >= :precioDesde');
            $parameters['precioDesde']= $precioDesde;
         }

         if($palabra){
            $query= $query->andWhere('e.nombre LIKE :nombre');
            $parameters['nombre']='%'.$palabra . '%';
         }

         if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
            $query= $query->andwhere('e.estado = :estado');
            $parameters['estado']=1;
         }

         $entities = $query->setParameters($parameters)->getQuery()->getResult();
         return $this->render('asociateyaBundle:Emprendimiento:resultadosBusqueda.html.twig', array(
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

        $em->persist($entity);
        $em->flush();


        $notificacion = new NuevoComentario();
        $notificacion->setUsuario($emprendimiento->getEmprendedor()->getUsuario());
        $notificacion->setFechaCreacion(new \DateTime());
        $notificacion->setComentario($entity);

        $em->persist($notificacion);
        $em->flush();

        //mandar mail de notificacion
        $message = \Swift_Message::newInstance()
        ->setSubject("Un inversor hizo un comentario en el emprendimiento ".$emprendimiento->getNombre())//.$emprendimiento->getNombre())
        ->setFrom('noreply@asociateya.com')
        ->setTo($emprendimiento->getEmprendedor()->getUsuario()->getEmail())
        ->setBody($this->renderView('asociateyaBundle:Emails:notificacionComentario.html.twig',
                 array('emprendimiento' => $emprendimiento,
                    'mensaje' => $entity->getTexto())
             ),

            'text/html'
        );
        $this->get('mailer')->send($message);









        return $this->redirect($this->generateUrl('emprendimiento_show',array('id' => $id)));

    }

    /**
     * Crea una respuesta a un comentario.
     *
     */
    public function responderAction(Request $request, $id, $idComentario)
    {
        $em = $this->getDoctrine()->getManager();
        $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->find($id);
        $comentarioPadre = $em->getRepository('asociateyaBundle:Comentario')->find($idComentario);


        $comentarioRespuesta = new Comentario();
        $form = $this->createCreateComentarioForm($comentarioRespuesta, $id);
        $form->handleRequest($request);
        $comentarioRespuesta->setEmprendimiento($emprendimiento);
        $comentarioRespuesta->setUsuario($this->getUser());
        $comentarioRespuesta->setComentarioPadre($comentarioPadre);
        $comentarioRespuesta->setFechaCreacion(new \DateTime());
        $comentarioRespuesta->setLeido(0);

        $comentarioPadre->setComentarioHijo($comentarioRespuesta);

        $em->persist($comentarioRespuesta);
        $em->flush();

        $notificacion = new NuevoComentario();
        $notificacion->setUsuario($comentarioPadre->getUsuario());
        $notificacion->setFechaCreacion(new \DateTime());
        $notificacion->setComentario($comentarioRespuesta);

        $em->persist($notificacion);
        $em->flush();

        //mandar mail de notificacion
        $message = \Swift_Message::newInstance()
        ->setSubject("Un inversor hizo un comentario en el emprendimiento ".$emprendimiento->getNombre())//.$emprendimiento->getNombre())
        ->setFrom('noreply@asociateya.com')
        ->setTo($emprendimiento->getEmprendedor()->getUsuario()->getEmail())
        ->setBody($this->renderView('asociateyaBundle:Emails:notificacionComentario.html.twig',
                 array('emprendimiento' => $emprendimiento,
                    'mensaje' => $comentarioRespuesta->getTexto())
             ),

            'text/html'
        );
        $this->get('mailer')->send($message);


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


        if($entity->getAccionesRestantes()==0){
            return $this->render('asociateyaBundle::ay_mensaje_malo.html.twig', array('mensaje' => "Lo sentimos, ya no quedan acciones en este emprendimiento."));
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Emprendimiento:asociarse.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
