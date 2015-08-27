<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\Traite;
use Com\DaufinBundle\Form\TraiteType;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * Traite controller.
 *
 */
class TraiteController extends Controller
{

    /**
     * Lists all Traite entities.
     * @Secure(roles="ROLE_SHOW_ALL_TRAITE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Traite')->findAll();

        return $this->render('ComDaufinBundle:Traite:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Traite entity.
     * @Secure(roles="ROLE_ADD_TRAITE")
     */
    public function createAction(Request $request)
    {
        $entity = new Traite();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_traite_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Traite:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Traite entity.
     *
     * @param Traite $entity The entity
     * 
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Traite $entity)
    {
        $form = $this->createForm(new TraiteType(), $entity, array(
            'action' => $this->generateUrl('com_traite_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Traite entity.
     * @Secure(roles="ROLE_ADD_TRAITE")
     */
    public function newAction()
    {
        $entity = new Traite();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Traite:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Traite entity.
     * @Secure(roles="ROLE_SHOW_TRAITE")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Traite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Traite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Traite:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Traite entity.
     * @Secure(roles="ROLE_EDIT_TRAITE")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Traite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Traite entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Traite:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Traite entity.
    *
    * @param Traite $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Traite $entity)
    {
        $form = $this->createForm(new TraiteType(), $entity, array(
            'action' => $this->generateUrl('com_traite_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Traite entity.
     *  @Secure(roles="ROLE_EDIT_TRAITE")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Traite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Traite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_traite_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Traite:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Traite entity.
     * @Secure(roles="ROLE_DELETE_TRAITE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Traite')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Traite entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_traite'));
    }

    /**
     * Creates a form to delete a Traite entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_traite_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
