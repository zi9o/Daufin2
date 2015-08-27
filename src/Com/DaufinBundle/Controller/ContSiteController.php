<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\ContSite;
use Com\DaufinBundle\Form\ContSiteType;

/**
 * ContSite controller.
 *
 */
class ContSiteController extends Controller
{

    /**
     * Lists all ContSite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:ContSite')->findAll();

        return $this->render('ComDaufinBundle:ContSite:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ContSite entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ContSite();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_Cont_Site_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:ContSite:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ContSite entity.
     *
     * @param ContSite $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ContSite $entity)
    {
        $form = $this->createForm(new ContSiteType(), $entity, array(
            'action' => $this->generateUrl('com_Cont_Site_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ContSite entity.
     *
     */
    public function newAction()
    {
        $entity = new ContSite();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:ContSite:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ContSite entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ContSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContSite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:ContSite:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ContSite entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ContSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContSite entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:ContSite:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ContSite entity.
    *
    * @param ContSite $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContSite $entity)
    {
        $form = $this->createForm(new ContSiteType(), $entity, array(
            'action' => $this->generateUrl('com_Cont_Site_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ContSite entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ContSite')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContSite entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Cont_Site_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:ContSite:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ContSite entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:ContSite')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ContSite entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Cont_Site'));
    }

    /**
     * Creates a form to delete a ContSite entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Cont_Site_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
