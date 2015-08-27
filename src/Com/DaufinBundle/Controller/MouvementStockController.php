<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Com\DaufinBundle\Entity\MouvementStock;
use Com\DaufinBundle\Form\MouvementStockType;

/**
 * MouvementStock controller.
 *
 */
class MouvementStockController extends Controller
{

    /**
     * Lists all MouvementStock entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:MouvementStock')->findAll();

        return $this->render('ComDaufinBundle:MouvementStock:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    
    public function createMouvementStockAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$connection = $em->getConnection();
        $params = $this->getRequest()->request->all();
        $MStock=new MouvementStock();
        $MStock->setDateMouv(new \DateTime($params['dateMouv']));
        $Ag=$em->getRepository('ComDaufinBundle:Agence')->find($params['idAgence']);
        $UnM=$em->getRepository('ComDaufinBundle:UniteManu')->find($params['idUniteManu']);
        $Pers=$em->getRepository('ComDaufinBundle:Personnel')->find($params['idPersonnel']);
        $Mouv=$em->getRepository('ComDaufinBundle:Mouvement')->find($params['idMouvement']);
        $MStock->setAgence($Ag);
        $MStock->setUniteManu($UnM);
        $MStock->setMouvement($Mouv);
        $MStock->setPersonnel($Pers);

        $em->persist($MStock);
        $em->flush();
        $response='OK';
        return new Response(json_encode($response));

    }
    
    
    /**
     * Creates a new MouvementStock entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new MouvementStock();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_mouvement_stock_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:MouvementStock:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a MouvementStock entity.
     *
     * @param MouvementStock $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MouvementStock $entity)
    {
        $form = $this->createForm(new MouvementStockType(), $entity, array(
            'action' => $this->generateUrl('com_mouvement_stock_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new MouvementStock entity.
     *
     */
    public function newAction()
    {
        $entity = new MouvementStock();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:MouvementStock:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MouvementStock entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:MouvementStock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MouvementStock entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:MouvementStock:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MouvementStock entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:MouvementStock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MouvementStock entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:MouvementStock:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a MouvementStock entity.
    *
    * @param MouvementStock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MouvementStock $entity)
    {
        $form = $this->createForm(new MouvementStockType(), $entity, array(
            'action' => $this->generateUrl('com_mouvement_stock_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing MouvementStock entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:MouvementStock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MouvementStock entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_mouvement_stock_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:MouvementStock:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MouvementStock entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:MouvementStock')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MouvementStock entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_mouvement_stock'));
    }

    /**
     * Creates a form to delete a MouvementStock entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_mouvement_stock_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
