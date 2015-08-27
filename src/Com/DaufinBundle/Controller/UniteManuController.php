<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\UniteManu;
use Com\DaufinBundle\Form\UniteManuType;

/**
 * UniteManu controller.
 *
 */
class UniteManuController extends Controller
{

    /**
     * Lists all UniteManu entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:UniteManu')->findAll();

        return $this->render('ComDaufinBundle:UniteManu:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new UniteManu entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new UniteManu();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_unite_manu_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:UniteManu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a UniteManu entity.
     *
     * @param UniteManu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(UniteManu $entity)
    {
        $form = $this->createForm(new UniteManuType(), $entity, array(
            'action' => $this->generateUrl('com_unite_manu_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UniteManu entity.
     *
     */
    public function newAction()
    {
        $entity = new UniteManu();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:UniteManu:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UniteManu entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:UniteManu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UniteManu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:UniteManu:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UniteManu entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:UniteManu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UniteManu entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:UniteManu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a UniteManu entity.
    *
    * @param UniteManu $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UniteManu $entity)
    {
        $form = $this->createForm(new UniteManuType(), $entity, array(
            'action' => $this->generateUrl('com_unite_manu_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing UniteManu entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:UniteManu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UniteManu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_unite_manu_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:UniteManu:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a UniteManu entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:UniteManu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UniteManu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_unite_manu'));
    }

    /**
     * Creates a form to delete a UniteManu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_unite_manu_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
