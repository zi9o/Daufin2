<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\Expedition;
use Com\DaufinBundle\Form\ExpeditionType;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * Expedition controller.
 *
 */
class ExpeditionController extends Controller
{

    /**
     * Lists all Expedition entities.
     * use JMS\SecurityExtraBundle\Annotation\Secure;
     * @Secure(roles="ROLE_SHOW_ALL_EXPEDITION")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Expedition')->findAll();

        return $this->render('ComDaufinBundle:Expedition:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Expedition entity.
     * @Secure(roles="ROLE_ADDL_EXPEDITION")
     */
    public function createAction(Request $request)
    {
        $entity = new Expedition();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_Expedition_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Expedition:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Expedition entity.
     *
     * @param Expedition $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Expedition $entity)
    {
        $form = $this->createForm(new ExpeditionType(), $entity, array(
            'action' => $this->generateUrl('com_Expedition_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Expedition entity.
     * @Secure(roles="ROLE_ADD_EXPEDITION")
     */
    public function newAction()
    {
        $entity = new Expedition();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Expedition:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Expedition entity.
     * @Secure(roles="ROLE_SHOW_EXPEDITION")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Expedition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expedition entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Expedition:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Expedition entity.
     * @Secure(roles="ROLE_EDIT_EXPEDITION")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Expedition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expedition entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Expedition:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Expedition entity.
    *
    * @param Expedition $entity The entity
    * @Secure(roles="ROLE_EDIT_EXPEDITION")
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Expedition $entity)
    {
        $form = $this->createForm(new ExpeditionType(), $entity, array(
            'action' => $this->generateUrl('com_Expedition_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Expedition entity.
     * @Secure(roles="ROLE_EDIT_EXPEDITION")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Expedition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expedition entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Expedition_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Expedition:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Expedition entity.
     * @Secure(roles="ROLE_DELETE_EXPEDITION")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Expedition')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Expedition entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Expedition'));
    }

    /**
     * Creates a form to delete a Expedition entity by id.
     *
     * @param mixed $id The entity id
     * @Secure(roles="ROLE_DELETE_EXPEDITION")
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Expedition_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
