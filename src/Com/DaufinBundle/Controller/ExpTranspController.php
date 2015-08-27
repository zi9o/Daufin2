<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Com\DaufinBundle\Entity\ExpTransp;
use Com\DaufinBundle\Form\ExpTranspType;
use Com\DaufinBundle\Entity\Expedition;
use Com\DaufinBundle\Entity\OpererExpedition;


/**
 * ExpTransp controller.
 *
 */
class ExpTranspController extends Controller
{

    /**
     * Lists all ExpTransp entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
 
//         $date=new \DateTime();        
//         $now=$date->format('Y-m-d');        
//         $entities = $em->getRepository('ComDaufinBundle:ExpTransp')->createQueryBuilder('u')->where('u.dateCreation LIKE :date')
//                                                          ->setParameter('date', '%'.$now.'%')
//                                                          ->getQuery()->getResult();

       

        $entities = $em->getRepository('ComDaufinBundle:ExpTransp')->findAll();
        
        $trajets=$em->getRepository('ComDaufinBundle:Trajet')->findAll();

        return $this->render('ComDaufinBundle:ExpTransp:index.html.twig', array(
            'entities' => $entities,
            'trajets' => $trajets,
        ));
    }
private function test($date)
{
    $em = $this->container->get('doctrine')->getEntityManager();
	$qb = $em->createQueryBuilder();
	$qb->select('entities')
			->from('ComDaufinBundle:ExpTransp','entities')
			->where('(entities.dateCreation) = :date')
			->setParameter('date', $date->format('Y-m-d'));
	$query = $qb->getQuery();
	$entities = $query->getResult();
        return $entities;
}

    
    /**
     * Creates a new ExpTransp entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ExpTransp();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $dat=$entity->getDateCreation();
        $tst=$this->test($dat);
       // if ($tst=='')
       // {
          $strajets = $this->getDoctrine()->getRepository('ComDaufinBundle:SousTrajet')->findAll();
        if ($dat<>'')
        {
            if ($form->isValid()) {
                foreach($strajets as $segment )
            {
                $entity->setsTrajet($segment);
                $entity->setnbreExpedition(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
            $entity = new ExpTransp();
            $entity->setDateCreation($dat);
            }

                return $this->redirect($this->generateUrl('com_ExpeTrans'));
            }
        }  
       // }
       // else
       // {
            return $this->render('ComDaufinBundle:ExpTransp:new.html.twig', array(
            'entity' => $entity,
                'tst'=> $tst,
            'form'   => $form->createView(),
        ));
       // }
    }

    /**
     * Creates a form to create a ExpTransp entity.
     *
     * @param ExpTransp $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ExpTransp $entity)
    {
        $form = $this->createForm(new ExpTranspType(), $entity, array(
            'action' => $this->generateUrl('com_ExpeTrans_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Générer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new ExpTransp entity.
     *
     */
    public function newAction()
    {
        
        $entity = new ExpTransp();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:ExpTransp:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ExpTransp entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ExpTransp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExpTransp entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:ExpTransp:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ExpTransp entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entity = $em->getRepository('ComDaufinBundle:ExpTransp')->find($id);
        $expeds=$this->getexpedition($entity->getsTrajet(),$entity->getDateCreation());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExpTransp entity.');
        }
        
        if (sizeof($expeds)==0){
            $r_expeds=$this->getexpededit($id);
            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);
            return $this->render('ComDaufinBundle:ExpTransp:edit.html.twig', array(
            'entity'      => $entity,
            'entities'    => $expeds,
            'expeditions'    => $r_expeds,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
            
        }
        if ($entity->getnbreExpedition()==0)
        {
            $nb=$this->getnexpedition($expeds);
            $entity->setnbreExpedition($nb);  
        }
        else if($entity->getnbreExpedition()!=0)
        {
            $nb1=$entity->getnbreExpedition();
            $nb=$this->getnexpedition($expeds);
            $entity->setnbreExpedition($nb+$nb1); 
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $r_expeds='';

        return $this->render('ComDaufinBundle:ExpTransp:edit.html.twig', array(
            'entity'      => $entity,
            'entities'    => $expeds,
            'expeditions'    => $r_expeds,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ExpTransp entity.
    *
    * @param ExpTransp $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ExpTransp $entity)
    {
        $form = $this->createForm(new ExpTranspType(), $entity, array(
            'action' => $this->generateUrl('com_ExpeTrans_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Affecter','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
   
    

    /**
     * Edits an existing ExpTransp entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $params = $this->getRequest()->request->all();
        $type_Op=$params['OpType'];
        
        if ($type_Op=='Modif')
        {   
            $retir_expeds=$params['Exp'];
            $nbexp=0;
            foreach($retir_expeds as $retir_exped) 
            {
                $expedition = $em->getRepository('ComDaufinBundle:Expedition')->find($retir_exped);
                $expedition->setexpTransp(NULL);
                $expedition->setetatExp('Taxation');
                $nbexp=$nbexp+1;
            }
            
            $entity = $em->getRepository('ComDaufinBundle:ExpTransp')->find($id);
            $n=$entity->getnbreExpedition();
            $entity->setnbreExpedition($n-$nbexp);
            $em->flush();
            return $this->editAction($id);
        }
        
        $entity = $em->getRepository('ComDaufinBundle:ExpTransp')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExpTransp entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $expeds=$this->getexpedition($entity->getsTrajet(),$entity->getDateCreation());
            $this->setexped($expeds,$entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_ExpeTrans_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:ExpTransp:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    public function updateAutoAction()
    {
                
                $em = $this->getDoctrine()->getManager();
                
                $date=new \DateTime();
                $now=$date->format('Y-m-d');
                $entities = $em->getRepository('ComDaufinBundle:ExpTransp')->createQueryBuilder('u')
                                  ->where('u.dateCreation LIKE :date')
                                  ->setParameter('date', '%'.$now.'%')
                                  ->getQuery()->getResult();
        if (sizeof($entities)<1)
        	return $this->redirect($this->generateUrl('com_Voyage'));
       // Boucler pour chercher les expeditions de transport
             foreach($entities as $ExpTransp ){
             	
             	
                //get all expeditions witch have the same sous trajet
                $trajet=$ExpTransp->getsTrajet();
                
                $em = $this->container->get('doctrine')->getEntityManager();
                $qb = $em->createQueryBuilder();
                $qb->select('entities')
                ->from('ComDaufinBundle:Expedition','entities')
                ->where($qb->expr()->andX(
                		$qb->expr()->eq('entities.envVille',':idenvVille'),
                		$qb->expr()->eq('entities.recVille',':idrecVille'),
                						'entities.expTransp IS NULL'
                	     )
                		)
                ->orWhere($qb->expr()->andX(
                		$qb->expr()->eq('entities.envVille',':idenvVille'),
                		$qb->expr()->eq('entities.transitVille',':idrecVille'),
                		'entities.ExpTransTransit IS NULL')
                		)
                		
                ->orWhere($qb->expr()->andX(
                				$qb->expr()->eq('entities.transitVille',':idenvVille'),
                				$qb->expr()->eq('entities.recVille',':idrecVille'),
                				'entities.ExpTransTransit IS NULL')
                		)
                ->setParameter('idenvVille',$trajet->getVilleDepart())
                ->setParameter('idrecVille',$trajet->getVilleArrivee());
             //   ->setParameter('Direct','Direct')
    		   // ->setParameter('Transit','Transit');
                
                $query = $qb->getQuery();
                $expeditions = $query->getResult();
                
                foreach ($expeditions as $expedition)
                {
                	//if ($expedition->getDateDecl()->format('Y-m-d')==$date->format('Y-m-d'))
                	{
                		//$expedition=new Expedition();
                		//$ExpTransp=new ExpTransp();
                		// pour le cas general 
                		if($expedition->getEtatExp()=='Taxation' && $expedition->getExpTransp()==null)
                		   {     
                		   	  if($expedition->getTypeTransit()=='Transit' && 
                		   	  		$ExpTransp->getsTrajet()->getVilleDepart()==$expedition->getEnvVille() && 
                		   	  		$ExpTransp->getsTrajet()->getVilleArrivee()==$expedition->getTransitVille()){
                		   	  	
                		   	  	$expedition->setExpTransp($ExpTransp);
                		   	  	$expedition->setEtatExp('Planification');
                		   	  	$ExpTransp->setNbreExpedition($ExpTransp->getNbreExpedition()+1);
                		   	  	//set Operation Planification
                		   	  	$operation=new OpererExpedition();
                		   	  	$operation->setPersonnel($this->getUser()->getPersonnel());
                		   	  	$operation->setDateOperation(new \DateTime());
                		   	  	$operation->setTypeOperation("Planification");
                		   	  	$operation->setExept($expedition);
                		   	  	$em->persist($operation);
                		   	 
                		   	  }elseif($expedition->getTypeTransit()=='Direct' && 
                		   	  		$ExpTransp->getsTrajet()->getVilleDepart()==$expedition->getEnvVille() && 
                		   	  		$ExpTransp->getsTrajet()->getVilleArrivee()==$expedition->getRecVille()){
                		   	  	
                		   	  		$expedition->setExpTransp($ExpTransp);
                		   	  		$expedition->setEtatExp('Planification');
                		   	  		$ExpTransp->setNbreExpedition($ExpTransp->getNbreExpedition()+1);
                		   	  		//set Operation Planification
                		   	  		$operation=new OpererExpedition();
                		   	  		$operation->setPersonnel($this->getUser()->getPersonnel());
                		   	  		$operation->setDateOperation(new \DateTime());
                		   	  		$operation->setTypeOperation("Planification");
                		   	  		$operation->setExept($expedition);
                		   	  		$em->persist($operation);
                		   	 
                		   	  }
                		   	  	
                		   	     
                			     
                			  
                			      
                			}
                	 // pour taxation transit
                		else if($expedition->getEtatExp()=='Transition' && 
                				$expedition->getExpTransTransit()==null && $expedition->getTypeTransit()=='Transit' &&
                				$ExpTransp->getsTrajet()->getVilleDepart()==$expedition->getTransitVille() && 
                		   	  	$ExpTransp->getsTrajet()->getVilleArrivee()==$expedition->getRecVille())
                		   {     
                		   	     $expedition->setExpTransTransit($ExpTransp);
                			     $expedition->setEtatExp('Planification');       			
                			     $ExpTransp->setNbreExpedition($ExpTransp->getNbreExpedition()+1);
                			     
                			     //set Operation Planification
                			     $operation=new OpererExpedition();
                			     $operation->setPersonnel($this->getUser()->getPersonnel());
                			     $operation->setDateOperation(new \DateTime());
                			     $operation->setTypeOperation("Planification");
                			     $operation->setExept($expedition);
                			     $em->persist($operation);
                			}
                	}
                }
                
                
                $em->flush();  
                        
             }
            return $this->indexAction();
    }
    /**
     * Deletes a ExpTransp entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:ExpTransp')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ExpTransp entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_ExpeTrans'));
    }

    /**
     * Creates a form to delete a ExpTransp entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_ExpeTrans_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
    
    public function autoCreationAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        $dateHier=date('Y-m-d',strtotime('- 1 days'));
        $dateAvantHier=date('Y-m-d',strtotime('- 2 days'));
        $expTransps = $this->getDoctrine()->getRepository('ComDaufinBundle:ExpTransp')->findAll();
        foreach($expTransps as $expTransp )
        {
            $date1= date_format($expTransp->getdateCreation(), 'Y-m-d');
            if ((($date1==$dateHier)||($date1==$dateAvantHier)) && $expTransp->getnbreExpedition()==0)
            {
                $em->remove($expTransp);
                $em->flush();
            }
        }
        
//         $connection = $em->getConnection();
        
//         $statement = $connection->prepare("SELECT v.id as id FROM agence ag,affecter af,ville v 
//         		                               where af.personnel=:personnel AND 
//         		                                     af.agence=ag.id AND 
//         		                                      v.id=ag.ville ");
//         $statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
//         $statement->execute();
//         $ags=$statement->fetchAll();
        
        //  $strajets = $this->getDoctrine()->getRepository('ComDaufinBundle:SousTrajet')->findBy(array('villeDepart' => $ags[0]['id']));
          
        $strajets = $this->getDoctrine()->getRepository('ComDaufinBundle:SousTrajet')->findAll();
          foreach($strajets as $strajet )
            {
                $entity = new ExpTransp();
                $entity->setDateCreation(new \DateTime());
                $entity->setsTrajet($strajet);
                $entity->setnbreExpedition(0);
                $em->persist($entity);
                $em->flush();
            }

              return $this->redirect($this->generateUrl('com_ExpeTrans'));
    }
}
