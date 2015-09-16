<?php

namespace asociateyaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use asociateyaBundle\Entity\Categoria;
use asociateyaBundle\Form\CategoriaType;

/**
 * Categoria controller.
 *
 */
class CategoriaController extends Controller
{

    /**
     * Lists all Categoria entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('asociateyaBundle:Categoria')->findAll();

        return $this->render('asociateyaBundle:Categoria:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Categoria entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Categoria();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categoria_show', array('id' => $entity->getId())));
        }

        return $this->render('asociateyaBundle:Categoria:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Categoria entity.
     *
     * @param Categoria $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Categoria $entity)
    {
        $form = $this->createForm(new CategoriaType(), $entity, array(
            'action' => $this->generateUrl('categoria_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Categoria entity.
     *
     */
    public function newAction()
    {
        $entity = new Categoria();
        $form   = $this->createCreateForm($entity);

        return $this->render('asociateyaBundle:Categoria:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Categoria entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Categoria:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Categoria entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('asociateyaBundle:Categoria:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Categoria entity.
    *
    * @param Categoria $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Categoria $entity)
    {
        $form = $this->createForm(new CategoriaType(), $entity, array(
            'action' => $this->generateUrl('categoria_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Categoria entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('asociateyaBundle:Categoria')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Categoria entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('categoria_edit', array('id' => $id)));
        }

        return $this->render('asociateyaBundle:Categoria:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Categoria entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('asociateyaBundle:Categoria')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Categoria entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('categoria'));
    }

    /**
     * Creates a form to delete a Categoria entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoria_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
