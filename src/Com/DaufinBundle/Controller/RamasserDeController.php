<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\RamasserDe;
use Com\DaufinBundle\Form\RamasserDeType;

/**
 * RamasserDe controller.
 *
 */
class RamasserDeController extends Controller
{

    /**
     * Lists all RamasserDe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:RamasserDe')->findAll();

        return $this->render('ComDaufinBundle:RamasserDe:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new RamasserDe entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new RamasserDe();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_Ramasser_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:RamasserDe:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a RamasserDe entity.
     *
     * @param RamasserDe $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RamasserDe $entity)
    {
        $form = $this->createForm(new RamasserDeType(), $entity, array(
            'action' => $this->generateUrl('com_Ramasser_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new RamasserDe entity.
     *
     */
    public function newAction()
    {
        $entity = new RamasserDe();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:RamasserDe:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RamasserDe entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:RamasserDe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RamasserDe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:RamasserDe:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RamasserDe entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:RamasserDe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RamasserDe entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:RamasserDe:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a RamasserDe entity.
    *
    * @param RamasserDe $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(RamasserDe $entity)
    {
        $form = $this->createForm(new RamasserDeType(), $entity, array(
            'action' => $this->generateUrl('com_Ramasser_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing RamasserDe entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:RamasserDe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RamasserDe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Ramasser_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:RamasserDe:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a RamasserDe entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:RamasserDe')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RamasserDe entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Ramasser'));
    }

    /**
     * Creates a form to delete a RamasserDe entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Ramasser_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
