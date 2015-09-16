<?php

namespace asociateyaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use asociateyaBundle\Entity\Emprendimiento;
use asociateyaBundle\Form\EmprendimientoType;

/**
 * Emprendimiento controller.
 *
 */
class EmprendimientoController extends Controller
{

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

        $form->add('submit', 'submit', array('label' => 'Aplicar'));

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

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emprendimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Emprendimiento:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Emprendimiento entity.
     *
     */
    public function editAction($id)
    {
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
    * Creates a form to edit a Emprendimiento entity.
    *
    * @param Emprendimiento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Emprendimiento $entity)
    {
        $form = $this->createForm(new EmprendimientoType(), $entity, array(
            'action' => $this->generateUrl('emprendimiento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
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
}
