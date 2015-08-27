<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PasserPar
 *
 * @ORM\Table(name="passer_par", indexes={@ORM\Index(name="FK_PASSER_PAR", columns={"VEHICULE"}), @ORM\Index(name="FK_PASSER_PAR2", columns={"TRAJET"})})
 * @ORM\Entity
 */
class PasserPar
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
     * @return PasserPar
     */
    public function setDatePasser($datePasser)
    {
        $this->datePasser = $datePasser;

        return $this;
    }

    /**
     * Get datePasser
     *
     * @return \DateTime 
     */
    public function getDatePasser()
    {
        return $this->datePasser;
    }

    /**
     * Set vehicule
     *
     * @param \Com\DaufinBundle\Entity\Vehicule $vehicule
     * @return PasserPar
     */
    public function setVehicule(\Com\DaufinBundle\Entity\Vehicule $vehicule = null)
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    /**
     * Get vehicule
     *
     * @return \Com\DaufinBundle\Entity\Vehicule 
     */
    public function getVehicule()
    {
        return $this->vehicule;
    }

    /**
     * Set trajet
     *
     * @param \Com\DaufinBundle\Entity\Trajet $trajet
     * @return PasserPar
     */
    public function setTrajet(\Com\DaufinBundle\Entity\Trajet $trajet = null)
    {
        $this->trajet = $trajet;

        return $this;
    }

    /**
     * Get trajet
     *
     * @return \Com\DaufinBundle\Entity\Trajet 
     */
    public function getTrajet()
    {
        return $this->trajet;
    }
    public function __toString(){return $this->id;}
}
