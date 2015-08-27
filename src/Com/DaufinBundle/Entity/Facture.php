<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity
 */
class Facture
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
     * @var string
     *
     * @ORM\Column(name="CODE_FACTURE", type="string", length=40, nullable=true)
     */
    private $numFacture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_FACTURATION", type="datetime", nullable=true)
     */
    private $dateFacturation;

    /**
     * @var integer
     *
     * @ORM\Column(name="NBRE_EXEMPLAIRE", type="integer", nullable=true)
     */
    private $nbreExemplaire;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Cheque", mappedBy="facture")
     */
    private $cheque;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation;
    
    /**
     * @var float
     *
     * @ORM\Column(name="montantTTC", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalMontantTTC;
    /**
     * @var float
     *
     * @ORM\Column(name="montantTVA", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalMontantTVA;
    /**
     * @var float
     *
     * @ORM\Column(name="montantHT", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalMontantHT;
    
    /**
     * @var string
     *
     * @ORM\Column(name="statutFacture", type="string", length=30, nullable=true)
     */
    private $statutFacture;
    
    /**
     * @var string
     *
     * @ORM\Column(name="etat_Facture", type="string", length=20, nullable=true)
     */
    private $etatFacture;
    
    /**
     * @var string
     *
     * @ORM\Column(name="impression", type="string", length=20, nullable=true)
     */
    private $impressionFacture;
    
    /**
     * @var \Reglement
     *
     * @ORM\ManyToOne(targetEntity="Reglement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idReglement", referencedColumnName="ID")
     * })
     */
    private $reglement;
    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="client", referencedColumnName="ID")
     * })
     */
    private $client;
     

    /**
     * Constructor
     */
    public function __construct()
    {
          $this->dateCreation=new \DateTime();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

     /**
     * Set dateFacturation
     *
     * @param \DateTime $dateFacturation
     * @return Facture
     */
    public function setDateFacturation($dateFacturation)
    {
        $this->dateFacturation = $dateFacturation;

        return $this;
    }

    /**
     * Get dateFacturation
     *
     * @return \DateTime 
     */
    public function getDateFacturation()
    {
        return $this->dateFacturation;
    }

    /**
     * Set nbreExemplaire
     *
     * @param integer $nbreExemplaire
     * @return Facture
     */
    public function setNbreExemplaire($nbreExemplaire)
    {
        $this->nbreExemplaire = $nbreExemplaire;

        return $this;
    }

    /**
     * Get nbreExemplaire
     *
     * @return integer 
     */
    public function getNbreExemplaire()
    {
        return $this->nbreExemplaire;
    }

    /**
     * Add cheque
     *
     * @param \Com\DaufinBundle\Entity\Cheque $cheque
     * @return Facture
     */
    public function addCheque(\Com\DaufinBundle\Entity\Cheque $cheque)
    {
        $this->cheque[] = $cheque;

        return $this;
    }

    /**
     * Remove cheque
     *
     * @param \Com\DaufinBundle\Entity\Cheque $cheque
     */
    public function removeCheque(\Com\DaufinBundle\Entity\Cheque $cheque)
    {
        $this->cheque->removeElement($cheque);
    }

    /**
     * Get cheque
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCheque()
    {
        return $this->cheque;
    }
    public function __toString(){return $this->numFacture;}
	public function getNumFacture() {
		return $this->numFacture;
	}
	public function setNumFacture($numFacture) {
		$this->numFacture = $numFacture;
		return $this;
	}
	public function getDateCreation() {
		return $this->dateCreation;
	}
	public function setDateCreation(\DateTime $dateCreation) {
		$this->dateCreation = $dateCreation;
		return $this;
	}
	public function getTotalMontantTTC() {
		return $this->totalMontantTTC;
	}
	public function setTotalMontantTTC($totalMontantTTC) {
		$this->totalMontantTTC = $totalMontantTTC;
		return $this;
	}
	public function getTotalMontantTVA() {
		return $this->totalMontantTVA;
	}
	public function setTotalMontantTVA($totalMontantTVA) {
		$this->totalMontantTVA = $totalMontantTVA;
		return $this;
	}
	public function getTotalMontantHT() {
		return $this->totalMontantHT;
	}
	public function setTotalMontantHT($totalMontantHT) {
		$this->totalMontantHT = $totalMontantHT;
		return $this;
	}
	public function getStatutFacture() {
		return $this->statutFacture;
	}
	public function setStatutFacture($statutFacture) {
		$this->statutFacture = $statutFacture;
		return $this;
	}
	public function getReglement() {
		return $this->reglement;
	}
	public function setReglement(\Com\DaufinBundle\Entity\Reglement $reglement) {
		$this->reglement = $reglement;
		return $this;
	}
	public function getClient() {
		return $this->client;
	}
	public function setClient(\Com\DaufinBundle\Entity\Client $client) {
		$this->client = $client;
		return $this;
	}
	
	
        public function getEtatFacture() {
            return $this->etatFacture;
        }

        public function setEtatFacture($etatFacture) {
            $this->etatFacture = $etatFacture;
        }
        public function getImpressionFacture() {
            return $this->impressionFacture;
        }

        public function setImpressionFacture($impressionFacture) {
            $this->impressionFacture = $impressionFacture;
        }



    
}
