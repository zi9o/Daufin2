<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * class VehiTrajVoyg
 *
 * @ORM\Table(name="vehi_traj_voyg", indexes={@ORM\Index(name="FK_VEHI_TRAJ_VOYG", columns={"VEHICULE"})}, indexes={@ORM\Index(name="FK_VEHI_TRAJ_VOYG2", columns={"TRAJET"})}, indexes={@ORM\Index(name="FK_VEHI_TRAJ_VOYG3", columns={"VOYAGE"})})
 * @ORM\Entity
 */

class VehiTrajVoyg
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
     * @ORM\Column(name="DATE_PASSER", type="datetime", nullable=true)
     */
    private $datePasser;

    /**
     * @var \Voyage
     *
     * @ORM\ManyToOne(targetEntity="Voyage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="VOYAGE", referencedColumnName="ID")
     * })
     */
    private $voyage;
    
    /**
     * @var \Vehicule
     *
     * @ORM\ManyToOne(targetEntity="Vehicule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="VEHICULE", referencedColumnName="ID")
     * })
     */
    private $vehicule;

    /**
     * @var \Trajet
     *
     * @ORM\ManyToOne(targetEntity="Trajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TRAJET", referencedColumnName="ID")
     * })
     */
    
    private $trajet;
    
    /**
     * @var \Personnel
     *
     * @ORM\ManyToOne(targetEntity="Personnel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="chauffeur", referencedColumnName="ID")
     * })
     */
    
    private $chauffeur;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numPlombage1", type="string", length=10, nullable=true)
     */
    private $numPlombage1;
    /**
     * @var string
     *
     * @ORM\Column(name="numPlombage2", type="string", length=10, nullable=true)
     */
    private $numPlombage2;
    /**
     * @var string
     *
     * @ORM\Column(name="numPlombage3", type="string", length=10, nullable=true)
     */
    private $numPlombage3;
    /**
     * @var string
     *
     * @ORM\Column(name="numPlombage4", type="string", length=10, nullable=true)
     */
    private $numPlombage4;

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
     * Set datePasser
     *
     * @param \DateTime $datePasser
     * @return VehiTrajVoyg
     */
    public function setdatePasser($datePasser)
    {
        $this->datePasser = $datePasser;

        return $this;
    }

    /**
     * Get datePasser
     *
     * @return \DateTime 
     */
    public function getdatePasser()
    {
        return $this->datePasser;
    }

    /**
     * Get voyage
     *
     * @return \Com\DaufinBundle\Entity\Voyage 
     */
    public function getvoyage()
    {
        return $this->voyage;
    }

    /**
     * Set voyage
     *
     * @param \Com\DaufinBundle\Entity\Voyage $voyage
     * @return VehiTrajVoyg
     */
    public function setvoyage(\Com\DaufinBundle\Entity\Voyage $voyage = null)
    {
        $this->voyage = $voyage;

        return $this;
    }
    /**
     * Get vehicule
     *
     * @return \Com\DaufinBundle\Entity\Vehicule 
     */
    public function getvehicule()
    {
        return $this->vehicule;
    }

    /**
     * Set vehicule
     *
     * @param \Com\DaufinBundle\Entity\Vehicule $vehicule
     * @return VehiTrajVoyg
     */
    public function setvehicule(\Com\DaufinBundle\Entity\Vehicule $vehicule = null)
    {
        $this->vehicule = $vehicule;

        return $this;
    }
    
    /**
     * Get trajet
     *
     * @return \Com\DaufinBundle\Entity\Trajet 
     */
    public function gettrajet()
    {
        return $this->trajet;
    }
    
    /**
     * Set trajet
     *
     * @param \Com\DaufinBundle\Entity\Trajet $trajet
     * @return VehiTrajVoyg
     */
    public function settrajet(\Com\DaufinBundle\Entity\Trajet $trajet = null)
    {
        $this->trajet = $trajet;

        return $this;
    }
    
    public function __toString(){return $this->id;}
	public function getNumPlombage1() {
		return $this->numPlombage1;
	}
	public function setNumPlombage1($numPlombage1) {
		$this->numPlombage1 = $numPlombage1;
		return $this;
	}
	public function getNumPlombage2() {
		return $this->numPlombage2;
	}
	public function setNumPlombage2($numPlombage2) {
		$this->numPlombage2 = $numPlombage2;
		return $this;
	}
	public function getNumPlombage3() {
		return $this->numPlombage3;
	}
	public function setNumPlombage3($numPlombage3) {
		$this->numPlombage3 = $numPlombage3;
		return $this;
	}
	public function getNumPlombage4() {
		return $this->numPlombage4;
	}
	public function setNumPlombage4($numPlombage4) {
		$this->numPlombage4 = $numPlombage4;
		return $this;
	}
	public function getChauffeur() {
		return $this->chauffeur;
	}
	public function setChauffeur(\Com\DaufinBundle\Entity\Personnel $chauffeur) {
		$this->chauffeur = $chauffeur;
		return $this;
	}
	
	
    
}
