<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContTablePrix
 *
 * @ORM\Table(name="cont_table_prix", indexes={@ORM\Index(name="FK_CONT_TABLE_PRIX", columns={"ID_CONTART"}), @ORM\Index(name="FK_CONT_TABLE_PRIX2", columns={"ID_RUB"}), @ORM\Index(name="FK_CONT_TABLE_PRIX3", columns={"ID_T_VAL"}), @ORM\Index(name="FK_CONT_TABLE_PRIX4", columns={"ID_S_TRAJET"})})
 * @ORM\Entity
 */
class ContTablePrix
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
     * @ORM\Column(name="VALEUR", type="float", nullable=true)
     */
    private $valeur;

    /**
     * @var float
     *
     * @ORM\Column(name="TVA", type="float", precision=10, scale=0, nullable=true)
     */
    private $tva;

    /**
     * @var \Contrat
     *
     * @ORM\ManyToOne(targetEntity="Contrat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CONTART", referencedColumnName="ID")
     * })
     */
    private $idContart;

    /**
     * @var \Rubrique
     *
     * @ORM\ManyToOne(targetEntity="Rubrique")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_RUB", referencedColumnName="ID")
     * })
     */
    private $idRub;

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
     * @var \SousTrajet
     *
     * @ORM\ManyToOne(targetEntity="SousTrajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_S_TRAJET", referencedColumnName="ID")
     * })
     */
    private $idSTrajet;
    
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set valeur
     *
     * @param integer $valeur
     * @return ContTablePrix
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * Get valeur
     *
     * @return integer 
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * Set tva
     *
     * @param float $tva
     * @return ContTablePrix
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
     * Set idContart
     *
     * @param \Com\DaufinBundle\Entity\Contrat $idContart
     * @return ContTablePrix
     */
    public function setIdContart(\Com\DaufinBundle\Entity\Contrat $idContart = null)
    {
        $this->idContart = $idContart;

        return $this;
    }

    /**
     * Get idContart
     *
     * @return \Com\DaufinBundle\Entity\Contrat 
     */
    public function getIdContart()
    {
        return $this->idContart;
    }

    /**
     * Set idRub
     *
     * @param \Com\DaufinBundle\Entity\Rubrique $idRub
     * @return ContTablePrix
     */
    public function setIdRub(\Com\DaufinBundle\Entity\Rubrique $idRub = null)
    {
        $this->idRub = $idRub;

        return $this;
    }

    /**
     * Get idRub
     *
     * @return \Com\DaufinBundle\Entity\Rubrique 
     */
    public function getIdRub()
    {
        return $this->idRub;
    }

    /**
     * Set idTVal
     *
     * @param \Com\DaufinBundle\Entity\TypeValeur $idTVal
     * @return ContTablePrix
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

    /**
     * Set idSTrajet
     *
     * @param \Com\DaufinBundle\Entity\SousTrajet $idSTrajet
     * @return ContTablePrix
     */
    public function setIdSTrajet(\Com\DaufinBundle\Entity\SousTrajet $idSTrajet = null)
    {
        $this->idSTrajet = $idSTrajet;

        return $this;
    }

    /**
     * Get idSTrajet
     *
     * @return \Com\DaufinBundle\Entity\SousTrajet 
     */
    public function getIdSTrajet()
    {
        return $this->idSTrajet;
    }
    public function __toString(){return $this->id;}
	public function getValeurMax() {
		return $this->valeurMax;
	}
	public function setValeurMax($valeurMax) {
		$this->valeurMax = $valeurMax;
		return $this;
	}
	public function getValeurMin() {
		return $this->valeurMin;
	}
	public function setValeurMin($valeurMin) {
		$this->valeurMin = $valeurMin;
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
