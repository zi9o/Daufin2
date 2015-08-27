<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\TrajetSTrajet;
use Com\DaufinBundle\Form\TrajetSTrajetType;

/**
 * TrajetSTrajet controller.
 *
 */
class TrajetSTrajetController extends Controller
{

    /**
     * Lists all TrajetSTrajet entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:TrajetSTrajet')->findAll();

        return $this->render('ComDaufinBundle:TrajetSTrajet:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TrajetSTrajet entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TrajetSTrajet();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_trajet_s_trajet_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:TrajetSTrajet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TrajetSTrajet entity.
     *
     * @param TrajetSTrajet $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TrajetSTrajet $entity)
    {
        $form = $this->createForm(new TrajetSTrajetType(), $entity, array(
            'action' => $this->generateUrl('com_trajet_s_trajet_create'),
            'method' => 'POST',
        ));

                $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new TrajetSTrajet entity.
     *
     */
    public function newAction()
    {
        $entity = new TrajetSTrajet();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:TrajetSTrajet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TrajetSTrajet entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:TrajetSTrajet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TrajetSTrajet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:TrajetSTrajet:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrajetSTrajet entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:TrajetSTrajet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TrajetSTrajet entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:TrajetSTrajet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TrajetSTrajet entity.
    *
    * @param TrajetSTrajet $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TrajetSTrajet $entity)
    {
        $form = $this->createForm(new TrajetSTrajetType(), $entity, array(
            'action' => $this->generateUrl('com_trajet_s_trajet_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

                $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing TrajetSTrajet entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:TrajetSTrajet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TrajetSTrajet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_trajet_s_trajet_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:TrajetSTrajet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TrajetSTrajet entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:TrajetSTrajet')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TrajetSTrajet entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_trajet_s_trajet'));
    }

    /**
     * Creates a form to delete a TrajetSTrajet entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_trajet_s_trajet_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
