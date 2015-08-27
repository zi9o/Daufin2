<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExpTransp
 *
 * @ORM\Table(name="exp_transp", indexes={@ORM\Index(name="FK_SOUS_TRAJET", columns={"S_TRAJET"})})
 * @ORM\Entity
 */

class ExpTransp
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
     * @ORM\Column(name="DATE_CREATION", type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @var integer
     *
     * @ORM\Column(name="NBRE_EXPEDITION", type="integer", nullable=true)
     */
    private $nbreExpedition;
    
    /**
     * @var \SousTrajet
     *
     * @ORM\ManyToOne(targetEntity="SousTrajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="S_TRAJET", referencedColumnName="ID")
     * })
     */
    private $sTrajet;



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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return ExpTransp
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set nbreExpedition
     *
     * @param integer $nbreExpedition
     * @return ExpTransp
     */
    public function setNbreExpedition($nbreExpedition)
    {
        $this->nbreExpedition = $nbreExpedition;

        return $this;
    }

 /**
     * Get sTrajet
     *
     * @return \Com\DaufinBundle\Entity\SousTrajet 
     */
    public function getsTrajet()
    {
        return $this->sTrajet;
    }

    /**
     * Set sTrajet
     *
     * @param \Com\DaufinBundle\Entity\SousTrajet $sTrajet
     * @return ExpTransp
     */
    public function setsTrajet(\Com\DaufinBundle\Entity\SousTrajet $sTrajet = null)
    {
        $this->sTrajet = $sTrajet;

        return $this;
    }

    /**
     * Get nbreExpedition
     *
     * @return integer 
     */
    public function getNbreExpedition()
    {
        return $this->nbreExpedition;
    }
    
        public function getidexped()
    {
        return $this->idexped;
    }
        public function setidexped()
    {
        return $this->idexped;
    }
    
    public function __toString()
    {
        return $this->id.'/'.$this->getsTrajet().'('.$this->getNbreExpedition().')';
        
    }
}
