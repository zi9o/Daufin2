<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Com\DaufinBundle\Entity\Personnel;
use Com\DaufinBundle\Form\PersonnelType;

/**
 * Personnel controller.
 *
 */
class PersonnelController extends Controller
{

    /**
     * Lists all Personnel entities.
     * @Secure(roles="ROLE_SHOW_ALL_PERSONNEL")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Personnel')->findAll();

        return $this->render('ComDaufinBundle:Personnel:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Personnel entity.
     *  @Secure(roles="ROLE_ADD_PERSONNEL")
     */
    public function createAction(Request $request)
    {
        $entity = new Personnel();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_Personnel_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Personnel:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Personnel entity.
     *
     * @param Personnel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Personnel $entity)
    {
        $form = $this->createForm(new PersonnelType(), $entity, array(
            'action' => $this->generateUrl('com_Personnel_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new Personnel entity.
     *  @Secure(roles="ROLE_ADD_PERSONNEL")
     */
    public function newAction()
    {
        $entity = new Personnel();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Personnel:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Personnel entity.
     *  @Secure(roles="ROLE_SHOW_PERSONNEL")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Personnel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personnel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Personnel:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Personnel entity.
     *  @Secure(roles="ROLE_EDIT_PERSONNEL")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Personnel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personnel entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Personnel:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Personnel entity.
    *
    * @param Personnel $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Personnel $entity)
    {
        $form = $this->createForm(new PersonnelType(), $entity, array(
            'action' => $this->generateUrl('com_Personnel_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing Personnel entity.
     *  @Secure(roles="ROLE_EDIT_PERSONNEL")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Personnel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Personnel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Personnel_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Personnel:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Personnel entity.
     * @Secure(roles="ROLE_DELETE_PERSONNEL")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Personnel')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Personnel entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Personnel'));
    }

    /**
     * Creates a form to delete a Personnel entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Personnel_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
