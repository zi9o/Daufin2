<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UniteManu
 *
 * @ORM\Table(name="unite_manu", indexes={@ORM\Index(name="FK_CONTENIR", columns={"EXEPT"})})
 * @ORM\Entity
 */
class UniteManu
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
     * @ORM\Column(name="TYPE_UNITE", type="string", length=48, nullable=true)
     */
    private $typeUnite;

    /**
     * @var float
     *
     * @ORM\Column(name="POIDS_UNITE", type="float", precision=10, scale=0, nullable=true)
     */
    private $poidsUnite;

    /**
     * @var float
     *
     * @ORM\Column(name="VOLUME_UNITE", type="float", precision=10, scale=0, nullable=true)
     */
    private $volumeUnite;

    /**
     * @var integer
     *
     * @ORM\Column(name="NBR_COLIS_PLT", type="integer", nullable=true)
     */
    private $nbrColisPlt;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set typeUnite
     *
     * @param string $typeUnite
     * @return UniteManu
     */
    public function setTypeUnite($typeUnite)
    {
        $this->typeUnite = $typeUnite;

        return $this;
    }

    /**
     * Get typeUnite
     *
     * @return string 
     */
    public function getTypeUnite()
    {
        return $this->typeUnite;
    }

    /**
     * Set poidsUnite
     *
     * @param float $poidsUnite
     * @return UniteManu
     */
    public function setPoidsUnite($poidsUnite)
    {
        $this->poidsUnite = $poidsUnite;

        return $this;
    }

    /**
     * Get poidsUnite
     *
     * @return float 
     */
    public function getPoidsUnite()
    {
        return $this->poidsUnite;
    }

    /**
     * Set volumeUnite
     *
     * @param float $volumeUnite
     * @return UniteManu
     */
    public function setVolumeUnite($volumeUnite)
    {
        $this->volumeUnite = $volumeUnite;

        return $this;
    }

    /**
     * Get volumeUnite
     *
     * @return float 
     */
    public function getVolumeUnite()
    {
        return $this->volumeUnite;
    }

    /**
     * Set nbrColisPlt
     *
     * @param integer $nbrColisPlt
     * @return UniteManu
     */
    public function setNbrColisPlt($nbrColisPlt)
    {
        $this->nbrColisPlt = $nbrColisPlt;

        return $this;
    }

    /**
     * Get nbrColisPlt
     *
     * @return integer 
     */
    public function getNbrColisPlt()
    {
        return $this->nbrColisPlt;
    }

    /**
     * Set exept
     *
     * @param \Com\DaufinBundle\Entity\Expedition $exept
     * @return UniteManu
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
    public function __toString(){return $this->id;}
}
