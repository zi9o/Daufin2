<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\Contrat;
use Com\DaufinBundle\Form\ContratType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Contrat controller.
 *
 */
class ContratController extends Controller
{

    /**
     * Lists all Contrat entities.
     *  @Secure(roles="ROLE_SHOW_ALL_CONTRAT")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Contrat')->findAll();

        return $this->render('ComDaufinBundle:Contrat:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Contrat entity.
     *  @Secure(roles="ROLE_ADD_CONTRAT")
     */
    public function createAction(Request $request)
    {
        $entity = new Contrat();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_Contrat_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Contrat:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Contrat entity.
     *
     * @param Contrat $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Contrat $entity)
    {
        $form = $this->createForm(new ContratType(), $entity, array(
            'action' => $this->generateUrl('com_Contrat_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Contrat entity.
     *   @Secure(roles="ROLE_ADD_CONTRAT")
     */
    public function newAction()
    {
        $entity = new Contrat();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Contrat:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Contrat entity.
     *   @Secure(roles="ROLE_SHOW_CONTRAT")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Contrat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contrat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Contrat:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Contrat entity.
     *   @Secure(roles="ROLE_EDIT_CONTRAT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Contrat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contrat entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Contrat:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Contrat entity.
    *
    * @param Contrat $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Contrat $entity)
    {
        $form = $this->createForm(new ContratType(), $entity, array(
            'action' => $this->generateUrl('com_Contrat_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Contrat entity.
     *   @Secure(roles="ROLE_EDIT_CONTRAT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Contrat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contrat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Contrat_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Contrat:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Contrat entity.
     *   @Secure(roles="ROLE_DELETE_CONTRAT")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Contrat')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contrat entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Contrat'));
    }

    /**
     * Creates a form to delete a Contrat entity by id.
     *
     * @param mixed $id The entity id
     *   @Secure(roles="ROLE_DELETE_CONTRAT")
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Contrat_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
