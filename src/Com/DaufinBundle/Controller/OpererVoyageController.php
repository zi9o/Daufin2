<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\OpererVoyage;
use Com\DaufinBundle\Form\OpererVoyageType;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * OpererVoyage controller.
 *
 */
class OpererVoyageController extends Controller
{

    /**
     * Lists all OpererVoyage entities.
     * @Secure(roles="ROLE_SHOW_ALL_OPERATION_VOYAGE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:OpererVoyage')->findAll();

        return $this->render('ComDaufinBundle:OpererVoyage:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new OpererVoyage entity.
     * @Secure(roles="ROLE_ADD_OPERATION_VOYAGE")
     */
    public function createAction(Request $request)
    {
        $entity = new OpererVoyage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_Operer_voyage_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:OpererVoyage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a OpererVoyage entity.
     *
     * @param OpererVoyage $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(OpererVoyage $entity)
    {
        $form = $this->createForm(new OpererVoyageType(), $entity, array(
            'action' => $this->generateUrl('com_Operer_voyage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new OpererVoyage entity.
     * @Secure(roles="ROLE_ADD_OPERATION_VOYAGE")
     */
    public function newAction()
    {
        $entity = new OpererVoyage();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:OpererVoyage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OpererVoyage entity.
     * @Secure(roles="ROLE_SHOW_OPERATION_VOYAGE")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:OpererVoyage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpererVoyage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:OpererVoyage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OpererVoyage entity.
     * @Secure(roles="ROLE_EDIT_OPERATION_VOYAGE")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:OpererVoyage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpererVoyage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:OpererVoyage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a OpererVoyage entity.
    *
    * @param OpererVoyage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(OpererVoyage $entity)
    {
        $form = $this->createForm(new OpererVoyageType(), $entity, array(
            'action' => $this->generateUrl('com_Operer_voyage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing OpererVoyage entity.
     * @Secure(roles="ROLE_EDIT_OPERATION_VOYAGE")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:OpererVoyage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpererVoyage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Operer_voyage_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:OpererVoyage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a OpererVoyage entity.
     * @Secure(roles="ROLE_DELETE_OPERATION_VOYAGE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:OpererVoyage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OpererVoyage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Operer_voyage'));
    }

    /**
     * Creates a form to delete a OpererVoyage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Operer_voyage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
