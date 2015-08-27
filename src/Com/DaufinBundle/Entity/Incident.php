<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Incident
 *
 * @ORM\Table(name="incident", indexes={@ORM\Index(name="FK_INCIDENT", columns={"UNITE_MANU"})})
 * @ORM\Entity
 */
class Incident
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
     * @ORM\Column(name="TYPE_INCIDENT", type="string", length=64, nullable=true)
     */
    private $typeIncident;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_INCIDENT", type="datetime", nullable=true)
     */
    private $dateIncident;
    
        /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=250, nullable=true)
     */
    private $description;

    /**
    /**
     * @var \UniteManu
     *
     * @ORM\ManyToOne(targetEntity="UniteManu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="UNITE_MANU", referencedColumnName="ID")
     * })
     */
    private $uniteManu;


    
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
     * Set typeIncident
     *
     * @param string $typeIncident
     * @return Incident
     */
    public function setTypeIncident($typeIncident)
    {
        $this->typeIncident = $typeIncident;

        return $this;
    }

    /**
     * Get typeIncident
     *
     * @return string 
     */
    public function getTypeIncident()
    {
        return $this->typeIncident;
    }

    /**
     * Set dateIncident
     *
     * @param \DateTime $dateIncident
     * @return Incident
     */
    public function setDateIncident($dateIncident)
    {
        $this->dateIncident = $dateIncident;

        return $this;
    }

    /**
     * Get dateIncident
     *
     * @return \DateTime 
     */
    public function getDateIncident()
    {
        return $this->dateIncident;
    }
    
    /**
     * Set description
     *
     * @param string $description
     * @return Incident
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->typeIncident;
    }
    
    /**
     * Set uniteManu
     *
     * @param \Com\DaufinBundle\Entity\UniteManu $uniteManu
     * @return Site
     */
    public function setUniteManu(\Com\DaufinBundle\Entity\UniteManu $uniteManu = null)
    {
        $this->uniteManu = $uniteManu;

        return $this;
    }

    /**
     * Get uniteManu
     *
     * @return \Com\DaufinBundle\Entity\UniteManu 
     */
    public function getUniteManu()
    {
        return $this->uniteManu;
    }
    public function __toString(){return $this->id;}
}
