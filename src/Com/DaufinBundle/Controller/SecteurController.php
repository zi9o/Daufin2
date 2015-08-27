<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\Secteur;
use Com\DaufinBundle\Form\SecteurType;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * Secteur controller.
 *
 */
class SecteurController extends Controller
{

    /**
     * Lists all Secteur entities.
     * @Secure(roles="ROLE_SHOW_ALL_SECTEUR")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Secteur')->findAll();

        return $this->render('ComDaufinBundle:Secteur:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Secteur entity.
     * @Secure(roles="ROLE_ADD_SECTEUR")
     */
    public function createAction(Request $request)
    {
        $entity = new Secteur();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_secteur_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Secteur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Secteur entity.
     *
     * @param Secteur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Secteur $entity)
    {
        $form = $this->createForm(new SecteurType(), $entity, array(
            'action' => $this->generateUrl('com_secteur_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new Secteur entity.
     * @Secure(roles="ROLE_ADD_SECTEUR")
     */
    public function newAction()
    {
        $entity = new Secteur();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Secteur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Secteur entity.
     * @Secure(roles="ROLE_SHOW_SECTEUR")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Secteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secteur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Secteur:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Secteur entity.
     * @Secure(roles="ROLE_EDIT_SECTEUR")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Secteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secteur entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Secteur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Secteur entity.
    *
    * @param Secteur $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Secteur $entity)
    {
        $form = $this->createForm(new SecteurType(), $entity, array(
            'action' => $this->generateUrl('com_secteur_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing Secteur entity.
     * @Secure(roles="ROLE_EDIT_SECTEUR")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Secteur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Secteur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_secteur_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Secteur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Secteur entity.
     * @Secure(roles="ROLE_DELETE_SECTEUR")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Secteur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Secteur entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_secteur'));
    }

    /**
     * Creates a form to delete a Secteur entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_secteur_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
