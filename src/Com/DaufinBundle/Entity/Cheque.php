<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cheque
 *
 * @ORM\Table(name="cheque", indexes={@ORM\Index(name="FK_CONTRE_CHEQUE", columns={"EXEPT"})})
 * @ORM\Entity
 */
class Cheque
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
     * @ORM\Column(name="NUM_CHEQUE", type="string", length=56, nullable=true)
     */
    private $numCheque;

    /**
     * @var string
     *
     * @ORM\Column(name="TITRE_CHEQUE", type="string", length=30, nullable=true)
     */
    private $titreCheque;

    /**
     * @var float
     *
     * @ORM\Column(name="MONTANT_CHQ", type="float", precision=10, scale=0, nullable=true)
     */
    private $montantChq;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_ECHEANCE", type="datetime", nullable=true)
     */
    private $dateEcheance;

    /**
     * @var string
     *
     * @ORM\Column(name="NATURE_CHEQUE", type="string", length=30, nullable=true)
     */
    private $natureCheque;

    /**
     * @var string
     *
     * @ORM\Column(name="ETAT_CHEQUE", type="string", length=30, nullable=true)
     */
    private $etatCheque;

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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Facture", inversedBy="cheque")
     * @ORM\JoinTable(name="regler_par",
     *   joinColumns={
     *     @ORM\JoinColumn(name="CHEQUE", referencedColumnName="ID")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="FACTURE", referencedColumnName="ID")
     *   }
     * )
     */
    private $facture;
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateValid", type="datetime", nullable=true)
     */
    private $dateValid;
    
    /**
     * @var string
     *
     * @ORM\Column(name="etatValid", type="string", length=30, nullable=true)
     */
    private $etatValid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->facture = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numCheque
     *
     * @param string $numCheque
     * @return Cheque
     */
    public function setNumCheque($numCheque)
    {
        $this->numCheque = $numCheque;

        return $this;
    }

    /**
     * Get numCheque
     *
     * @return string 
     */
    public function getNumCheque()
    {
        return $this->numCheque;
    }

    /**
     * Set titreCheque
     *
     * @param string $titreCheque
     * @return Cheque
     */
    public function setTitreCheque($titreCheque)
    {
        $this->titreCheque = $titreCheque;

        return $this;
    }

    /**
     * Get titreCheque
     *
     * @return string 
     */
    public function getTitreCheque()
    {
        return $this->titreCheque;
    }

    /**
     * Set montantChq
     *
     * @param float $montantChq
     * @return Cheque
     */
    public function setMontantChq($montantChq)
    {
        $this->montantChq = $montantChq;

        return $this;
    }

    /**
     * Get montantChq
     *
     * @return float 
     */
    public function getMontantChq()
    {
        return $this->montantChq;
    }

    /**
     * Set dateEcheance
     *
     * @param \DateTime $dateEcheance
     * @return Cheque
     */
    public function setDateEcheance($dateEcheance)
    {
        $this->dateEcheance = $dateEcheance;

        return $this;
    }

    /**
     * Get dateEcheance
     *
     * @return \DateTime 
     */
    public function getDateEcheance()
    {
        return $this->dateEcheance;
    }

    /**
     * Set natureCheque
     *
     * @param string $natureCheque
     * @return Cheque
     */
    public function setNatureCheque($natureCheque)
    {
        $this->natureCheque = $natureCheque;

        return $this;
    }

    /**
     * Get natureCheque
     *
     * @return string 
     */
    public function getNatureCheque()
    {
        return $this->natureCheque;
    }

    /**
     * Set etatCheque
     *
     * @param string $etatCheque
     * @return Cheque
     */
    public function setEtatCheque($etatCheque)
    {
        $this->etatCheque = $etatCheque;

        return $this;
    }

    /**
     * Get etatCheque
     *
     * @return string 
     */
    public function getEtatCheque()
    {
        return $this->etatCheque;
    }

    /**
     * Set exept
     *
     * @param \Com\DaufinBundle\Entity\Expedition $exept
     * @return Cheque
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

    /**
     * Add facture
     *
     * @param \Com\DaufinBundle\Entity\Facture $facture
     * @return Cheque
     */
    public function addFacture(\Com\DaufinBundle\Entity\Facture $facture)
    {
        $this->facture[] = $facture;

        return $this;
    }

    /**
     * Remove facture
     *
     * @param \Com\DaufinBundle\Entity\Facture $facture
     */
    public function removeFacture(\Com\DaufinBundle\Entity\Facture $facture)
    {
        $this->facture->removeElement($facture);
    }

    /**
     * Get facture
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFacture()
    {
        return $this->facture;
    }
    public function __toString(){return $this->numCheque;}
	public function getDateValid() {
		return $this->dateValid;
	}
	public function setDateValid(\DateTime $dateValid) {
		$this->dateValid = $dateValid;
		return $this;
	}
	public function getEtatValid() {
		return $this->etatValid;
	}
	public function setEtatValid($etatValid) {
		$this->etatValid = $etatValid;
		return $this;
	}
	
}
