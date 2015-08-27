<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\SuivService;
use Com\DaufinBundle\Form\SuivServiceType;

/**
 * SuivService controller.
 *
 */
class SuivServiceController extends Controller
{

    /**
     * Lists all SuivService entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:SuivService')->findAll();

        return $this->render('ComDaufinBundle:SuivService:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SuivService entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SuivService();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_suiv_service_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:SuivService:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SuivService entity.
     *
     * @param SuivService $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SuivService $entity)
    {
        $form = $this->createForm(new SuivServiceType(), $entity, array(
            'action' => $this->generateUrl('com_suiv_service_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SuivService entity.
     *
     */
    public function newAction()
    {
        $entity = new SuivService();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:SuivService:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SuivService entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:SuivService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SuivService entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:SuivService:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SuivService entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:SuivService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SuivService entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:SuivService:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SuivService entity.
    *
    * @param SuivService $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SuivService $entity)
    {
        $form = $this->createForm(new SuivServiceType(), $entity, array(
            'action' => $this->generateUrl('com_suiv_service_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing SuivService entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:SuivService')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SuivService entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_suiv_service_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:SuivService:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a SuivService entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:SuivService')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SuivService entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_suiv_service'));
    }

    /**
     * Creates a form to delete a SuivService entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_suiv_service_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
