<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Com\DaufinBundle\Entity\Cheque;
use Com\DaufinBundle\Form\ChequeType;

/**
 * Cheque controller.
 *
 */
class ChequeController extends Controller
{

    /**
     * Lists all Cheque entities.
     *@Secure(roles="ROLE_SHOW_ALL_CHEQUE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Cheque')->findAll();

        return $this->render('ComDaufinBundle:Cheque:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Cheque entity.
     * @Secure(roles="ROLE_ADD_CHEQUE")
     */
    public function createAction(Request $request)
    {
        $entity = new Cheque();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_Cheque_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Cheque:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Cheque entity.
     *
     * @param Cheque $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Cheque $entity)
    {
        $form = $this->createForm(new ChequeType(), $entity, array(
            'action' => $this->generateUrl('com_Cheque_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Cheque entity.
     * @Secure(roles="ROLE_ADD_CHEQUE")
     */
    public function newAction()
    {
        $entity = new Cheque();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Cheque:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Cheque entity.
     * @Secure(roles="ROLE_CHEQUE_CHEQUE")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Cheque')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cheque entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Cheque:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Cheque entity.
     * @Secure(roles="ROLE_EDIT_CHEQUE")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Cheque')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cheque entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Cheque:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Cheque entity.
    *
    * @param Cheque $entity The entity
    * @Secure(roles="ROLE_EDIT_CHEQUE")
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Cheque $entity)
    {
        $form = $this->createForm(new ChequeType(), $entity, array(
            'action' => $this->generateUrl('com_Cheque_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Cheque entity.
     * @Secure(roles="ROLE_EDIT_CHEQUE")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Cheque')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cheque entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Cheque_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Cheque:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Cheque entity.
     * @Secure(roles="ROLE_DELETE_CHEQUE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Cheque')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Cheque entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Cheque'));
    }

    /**
     * Creates a form to delete a Cheque entity by id.
     *
     * @param mixed $id The entity id
     * @Secure(roles="ROLE_DELETE_CHEQUE")
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Cheque_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
