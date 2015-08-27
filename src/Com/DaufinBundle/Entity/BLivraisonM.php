<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BLivraisonM
 *
 * @ORM\Table(name="b_livraison_m", indexes={@ORM\Index(name="FK_CONTRE_BL3", columns={"EXEPT"})})
 * @ORM\Entity
 */
class BLivraisonM
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
     * @ORM\Column(name="NUM_BL", type="string", length=56, nullable=true)
     */
    private $numBl;

    /**
     * @var string
     *
     * @ORM\Column(name="TITRE_BL_M", type="string", length=30, nullable=true)
     */
    private $titreBlM;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_BL_M", type="datetime", nullable=true)
     */
    private $dateBlM;

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
     * Set numBl
     *
     * @param string $numBl
     * @return BLivraisonM
     */
    public function setNumBl($numBl)
    {
        $this->numBl = $numBl;

        return $this;
    }

    /**
     * Get numBl
     *
     * @return string 
     */
    public function getNumBl()
    {
        return $this->numBl;
    }

    /**
     * Set titreBlM
     *
     * @param string $titreBlM
     * @return BLivraisonM
     */
    public function setTitreBlM($titreBlM)
    {
        $this->titreBlM = $titreBlM;

        return $this;
    }

    /**
     * Get titreBlM
     *
     * @return string 
     */
    public function getTitreBlM()
    {
        return $this->titreBlM;
    }

    /**
     * Set dateBlM
     *
     * @param \DateTime $dateBlM
     * @return BLivraisonM
     */
    public function setDateBlM($dateBlM)
    {
        $this->dateBlM = $dateBlM;

        return $this;
    }

    /**
     * Get dateBlM
     *
     * @return \DateTime 
     */
    public function getDateBlM()
    {
        return $this->dateBlM;
    }

    /**
     * Set exept
     *
     * @param \Com\DaufinBundle\Entity\Expedition $exept
     * @return BLivraisonM
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
    public function __toString(){return $this->titreBlM;}
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
