<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\Ville;
use Com\DaufinBundle\Form\VilleType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Ville controller.
 *
 */
class VilleController extends Controller
{

    /**
     * Lists all Ville entities.
     * @Secure(roles="ROLE_SHOW_ALL_VILLE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Ville')->findAll();

        return $this->render('ComDaufinBundle:Ville:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Ville entity.
     * @Secure(roles="ROLE_SHOW_ADD_VILLE")
     */
    public function createAction(Request $request)
    {
        $entity = new Ville();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_ville_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Ville:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Ville entity.
     *
     * @param Ville $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ville $entity)
    {
        $form = $this->createForm(new VilleType(), $entity, array(
            'action' => $this->generateUrl('com_ville_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new Ville entity.
     * @Secure(roles="ROLE_SHOW_ADD_VILLE")
     */
    public function newAction()
    {
        $entity = new Ville();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Ville:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Ville entity.
     * @Secure(roles="ROLE_SHOW_SHOW_VILLE")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Ville')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ville entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Ville:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Ville entity.
     * @Secure(roles="ROLE_SHOW_EDIT_VILLE")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Ville')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ville entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Ville:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Ville entity.
    *
    * @param Ville $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ville $entity)
    {
        $form = $this->createForm(new VilleType(), $entity, array(
            'action' => $this->generateUrl('com_ville_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing Ville entity.
     * @Secure(roles="ROLE_SHOW_EDIT_VILLE")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Ville')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ville entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_ville_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Ville:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Ville entity.
     * @Secure(roles="ROLE_SHOW_EDIT_VILLE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Ville')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ville entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_ville'));
    }

    /**
     * Creates a form to delete a Ville entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_ville_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
