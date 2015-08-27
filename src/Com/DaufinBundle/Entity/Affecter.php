<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Affecter
 *
 * @ORM\Table(name="affecter", indexes={@ORM\Index(name="FK_AFFECTER", columns={"PERSONNEL"}), @ORM\Index(name="FK_AFFECTER2", columns={"AGENCE"})})
 * @ORM\Entity
 */
class Affecter
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
     * @ORM\Column(name="DATE_AFFECTATION", type="datetime", nullable=true)
     */
    private $dateAffectation;

    /**
     * @var \Personnel
     *
     * @ORM\ManyToOne(targetEntity="Personnel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PERSONNEL", referencedColumnName="ID")
     * })
     */
    private $personnel;

    /**
     * @var \Agence
     *
     * @ORM\ManyToOne(targetEntity="Agence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="AGENCE", referencedColumnName="ID")
     * })
     */
    private $agence;



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
     * Set dateAffectation
     *
     * @param \DateTime $dateAffectation
     * @return Affecter
     */
    public function setDateAffectation($dateAffectation)
    {
        $this->dateAffectation = $dateAffectation;

        return $this;
    }

    /**
     * Get dateAffectation
     *
     * @return \DateTime 
     */
    public function getDateAffectation()
    {
        return $this->dateAffectation;
    }

    /**
     * Set personnel
     *
     * @param \Com\DaufinBundle\Entity\Personnel $personnel
     * @return Affecter
     */
    public function setPersonnel(\Com\DaufinBundle\Entity\Personnel $personnel = null)
    {
        $this->personnel = $personnel;

        return $this;
    }

    /**
     * Get personnel
     *
     * @return \Com\DaufinBundle\Entity\Personnel 
     */
    public function getPersonnel()
    {
        return $this->personnel;
    }

    /**
     * Set agence
     *
     * @param \Com\DaufinBundle\Entity\Agence $agence
     * @return Affecter
     */
    public function setAgence(\Com\DaufinBundle\Entity\Agence $agence = null)
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * Get agence
     *
     * @return \Com\DaufinBundle\Entity\Agence 
     */
    public function getAgence()
    {
        return $this->agence;
    }
    public function __toString(){return $this->id;}
}
