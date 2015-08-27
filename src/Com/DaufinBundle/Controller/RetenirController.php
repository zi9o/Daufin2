<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\Retenir;
use Com\DaufinBundle\Form\RetenirType;

/**
 * Retenir controller.
 *
 */
class RetenirController extends Controller
{

    /**
     * Lists all Retenir entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Retenir')->findAll();

        return $this->render('ComDaufinBundle:Retenir:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Retenir entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Retenir();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_Retenir_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Retenir:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Retenir entity.
     *
     * @param Retenir $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Retenir $entity)
    {
        $form = $this->createForm(new RetenirType(), $entity, array(
            'action' => $this->generateUrl('com_Retenir_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Retenir entity.
     *
     */
    public function newAction()
    {
        $entity = new Retenir();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Retenir:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Retenir entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Retenir')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Retenir entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Retenir:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Retenir entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Retenir')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Retenir entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Retenir:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Retenir entity.
    *
    * @param Retenir $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Retenir $entity)
    {
        $form = $this->createForm(new RetenirType(), $entity, array(
            'action' => $this->generateUrl('com_Retenir_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Retenir entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Retenir')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Retenir entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Retenir_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Retenir:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Retenir entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Retenir')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Retenir entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Retenir'));
    }

    /**
     * Creates a form to delete a Retenir entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Retenir_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
