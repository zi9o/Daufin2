<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\TypeValeur;
use Com\DaufinBundle\Form\TypeValeurType;

/**
 * TypeValeur controller.
 *
 */
class TypeValeurController extends Controller
{

    /**
     * Lists all TypeValeur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:TypeValeur')->findAll();

        return $this->render('ComDaufinBundle:TypeValeur:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TypeValeur entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TypeValeur();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_type_valeur_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:TypeValeur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TypeValeur entity.
     *
     * @param TypeValeur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeValeur $entity)
    {
        $form = $this->createForm(new TypeValeurType(), $entity, array(
            'action' => $this->generateUrl('com_type_valeur_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new TypeValeur entity.
     *
     */
    public function newAction()
    {
        $entity = new TypeValeur();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:TypeValeur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeValeur entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:TypeValeur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeValeur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:TypeValeur:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeValeur entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:TypeValeur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeValeur entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:TypeValeur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TypeValeur entity.
    *
    * @param TypeValeur $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TypeValeur $entity)
    {
        $form = $this->createForm(new TypeValeurType(), $entity, array(
            'action' => $this->generateUrl('com_type_valeur_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing TypeValeur entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:TypeValeur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeValeur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_type_valeur_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:TypeValeur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TypeValeur entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:TypeValeur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TypeValeur entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_type_valeur'));
    }

    /**
     * Creates a form to delete a TypeValeur entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_type_valeur_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
