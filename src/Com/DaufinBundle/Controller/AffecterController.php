<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\Affecter;
use Com\DaufinBundle\Form\AffecterType;

/**
 * Affecter controller.
 *
 */
class AffecterController extends Controller
{

    /**
     * Lists all Affecter entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Affecter')->findAll();

        return $this->render('ComDaufinBundle:Affecter:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Affecter entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Affecter();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_affecter_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Affecter:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Affecter entity.
     *
     * @param Affecter $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Affecter $entity)
    {
        $form = $this->createForm(new AffecterType(), $entity, array(
            'action' => $this->generateUrl('com_affecter_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Affecter entity.
     *
     */
    public function newAction()
    {
        $entity = new Affecter();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Affecter:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Affecter entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Affecter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Affecter:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Affecter entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Affecter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Affecter:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Affecter entity.
    *
    * @param Affecter $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Affecter $entity)
    {
        $form = $this->createForm(new AffecterType(), $entity, array(
            'action' => $this->generateUrl('com_affecter_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Affecter entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Affecter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_affecter_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Affecter:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Affecter entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Affecter')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Affecter entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_affecter'));
    }

    /**
     * Creates a form to delete a Affecter entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_affecter_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
