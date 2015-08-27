<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\VehiTrajVoyg;

use Com\DaufinBundle\Entity\Voyage;
use Com\DaufinBundle\Entity\OpererVoyage;

use Com\DaufinBundle\Form\VehiTrajVoygType;
use Com\DaufinBundle\Entity\VoyageType;

/**
 * VehiTrajVoyg controller.
 *
 */
class VehiTrajVoygController extends Controller
{

    /**
     * Lists all VehiTrajVoyg entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:VehiTrajVoyg')->findAll();

        return $this->render('ComDaufinBundle:VehiTrajVoyg:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new VehiTrajVoyg entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new VehiTrajVoyg();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $paramet=$request->getContent();
        $voyage=new voyage();
        $voyage=$paramet['voyage'];

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($voyage);
            $em->persist($entity);
            $em->flush();
            

            return $this->redirect($this->generateUrl('com_vehi_traj_voyg_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:VehiTrajVoyg:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a VehiTrajVoyg entity.
     *
     * @param VehiTrajVoyg $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(VehiTrajVoyg $entity)
    {
        $form = $this->createForm(new VehiTrajVoygType(), $entity, array(
            'action' => $this->generateUrl('com_vehi_traj_voyg_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new VehiTrajVoyg entity.
     *
     */
    public function newAction()
    {
        $entity = new VehiTrajVoyg();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:VehiTrajVoyg:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a VehiTrajVoyg entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:VehiTrajVoyg')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VehiTrajVoyg entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:VehiTrajVoyg:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing VehiTrajVoyg entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:VehiTrajVoyg')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VehiTrajVoyg entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:VehiTrajVoyg:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a VehiTrajVoyg entity.
    *
    * @param VehiTrajVoyg $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(VehiTrajVoyg $entity)
    {
        $form = $this->createForm(new VehiTrajVoygType(), $entity, array(
            'action' => $this->generateUrl('com_vehi_traj_voyg_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing VehiTrajVoyg entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:VehiTrajVoyg')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VehiTrajVoyg entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_vehi_traj_voyg_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:VehiTrajVoyg:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a VehiTrajVoyg entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:VehiTrajVoyg')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find VehiTrajVoyg entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_vehi_traj_voyg'));
    }

    /**
     * Creates a form to delete a VehiTrajVoyg entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_vehi_traj_voyg_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    
}
