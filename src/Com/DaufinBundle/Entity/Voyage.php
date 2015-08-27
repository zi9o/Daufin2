<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voyage
 *
 * @ORM\Table(name="voyage")
 * @ORM\Entity
 */
class Voyage
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
     * @ORM\Column(name="ETAT_VOYAGE", type="string", length=30, nullable=true)
     */
    private $etatVoyage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_PLANIF", type="datetime", nullable=true)
     */
    private $datePlanif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_VALID", type="datetime", nullable=true)
     */
    private $dateValid;


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
     * Set etatVoyage
     *
     * @param string $etatVoyage
     * @return Voyage
     */
    public function setEtatVoyage($etatVoyage)
    {
        $this->etatVoyage = $etatVoyage;

        return $this;
    }

    /**
     * Get etatVoyage
     *
     * @return string 
     */
    public function getEtatVoyage()
    {
        return $this->etatVoyage;
    }

    /**
     * Set datePlanif
     *
     * @param \DateTime $datePlanif
     * @return Voyage
     */
    public function setDatePlanif($datePlanif)
    {
        $this->datePlanif = $datePlanif;

        return $this;
    }

    /**
     * Get datePlanif
     *
     * @return \DateTime 
     */
    public function getDatePlanif()
    {
        return $this->datePlanif;
    }

    /**
     * Set dateValid
     *
     * @param \DateTime $dateValid
     * @return Voyage
     */
    public function setDateValid($dateValid)
    {
        $this->dateValid = $dateValid;

        return $this;
    }

    /**
     * Get dateValid
     *
     * @return \DateTime 
     */
    public function getDateValid()
    {
        return $this->dateValid;
    }

    
    public function __toString(){return (string)$this->getId();}
}
