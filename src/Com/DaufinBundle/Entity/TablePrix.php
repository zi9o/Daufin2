<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TablePrix
 *
 * @ORM\Table(name="table_prix", indexes={@ORM\Index(name="FK_TABLE_PRIX", columns={"S_TRAJET"}), @ORM\Index(name="FK_TABLE_PRIX3", columns={"RUB"}), @ORM\Index(name="FK_TABLE_T_VAL", columns={"ID_T_VAL"})})
 * @ORM\Entity
 */
class TablePrix
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
     * @var float
     *
     * @ORM\Column(name="VALEUR_MAX", type="float", precision=10, scale=0, nullable=true)
     */
    private $valeurMax;

    /**
     * @var float
     *
     * @ORM\Column(name="VALEUR_MIN", type="float", precision=10, scale=0, nullable=true)
     */
    private $valeurMin;

    /**
     * @var float
     *
     * @ORM\Column(name="TVA", type="float", precision=10, scale=0, nullable=true)
     */
    private $tva;
    
    /**
     * @var float
     *
     * @ORM\Column(name="vALEUR", type="float", precision=10, scale=0, nullable=true)
     */
    private $valeur;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_OUVERTURE", type="datetime", nullable=true)
     */
    private $dateOuverture;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_FERMETURE", type="datetime", nullable=true)
     */
    private $dateFermeture;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ETAT", type="string", length=56, nullable=true)
     */
    private $etat;

    /**
     * @var \SousTrajet
     *
     * @ORM\ManyToOne(targetEntity="SousTrajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="S_TRAJET", referencedColumnName="ID")
     * })
     */
    private $sTrajet;

    /**
     * @var \Rubrique
     *
     * @ORM\ManyToOne(targetEntity="Rubrique")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RUB", referencedColumnName="ID")
     * })
     */
    private $rub;

    /**
     * @var \TypeValeur
     *
     * @ORM\ManyToOne(targetEntity="TypeValeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_T_VAL", referencedColumnName="ID")
     * })
     */
    private $idTVal;



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
     * Set valeurMax
     *
     * @param float $valeurMax
     * @return TablePrix
     */
    public function setValeurMax($valeurMax)
    {
        $this->valeurMax = $valeurMax;

        return $this;
    }

    /**
     * Get valeurMax
     *
     * @return float 
     */
    public function getValeurMax()
    {
        return $this->valeurMax;
    }

    /**
     * Set valeurMin
     *
     * @param float $valeurMin
     * @return TablePrix
     */
    public function setValeurMin($valeurMin)
    {
        $this->valeurMin = $valeurMin;

        return $this;
    }

    /**
     * Get valeurMin
     *
     * @return float 
     */
    public function getValeurMin()
    {
        return $this->valeurMin;
    }

    /**
     * Set tva
     *
     * @param float $tva
     * @return TablePrix
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return float 
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set sTrajet
     *
     * @param \Com\DaufinBundle\Entity\SousTrajet $sTrajet
     * @return TablePrix
     */
    public function setSTrajet(\Com\DaufinBundle\Entity\SousTrajet $sTrajet = null)
    {
        $this->sTrajet = $sTrajet;

        return $this;
    }

    /**
     * Get sTrajet
     *
     * @return \Com\DaufinBundle\Entity\SousTrajet 
     */
    public function getSTrajet()
    {
        return $this->sTrajet;
    }

    /**
     * Set rub
     *
     * @param \Com\DaufinBundle\Entity\Rubrique $rub
     * @return TablePrix
     */
    public function setRub(\Com\DaufinBundle\Entity\Rubrique $rub = null)
    {
        $this->rub = $rub;

        return $this;
    }

    /**
     * Get rub
     *
     * @return \Com\DaufinBundle\Entity\Rubrique 
     */
    public function getRub()
    {
        return $this->rub;
    }

    /**
     * Set idTVal
     *
     * @param \Com\DaufinBundle\Entity\TypeValeur $idTVal
     * @return TablePrix
     */
    public function setIdTVal(\Com\DaufinBundle\Entity\TypeValeur $idTVal = null)
    {
        $this->idTVal = $idTVal;

        return $this;
    }

    /**
     * Get idTVal
     *
     * @return \Com\DaufinBundle\Entity\TypeValeur 
     */
    public function getIdTVal()
    {
        return $this->idTVal;
    }
    public function __toString(){return $this->id;}
    
	public function getValeur() {
		return $this->valeur;
	}
	public function setValeur($valeur) {
		$this->valeur = $valeur;
		return $this;
	}
	public function getDateOuverture() {
		return $this->dateOuverture;
	}
	public function setDateOuverture(\DateTime $dateOuverture) {
		$this->dateOuverture = $dateOuverture;
		return $this;
	}
	public function getDateFermeture() {
		return $this->dateFermeture;
	}
	public function setDateFermeture(\DateTime $dateFermeture) {
		$this->dateFermeture = $dateFermeture;
		return $this;
	}
	public function getEtat() {
		return $this->etat;
	}
	public function setEtat($etat) {
		$this->etat = $etat;
		return $this;
	}
	
	
}
