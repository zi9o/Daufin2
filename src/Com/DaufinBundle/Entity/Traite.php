<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Traite
 *
 * @ORM\Table(name="traite", indexes={@ORM\Index(name="FK_CONTRE_TRAITE", columns={"EXEPT"})})
 * @ORM\Entity
 */
class Traite
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
     * @ORM\Column(name="TITRE_TRAITE", type="string", length=40, nullable=true)
     */
    private $titreTraite;

    /**
     * @var float
     *
     * @ORM\Column(name="MONTANT_TRT", type="float", precision=10, scale=0, nullable=true)
     */
    private $montantTrt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_TRAITE", type="datetime", nullable=true)
     */
    private $dateTraite;

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
     * Set titreTraite
     *
     * @param string $titreTraite
     * @return Traite
     */
    public function setTitreTraite($titreTraite)
    {
        $this->titreTraite = $titreTraite;

        return $this;
    }

    /**
     * Get titreTraite
     *
     * @return string 
     */
    public function getTitreTraite()
    {
        return $this->titreTraite;
    }

    /**
     * Set montantTrt
     *
     * @param float $montantTrt
     * @return Traite
     */
    public function setMontantTrt($montantTrt)
    {
        $this->montantTrt = $montantTrt;

        return $this;
    }

    /**
     * Get montantTrt
     *
     * @return float 
     */
    public function getMontantTrt()
    {
        return $this->montantTrt;
    }

    /**
     * Set dateTraite
     *
     * @param \DateTime $dateTraite
     * @return Traite
     */
    public function setDateTraite($dateTraite)
    {
        $this->dateTraite = $dateTraite;

        return $this;
    }

    /**
     * Get dateTraite
     *
     * @return \DateTime 
     */
    public function getDateTraite()
    {
        return $this->dateTraite;
    }

    /**
     * Set exept
     *
     * @param \Com\DaufinBundle\Entity\Expedition $exept
     * @return Traite
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
    public function __toString(){return $this->titreTraite;}
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
