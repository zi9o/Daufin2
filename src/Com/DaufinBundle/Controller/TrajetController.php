<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Com\DaufinBundle\Entity\Trajet;
use Com\DaufinBundle\Form\TrajetType;

/**
 * Trajet controller.
 *
 */
class TrajetController extends Controller
{

    /**
     * Lists all Trajet entities.
     * @Secure(roles="ROLE_SHOW_ALL_TRAJET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Trajet')->findAll();

        return $this->render('ComDaufinBundle:Trajet:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Trajet entity.
     * @Secure(roles="ROLE_ADD_TRAJET")
     */
    public function createAction(Request $request)
    {
        $entity = new Trajet();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_trajet_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Trajet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Trajet entity.
     *
     * @param Trajet $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Trajet $entity)
    {
        $form = $this->createForm(new TrajetType(), $entity, array(
            'action' => $this->generateUrl('com_trajet_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new Trajet entity.
     * @Secure(roles="ROLE_ADD_TRAJET")
     */
    public function newAction()
    {
        $entity = new Trajet();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Trajet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Trajet entity.
     * @Secure(roles="ROLE_SHOW_TRAJET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Trajet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trajet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Trajet:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Trajet entity.
     * @Secure(roles="ROLE_EDIT_TRAJET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Trajet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trajet entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Trajet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Trajet entity.
    *
    * @param Trajet $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Trajet $entity)
    {
        $form = $this->createForm(new TrajetType(), $entity, array(
            'action' => $this->generateUrl('com_trajet_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing Trajet entity.
     * @Secure(roles="ROLE_EDIT_TRAJET")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Trajet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trajet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_trajet_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Trajet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Trajet entity.
     * @Secure(roles="ROLE_DELETE_TRAJET")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Trajet')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Trajet entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_trajet'));
    }

    /**
     * Creates a form to delete a Trajet entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_trajet_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
