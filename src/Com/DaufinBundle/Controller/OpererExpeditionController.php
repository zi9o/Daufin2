<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Com\DaufinBundle\Entity\OpererExpedition;
use Com\DaufinBundle\Form\OpererExpeditionType;

/**
 * OpererExpedition controller.
 *
 */
class OpererExpeditionController extends Controller
{

    /**
     * Lists all OpererExpedition entities.
     * @Secure(roles="ROLE_SHOW_ALL_OPERATION_EXPEDITION")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:OpererExpedition')->findAll();

        return $this->render('ComDaufinBundle:OpererExpedition:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new OpererExpedition entity.
     * @Secure(roles="ROLE_ADD_OPERATION_EXPEDITION")
     */
    public function createAction(Request $request)
    {
        $entity = new OpererExpedition();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_Oprer_Expedition_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:OpererExpedition:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a OpererExpedition entity.
     *
     * @param OpererExpedition $entity The entity
     * @Secure(roles="ROLE_ADD_OPERATION_EXPEDITION")
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(OpererExpedition $entity)
    {
        $form = $this->createForm(new OpererExpeditionType(), $entity, array(
            'action' => $this->generateUrl('com_Oprer_Expedition_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new OpererExpedition entity.
     * @Secure(roles="ROLE_ADD_OPERATION_EXPEDITION")
     */
    public function newAction()
    {
        $entity = new OpererExpedition();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:OpererExpedition:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OpererExpedition entity.
     * @Secure(roles="ROLE_SHOW_OPERATION_EXPEDITION")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:OpererExpedition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpererExpedition entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:OpererExpedition:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OpererExpedition entity.
     * @Secure(roles="ROLE_EDIT_OPERATION_EXPEDITION")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:OpererExpedition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpererExpedition entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:OpererExpedition:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a OpererExpedition entity.
    *
    * @param OpererExpedition $entity The entity
    * @Secure(roles="ROLE_EDIT_OPERATION_EXPEDITION")
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(OpererExpedition $entity)
    {
        $form = $this->createForm(new OpererExpeditionType(), $entity, array(
            'action' => $this->generateUrl('com_Oprer_Expedition_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing OpererExpedition entity.
     * @Secure(roles="ROLE_EDIT_OPERATION_EXPEDITION")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:OpererExpedition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OpererExpedition entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Oprer_Expedition_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:OpererExpedition:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a OpererExpedition entity.
     * @Secure(roles="ROLE_DELETE_OPERATION_EXPEDITION")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:OpererExpedition')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OpererExpedition entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Oprer_Expedition'));
    }

    /**
     * Creates a form to delete a OpererExpedition entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Oprer_Expedition_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
