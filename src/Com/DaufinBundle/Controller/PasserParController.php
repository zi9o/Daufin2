<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\PasserPar;
use Com\DaufinBundle\Form\PasserParType;

/**
 * PasserPar controller.
 *
 */
class PasserParController extends Controller
{

    /**
     * Lists all PasserPar entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:PasserPar')->findAll();

        return $this->render('ComDaufinBundle:PasserPar:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new PasserPar entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PasserPar();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_PasserPar_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:PasserPar:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a PasserPar entity.
     *
     * @param PasserPar $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PasserPar $entity)
    {
        $form = $this->createForm(new PasserParType(), $entity, array(
            'action' => $this->generateUrl('com_PasserPar_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PasserPar entity.
     *
     */
    public function newAction()
    {
        $entity = new PasserPar();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:PasserPar:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PasserPar entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:PasserPar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PasserPar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:PasserPar:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PasserPar entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:PasserPar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PasserPar entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:PasserPar:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a PasserPar entity.
    *
    * @param PasserPar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PasserPar $entity)
    {
        $form = $this->createForm(new PasserParType(), $entity, array(
            'action' => $this->generateUrl('com_PasserPar_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PasserPar entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:PasserPar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PasserPar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_PasserPar_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:PasserPar:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a PasserPar entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:PasserPar')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PasserPar entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_PasserPar'));
    }

    /**
     * Creates a form to delete a PasserPar entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_PasserPar_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
