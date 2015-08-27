<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\SousTrajet;
use Com\DaufinBundle\Form\SousTrajetType;

/**
 * SousTrajet controller.
 *
 */
class SousTrajetController extends Controller
{

    /**
     * Lists all SousTrajet entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:SousTrajet')->findAll();

        return $this->render('ComDaufinBundle:SousTrajet:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SousTrajet entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SousTrajet();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_s_trajet_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:SousTrajet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SousTrajet entity.
     *
     * @param SousTrajet $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SousTrajet $entity)
    {
        $form = $this->createForm(new SousTrajetType(), $entity, array(
            'action' => $this->generateUrl('com_s_trajet_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new SousTrajet entity.
     *
     */
    public function newAction()
    {
        $entity = new SousTrajet();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:SousTrajet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SousTrajet entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:SousTrajet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SousTrajet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:SousTrajet:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SousTrajet entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:SousTrajet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SousTrajet entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:SousTrajet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SousTrajet entity.
    *
    * @param SousTrajet $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SousTrajet $entity)
    {
        $form = $this->createForm(new SousTrajetType(), $entity, array(
            'action' => $this->generateUrl('com_s_trajet_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing SousTrajet entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:SousTrajet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SousTrajet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_s_trajet_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:SousTrajet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SousTrajet entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:SousTrajet')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SousTrajet entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_s_trajet'));
    }

    /**
     * Creates a form to delete a SousTrajet entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_s_trajet_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
