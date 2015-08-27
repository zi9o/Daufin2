<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\Vehicule;
use Com\DaufinBundle\Form\VehiculeType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Vehicule controller.
 *
 */
class VehiculeController extends Controller
{

    /**
     * Lists all Vehicule entities.
     *  @Secure(roles="ROLE_SHOW_ALL_VEHICULE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Vehicule')->findAll();

        return $this->render('ComDaufinBundle:Vehicule:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Vehicule entity.
     * @Secure(roles="ROLE_ADD_VEHICULE")
     */
    public function createAction(Request $request)
    {
        $entity = new Vehicule();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_vehicule_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Vehicule:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Vehicule entity.
     *
     * @param Vehicule $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Vehicule $entity)
    {
        $form = $this->createForm(new VehiculeType(), $entity, array(
            'action' => $this->generateUrl('com_vehicule_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new Vehicule entity.
     * @Secure(roles="ROLE_ADD_VEHICULE")
     */
    public function newAction()
    {
        $entity = new Vehicule();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Vehicule:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Vehicule entity.
     * @Secure(roles="ROLE_SHOW_VEHICULE")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Vehicule')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehicule entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Vehicule:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Vehicule entity.
     * @Secure(roles="ROLE_EDIT_VEHICULE")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Vehicule')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehicule entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Vehicule:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Vehicule entity.
    *
    * @param Vehicule $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Vehicule $entity)
    {
        $form = $this->createForm(new VehiculeType(), $entity, array(
            'action' => $this->generateUrl('com_vehicule_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing Vehicule entity.
     * @Secure(roles="ROLE_EDIT_VEHICULE")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Vehicule')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vehicule entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_vehicule_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Vehicule:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Vehicule entity.
     * @Secure(roles="ROLE_DELETE_VEHICULE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Vehicule')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vehicule entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_vehicule'));
    }

    /**
     * Creates a form to delete a Vehicule entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_vehicule_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
