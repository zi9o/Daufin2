<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\Crbt;
use Com\DaufinBundle\Form\CrbtType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Crbt controller.
 *
 */
class CrbtController extends Controller
{

    /**
     * Lists all Crbt entities.
     * @Secure(roles="ROLE_SHOW_ALL_CRBT")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Crbt')->findAll();

        return $this->render('ComDaufinBundle:Crbt:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Crbt entity.
     *  @Secure(roles="ROLE_ADD_CRBT")
     */
    public function createAction(Request $request)
    {
        $entity = new Crbt();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_Crbt_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Crbt:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Crbt entity.
     *
     * @param Crbt $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Crbt $entity)
    {
        $form = $this->createForm(new CrbtType(), $entity, array(
            'action' => $this->generateUrl('com_Crbt_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Crbt entity.
     *  @Secure(roles="ROLE_ADD_CRBT")
     */
    public function newAction()
    {
        $entity = new Crbt();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Crbt:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Crbt entity.
     *  @Secure(roles="ROLE_SHOW_CRBT")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Crbt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Crbt entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Crbt:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Crbt entity.
     *  @Secure(roles="ROLE_EDIT_CRBT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Crbt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Crbt entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Crbt:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Crbt entity.
    *
    * @param Crbt $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Crbt $entity)
    {
        $form = $this->createForm(new CrbtType(), $entity, array(
            'action' => $this->generateUrl('com_Crbt_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Crbt entity.
     *  @Secure(roles="ROLE_EDIT_CRBT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Crbt')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Crbt entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Crbt_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Crbt:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Crbt entity.
     *  @Secure(roles="ROLE_DELETE_CRBT")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Crbt')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Crbt entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Crbt'));
    }

    /**
     * Creates a form to delete a Crbt entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Crbt_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
