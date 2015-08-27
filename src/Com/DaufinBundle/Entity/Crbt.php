<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crbt
 *
 * @ORM\Table(name="crbt", indexes={@ORM\Index(name="FK_CRBT_I", columns={"EXEPT"})})
 * @ORM\Entity
 */
class Crbt
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
     * @ORM\Column(name="TITRE_CRBT", type="string", length=40, nullable=true)
     */
    private $titreCrbt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_CRBT", type="datetime", nullable=true)
     */
    private $dateCrbt;

    /**
     * @var float
     *
     * @ORM\Column(name="MONTANT_CRBT", type="float", precision=10, scale=0, nullable=true)
     */
    private $montantCrbt;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titreCrbt
     *
     * @param string $titreCrbt
     * @return Crbt
     */
    public function setTitreCrbt($titreCrbt)
    {
        $this->titreCrbt = $titreCrbt;

        return $this;
    }

    /**
     * Get titreCrbt
     *
     * @return string 
     */
    public function getTitreCrbt()
    {
        return $this->titreCrbt;
    }

    /**
     * Set dateCrbt
     *
     * @param \DateTime $dateCrbt
     * @return Crbt
     */
    public function setDateCrbt($dateCrbt)
    {
        $this->dateCrbt = $dateCrbt;

        return $this;
    }

    /**
     * Get dateCrbt
     *
     * @return \DateTime 
     */
    public function getDateCrbt()
    {
        return $this->dateCrbt;
    }

    /**
     * Set montantCrbt
     *
     * @param float $montantCrbt
     * @return Crbt
     */
    public function setMontantCrbt($montantCrbt)
    {
        $this->montantCrbt = $montantCrbt;

        return $this;
    }

    /**
     * Get montantCrbt
     *
     * @return float 
     */
    public function getMontantCrbt()
    {
        return $this->montantCrbt;
    }

    /**
     * Set exept
     *
     * @param \Com\DaufinBundle\Entity\Expedition $exept
     * @return Crbt
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
    public function __toString(){return $this->titreCrbt;}
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
