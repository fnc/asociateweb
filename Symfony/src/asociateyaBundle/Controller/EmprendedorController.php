<?php

namespace asociateyaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use asociateyaBundle\Entity\Emprendedor;
use asociateyaBundle\Form\EmprendedorType;

/**
 * Emprendedor controller.
 *
 */
class EmprendedorController extends Controller
{

    /**
     * Aprueba a un emprendedor
     * estado = 1
     *
     */
    public function aprobarAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendedor entity.');
        }

        $entity->setEstado(1);
        $entity->getUsuario()->setRol('ROLE_EMPRENDEDOR');
        $entity->setFechaAprobacion(new \DateTime());

        $em->flush();

        return $this->redirect($this->generateUrl('emprendedor_pendientes'));
    }

    /**
     * Lists all Emprendedor entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('asociateyaBundle:Emprendedor')->findAll();

        return $this->render('asociateyaBundle:Emprendedor:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Lista los emprendedores pendientes de aprobacion
     * estado = 0
     *
     */
    public function pendientesAction()
    {   
        //SOLAMENTE EL CONTROLADOR DE EMPRENDIMIENTOS PUEDE APROBAR PENDIENTES
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Unable to access this page!');

        $em = $this->getDoctrine()->getManager();

        $emprendedores = $em->getRepository('asociateyaBundle:Emprendedor')->findByEstado(0);

        $emprendimientos = $em->getRepository('asociateyaBundle:Emprendimiento')->findByEstado(0);

        return $this->render('asociateyaBundle:Emprendedor:pendientes.html.twig', array(
            'emprendedores' => $emprendedores,'emprendimientos' => $emprendimientos
        ));
    }

    /**
     * Creates a new Emprendedor entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Emprendedor();
       // $form = $this->createCreateForm($entity);
        //$form->handleRequest($request);
        $entity->setUsuario($this->getUser());
        $entity->setEstado(0);
        $entity->setReputacion(0);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();



            return $this->redirect($this->generateUrl('emprendedor_show', array('id' => $entity->getId())));
        //}

        //return $this->render('asociateyaBundle:Emprendedor:new.html.twig', array(
        //    'entity' => $entity,
        //    'form'   => $form->createView(),
        //));
    }

    /**
     * Creates a form to create a Emprendedor entity.
     *
     * @param Emprendedor $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Emprendedor $entity)
    {
        $form = $this->createForm(new EmprendedorType(), $entity, array(
            'action' => $this->generateUrl('emprendedor_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Emprendedor entity.
     *
     */
    public function newAction()
    {

        $entity = new Emprendedor();
        // $form = $this->createCreateForm($entity);
        //$form->handleRequest($request);
        $entity->setUsuario($this->getUser());
        $entity->setEstado(0);
        $entity->setReputacion(0);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();



            return $this->redirect($this->generateUrl('emprendedor_newExito', array('id' => $entity->getId())));
        // $entity = new Emprendedor();
        // $form   = $this->createCreateForm($entity);

        // return $this->render('asociateyaBundle:Emprendedor:new.html.twig', array(
        //     'entity' => $entity,
        //     'form'   => $form->createView(),
        // ));
    }

     /**
     * muestra mensaje de aplicacion pendiente.
     *
     */
    public function newExitoAction()
    {
        return $this->render('asociateyaBundle::ay_mensaje.html.twig', array('mensaje' => "Se ha aplicado para ser emprendedor exitosamente"));
    }

    /**
     * Finds and displays a Emprendedor entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendedor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Emprendedor:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Emprendedor entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendedor entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Emprendedor:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Emprendedor entity.
    *
    * @param Emprendedor $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Emprendedor $entity)
    {
        $form = $this->createForm(new EmprendedorType(), $entity, array(
            'action' => $this->generateUrl('emprendedor_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Emprendedor entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Emprendedor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendedor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('emprendedor_edit', array('id' => $id)));
        }

        return $this->render('asociateyaBundle:Emprendedor:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Emprendedor entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('asociateyaBundle:Emprendedor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Emprendedor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('emprendedor'));
    }

    /**
     * Creates a form to delete a Emprendedor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('emprendedor_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
