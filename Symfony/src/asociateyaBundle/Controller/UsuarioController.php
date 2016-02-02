<?php

namespace asociateyaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use asociateyaBundle\Entity\Usuario;
use asociateyaBundle\Entity\Notificacion;
use asociateyaBundle\Entity\Emprendimiento;
use asociateyaBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('asociateyaBundle:Usuario')->findAll();

        return $this->render('asociateyaBundle:Usuario:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Usuario entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId())));
        }

        return $this->render('asociateyaBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Usuario entity.
     *
     * @param Usuario $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createCreateForm($entity);

        return $this->render('asociateyaBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $emprendimientos = null;

        if($entity->getEmprendedor()){

            $emprendimientos = $em->getRepository('asociateyaBundle:Emprendimiento')->findByEmprendedor($entity->getEmprendedor());

        }

        $notificacionesComentario = $em->getRepository('asociateyaBundle:NuevoComentario')->findByUsuario($this->getUser());
        $notificacionesNuevoResultado = $em->getRepository('asociateyaBundle:NuevoEstadoResultado')->findByUsuario($this->getUser());
        $notificacionesNuevaInversion = $em->getRepository('asociateyaBundle:NuevaInversion')->findByUsuario($this->getUser());
        $notificacionesEmprendedorAceptado = $em->getRepository('asociateyaBundle:EmprendedorAceptado')->findByUsuario($this->getUser());
        $notificacionesEmprendimientoAceptado = $em->getRepository('asociateyaBundle:EmprendimientoAceptado')->findByUsuario($this->getUser());
        $notificacionesEmprendimientoCancelado = $em->getRepository('asociateyaBundle:EmprendimientoCancelado')->findByUsuario($this->getUser());
        $notificacionesEmprendimientoAprobado = $em->getRepository('asociateyaBundle:EmprendimientoAprobado')->findByUsuario($this->getUser());

        $notificaciones = $em->getRepository('asociateyaBundle:Notificacion')->findByUsuario($this->getUser());
        foreach ($notificaciones as $notif) {
           $notif->setFechaLectura(new \DateTime());
         }
         $em->flush();


        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Usuario:show.html.twig', array(
            'entity'      => $entity,
            'emprendimientos'      => $emprendimientos,
            'delete_form' => $deleteForm->createView(),
            'notificacionesComentario' => $notificacionesComentario,
            'notificacionesNuevoResultado' => $notificacionesNuevoResultado,
            'notificacionesNuevaInversion' => $notificacionesNuevaInversion,
            'notificacionesEmprendedorAceptado' => $notificacionesEmprendedorAceptado,
            'notificacionesEmprendimientoAceptado' => $notificacionesEmprendimientoAceptado,
            'notificacionesEmprendimientoCancelado' => $notificacionesEmprendimientoCancelado,
            'notificacionesEmprendimientoAprobado' => $notificacionesEmprendimientoAprobado,
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing Usuario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->render('asociateyaBundle::ay_mensaje.html.twig', array('mensaje' => "Sus datos han sido actualizados exitosamente."));
        }

        return $this->render('asociateyaBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Usuario entity.
     *
     */
    // public function deleteAction(Request $request, $id)
    // {
    //     $form = $this->createDeleteForm($id);
    //     $form->handleRequest($request);

    //     if ($form->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $entity = $em->getRepository('asociateyaBundle:Usuario')->find($id);

    //         if (!$entity) {
    //             throw $this->createNotFoundException('Unable to find Usuario entity.');
    //         }

    //         $em->remove($entity);
    //         $em->flush();
    //     }

    //     return $this->redirect($this->generateUrl('usuario'));
    // }
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Usuario')->find($id);

        if($entity->getEmprendedor()){//si es emprendedor
           if($entity->getEmprendedor()->getEstado()==1){
             return $this->render('asociateyaBundle::ay_mensaje_malo.html.twig', array('mensaje' => "Como usted es un emprendedor debe comunicarse con AsociateYa para darse de baja."));
          }
        }



        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $entity->setIsActive(false);

        $em->flush();

        return $this->redirect($this->generateUrl('asociateya_salir'));

    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
