<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\TablePrix;
use Com\DaufinBundle\Form\TablePrixType;

/**
 * TablePrix controller.
 *
 */
class TablePrixController extends Controller
{

    /**
     * Lists all TablePrix entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:TablePrix')->findAll();

        return $this->render('ComDaufinBundle:TablePrix:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TablePrix entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TablePrix();
        $entity->setDateOuverture(new \DateTime());
        $entity->setDateFermeture(new \DateTime('2020-06-16'));
        $entity->setEtat('Activee');
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
        
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_table_prix_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:TablePrix:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TablePrix entity.
     *
     * @param TablePrix $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TablePrix $entity)
    {
        $form = $this->createForm(new TablePrixType(), $entity, array(
            'action' => $this->generateUrl('com_table_prix_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new TablePrix entity.
     *
     */
    public function newAction()
    {
        $entity = new TablePrix();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:TablePrix:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TablePrix entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:TablePrix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TablePrix entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:TablePrix:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TablePrix entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:TablePrix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TablePrix entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:TablePrix:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TablePrix entity.
    *
    * @param TablePrix $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TablePrix $entity)
    {
        $form = $this->createForm(new TablePrixType(), $entity, array(
            'action' => $this->generateUrl('com_table_prix_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing TablePrix entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:TablePrix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TablePrix entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_table_prix_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:TablePrix:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TablePrix entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:TablePrix')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TablePrix entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_table_prix'));
    }

    /**
     * Creates a form to delete a TablePrix entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_table_prix_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
