<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrajetSTrajet
 *
 * @ORM\Table(name="trajet_s_trajet", indexes={@ORM\Index(name="FK_RETENIR", columns={"SOUS_TRAJET"}), @ORM\Index(name="FK_RETENIR2", columns={"TRAJET"})})
 * @ORM\Entity
 */
class TrajetSTrajet
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
     * @var integer
     *
     * @ORM\Column(name="RANGE_RET", type="integer", nullable=true)
     */
    private $rangeRet;

    /**
     * @var \SousTrajet
     *
     * @ORM\ManyToOne(targetEntity="SousTrajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SOUS_TRAJET", referencedColumnName="ID")
     * })
     */
    private $sousTrajet;

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
     * Set rangeRet
     *
     * @param integer $rangeRet
     * @return TrajetSTrajet
     */
    public function setRangeRet($rangeRet)
    {
        $this->rangeRet = $rangeRet;

        return $this;
    }

    /**
     * Get rangeRet
     *
     * @return integer 
     */
    public function getRangeRet()
    {
        return $this->rangeRet;
    }

    /**
     * Set sousTrajet
     *
     * @param \Com\DaufinBundle\Entity\SousTrajet $sousTrajet
     * @return TrajetSTrajet
     */
    public function setSousTrajet(\Com\DaufinBundle\Entity\SousTrajet $sousTrajet = null)
    {
        $this->sousTrajet = $sousTrajet;

        return $this;
    }

    /**
     * Get sousTrajet
     *
     * @return \Com\DaufinBundle\Entity\SousTrajet 
     */
    public function getSousTrajet()
    {
        return $this->sousTrajet;
    }

    /**
     * Set trajet
     *
     * @param \Com\DaufinBundle\Entity\Trajet $trajet
     * @return TrajetSTrajet
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
