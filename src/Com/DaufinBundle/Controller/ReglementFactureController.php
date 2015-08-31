<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Com\DaufinBundle\Entity\ReglementFacture;
use Com\DaufinBundle\Form\ReglementFactureType;

/**
 * ReglementFacture controller.
 *
 * @Route("/com_RegleFacture")
 */
class ReglementFactureController extends Controller
{

    /**
     * Lists all ReglementFacture entities.
     *
     * @Route("/", name="com_RegleFacture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:ReglementFacture')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ReglementFacture entity.
     *
     * @Route("/", name="com_RegleFacture_create")
     * @Method("POST")
     * @Template("ComDaufinBundle:ReglementFacture:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ReglementFacture();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_RegleFacture_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ReglementFacture entity.
     *
     * @param ReglementFacture $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ReglementFacture $entity)
    {
        $form = $this->createForm(new ReglementFactureType(), $entity, array(
            'action' => $this->generateUrl('com_RegleFacture_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ReglementFacture entity.
     *
     * @Route("/new", name="com_RegleFacture_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ReglementFacture();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ReglementFacture entity.
     *
     * @Route("/{id}", name="com_RegleFacture_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ReglementFacture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReglementFacture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ReglementFacture entity.
     *
     * @Route("/{id}/edit", name="com_RegleFacture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ReglementFacture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReglementFacture entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a ReglementFacture entity.
    *
    * @param ReglementFacture $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ReglementFacture $entity)
    {
        $form = $this->createForm(new ReglementFactureType(), $entity, array(
            'action' => $this->generateUrl('com_RegleFacture_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ReglementFacture entity.
     *
     * @Route("/{id}", name="com_RegleFacture_update")
     * @Method("PUT")
     * @Template("ComDaufinBundle:ReglementFacture:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ReglementFacture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ReglementFacture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_RegleFacture_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ReglementFacture entity.
     *
     * @Route("/{id}", name="com_RegleFacture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:ReglementFacture')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ReglementFacture entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_RegleFacture'));
    }

    /**
     * Creates a form to delete a ReglementFacture entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_RegleFacture_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
