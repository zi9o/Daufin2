<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SuivService
 *
 * @ORM\Table(name="suiv_service", indexes={@ORM\Index(name="FK_SUIV_SERVICE", columns={"RUB"}), @ORM\Index(name="FK_SUIV_SERVICE2", columns={"EXEPT"})})
 * @ORM\Entity
 */
class SuivService
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
     * @ORM\Column(name="PRIX_HT", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixHt;

    /**
     * @var float
     *
     * @ORM\Column(name="TVA", type="float", precision=10, scale=0, nullable=true)
     */
    private $tva;

    /**
     * @var float
     *
     * @ORM\Column(name="PRIX_TTC", type="float", precision=10, scale=0, nullable=true)
     */
    private $prixTtc;

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
     * @var \Expedition
     *
     * @ORM\ManyToOne(targetEntity="Expedition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EXEPT", referencedColumnName="ID")
     * })
     */
    private $exept;

    /**
     * @var float
     *
     * @ORM\Column(name="valeurReglement", type="float", precision=10, scale=0, nullable=true)
     */
    private $valeurReglement;
    /**
     * @var string
     *
     * @ORM\Column(name="etatReglement", type="string", length=56, nullable=true)
     */
    private $etatReglement;
    /**
     * @var string
     *
     * @ORM\Column(name="modeReglement", type="string", length=56, nullable=true)
     */
    private $modeReglement;
    /**
     * @var string
     *
     * @ORM\Column(name="RefPaiement", type="string", length=56, nullable=true)
     */
    private $RefPaiement;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateReglement", type="datetime", nullable=true)
     */
    private $dateReglement;

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
     * Set prixHt
     *
     * @param float $prixHt
     * @return SuivService
     */
    public function setPrixHt($prixHt)
    {
        $this->prixHt = $prixHt;

        return $this;
    }

    /**
     * Get prixHt
     *
     * @return float 
     */
    public function getPrixHt()
    {
        return $this->prixHt;
    }

    /**
     * Set tva
     *
     * @param float $tva
     * @return SuivService
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
     * Set prixTtc
     *
     * @param float $prixTtc
     * @return SuivService
     */
    public function setPrixTtc($prixTtc)
    {
        $this->prixTtc = $prixTtc;

        return $this;
    }

    /**
     * Get prixTtc
     *
     * @return float 
     */
    public function getPrixTtc()
    {
        return $this->prixTtc;
    }

    /**
     * Set rub
     *
     * @param \Com\DaufinBundle\Entity\Rubrique $rub
     * @return SuivService
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
     * Set exept
     *
     * @param \Com\DaufinBundle\Entity\Expedition $exept
     * @return SuivService
     */
    public function setExept(\Com\DaufinBundle\Entity\Expedition $exept = null)
    {
        $this->exept = $exept;

        return $this;
    }

    /**
     * Get exept
     *
     * @return \Com\DaufinBundle\Entity\Expedition 
     */
    public function getExept()
    {
        return $this->exept;
    }
    public function __toString(){return $this->id;}
	public function getValeurReglement() {
		return $this->valeurReglement;
	}
	public function setValeurReglement($valeurReglement) {
		$this->valeurReglement = $valeurReglement;
		return $this;
	}
	public function getEtatReglement() {
		return $this->etatReglement;
	}
	public function setEtatReglement($etatReglement) {
		$this->etatReglement = $etatReglement;
		return $this;
	}
	public function getModeReglement() {
		return $this->modeReglement;
	}
	public function setModeReglement($modeReglement) {
		$this->modeReglement = $modeReglement;
		return $this;
	}
	public function getRefPaiement() {
		return $this->RefPaiement;
	}
	public function setRefPaiement($RefPaiement) {
		$this->RefPaiement = $RefPaiement;
		return $this;
	}
	public function getDateReglement() {
		return $this->dateReglement;
	}
	public function setDateReglement(\DateTime $dateReglement) {
		$this->dateReglement = $dateReglement;
		return $this;
	}
	
}
