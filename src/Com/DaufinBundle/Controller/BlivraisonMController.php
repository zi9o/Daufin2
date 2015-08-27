<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\BlivraisonM;
use Com\DaufinBundle\Form\BlivraisonMType;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * BlivraisonM controller.
 *
 */
class BlivraisonMController extends Controller
{

    /**
     * Lists all BlivraisonM entities.
     * @Secure(roles="ROLE_SHOW_ALL_BON_LIVRAISON")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:BlivraisonM')->findAll();

        return $this->render('ComDaufinBundle:BlivraisonM:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new BlivraisonM entity.
     * @Secure(roles="ROLE_ADD_BON_LIVRAISON")
     */
    public function createAction(Request $request)
    {
        $entity = new BlivraisonM();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_BLivraison_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:BlivraisonM:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a BlivraisonM entity.
     *
     * @param BlivraisonM $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BlivraisonM $entity)
    {
        $form = $this->createForm(new BlivraisonMType(), $entity, array(
            'action' => $this->generateUrl('com_BLivraison_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new BlivraisonM entity.
     * @Secure(roles="ROLE_ADD_BON_LIVRAISON")
     */
    public function newAction()
    {
        $entity = new BlivraisonM();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:BlivraisonM:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BlivraisonM entity.
     * @Secure(roles="ROLE_SHOW_BON_LIVRAISON")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:BlivraisonM')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlivraisonM entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:BlivraisonM:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BlivraisonM entity.
     * @Secure(roles="ROLE_EDIT_BON_LIVRAISON")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:BlivraisonM')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlivraisonM entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:BlivraisonM:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a BlivraisonM entity.
    *
    * @param BlivraisonM $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BlivraisonM $entity)
    {
        $form = $this->createForm(new BlivraisonMType(), $entity, array(
            'action' => $this->generateUrl('com_BLivraison_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing BlivraisonM entity.
     * @Secure(roles="ROLE_EDIT_BON_LIVRAISON")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:BlivraisonM')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BlivraisonM entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_BLivraison_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:BlivraisonM:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a BlivraisonM entity.
     * @Secure(roles="ROLE_EDIT_BON_LIVRAISON")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:BlivraisonM')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BlivraisonM entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_BLivraison'));
    }

    /**
     * Creates a form to delete a BlivraisonM entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_BLivraison_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
