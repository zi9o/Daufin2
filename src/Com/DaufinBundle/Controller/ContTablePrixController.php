<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\ContTablePrix;
use Com\DaufinBundle\Form\ContTablePrixType;

/**
 * ContTablePrix controller.
 *
 */
class ContTablePrixController extends Controller
{

    /**
     * Lists all ContTablePrix entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:ContTablePrix')->findAll();

        return $this->render('ComDaufinBundle:ContTablePrix:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ContTablePrix entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ContTablePrix();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_ContTablePrix_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:ContTablePrix:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ContTablePrix entity.
     *
     * @param ContTablePrix $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ContTablePrix $entity)
    {
        $form = $this->createForm(new ContTablePrixType(), $entity, array(
            'action' => $this->generateUrl('com_ContTablePrix_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ContTablePrix entity.
     *
     */
    public function newAction()
    {
        $entity = new ContTablePrix();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:ContTablePrix:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ContTablePrix entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ContTablePrix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContTablePrix entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:ContTablePrix:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ContTablePrix entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ContTablePrix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContTablePrix entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:ContTablePrix:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ContTablePrix entity.
    *
    * @param ContTablePrix $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContTablePrix $entity)
    {
        $form = $this->createForm(new ContTablePrixType(), $entity, array(
            'action' => $this->generateUrl('com_ContTablePrix_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ContTablePrix entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ContTablePrix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContTablePrix entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_ContTablePrix_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:ContTablePrix:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ContTablePrix entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:ContTablePrix')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ContTablePrix entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_ContTablePrix'));
    }

    /**
     * Creates a form to delete a ContTablePrix entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_ContTablePrix_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
