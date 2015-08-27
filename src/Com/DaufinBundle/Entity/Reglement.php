<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="reglement")
 * @ORM\Entity
 */
class Reglement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reglement", type="datetime", nullable=true)
     */
    private $dateReglement;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation;
    
    /**
     * @var float
     *
     * @ORM\Column(name="totalMontantTTC", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalMontantTTC;
    /**
     * @var float
     *
     * @ORM\Column(name="montantReglement", type="float", precision=10, scale=0, nullable=true)
     */
    private $montantReglement;

    /**
     * @var string
     *
     * @ORM\Column(name="statut_reglement", type="string", length=30, nullable=true)
     */
    private $statutReglement;
    
    /**
     * @var string
     *
     * @ORM\Column(name="mode_reglement", type="string", length=30, nullable=true)
     */
    private $modeReglement;
    
    /**
     * @var string
     *
     * @ORM\Column(name="Ref_reglement", type="string", length=30, nullable=true)
     */
    private $refReglement;
    
     

    /**
     * Constructor
     */
    public function __construct()
    {
    	$this->dateCreation=new \DateTime();
    }
	
	/**
	 *
	 * @return the integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 *
	 * @return the DateTime
	 */
	public function getDateReglement() {
		return $this->dateReglement;
	}
	
	/**
	 *
	 * @param \DateTime $dateReglement        	
	 */
	public function setDateReglement(\DateTime $dateReglement) {
		$this->dateReglement = $dateReglement;
		return $this;
	}
	
	/**
	 *
	 * @return the DateTime
	 */
	public function getDateCreation() {
		return $this->dateCreation;
	}
	
	/**
	 *
	 * @param \DateTime $dateCreation        	
	 */
	public function setDateCreation(\DateTime $dateCreation) {
		$this->dateCreation = $dateCreation;
		return $this;
	}
	
	/**
	 *
	 * @return the float
	 */
	public function getTotalMontantTTC() {
		return $this->totalMontantTTC;
	}
	
	/**
	 *
	 * @param
	 *        	$totalMontantTTC
	 */
	public function setTotalMontantTTC($totalMontantTTC) {
		$this->totalMontantTTC = $totalMontantTTC;
		return $this;
	}
	
	/**
	 *
	 * @return the float
	 */
	public function getMontantReglement() {
		return $this->montantReglement;
	}
	
	/**
	 *
	 * @param
	 *        	$montantReglement
	 */
	public function setMontantReglement($montantReglement) {
		$this->montantReglement = $montantReglement;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getStatutReglement() {
		return $this->statutReglement;
	}
	
	/**
	 *
	 * @param
	 *        	$statutReglement
	 */
	public function setStatutReglement($statutReglement) {
		$this->statutReglement = $statutReglement;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getModeReglement() {
		return $this->modeReglement;
	}
	
	/**
	 *
	 * @param
	 *        	$modeReglement
	 */
	public function setModeReglement($modeReglement) {
		$this->modeReglement = $modeReglement;
		return $this;
	}
	
	/**
	 *
	 * @return the string
	 */
	public function getRefReglement() {
		return $this->refReglement;
	}
	
	/**
	 *
	 * @param
	 *        	$refReglement
	 */
	public function setRefReglement($refReglement) {
		$this->refReglement = $refReglement;
		return $this;
	}
	



    
    
}
