<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MouvementStock
 *
 * @ORM\Table(name="mouvement_stock", indexes={@ORM\Index(name="FK_MOUVEMENT_STOCK", columns={"AGENCE"}), @ORM\Index(name="FK_MOUVEMENT_STOCK2", columns={"UNITE_MANU"}), @ORM\Index(name="FK_MOUVEMENT_STOCK3", columns={"PERSONNEL"}), @ORM\Index(name="FK_MOUVEMENT_STOCK3", columns={"MOUVEMENT"})})
 * @ORM\Entity
 */
class MouvementStock
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
     * @ORM\Column(name="DATE_MOUV", type="datetime", nullable=true)
     */
    private $dateMouv;

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
     * @var \UniteManu
     *
     * @ORM\ManyToOne(targetEntity="UniteManu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="UNITE_MANU", referencedColumnName="ID")
     * })
     */
    private $uniteManu;

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
     * @var \Mouvement
     *
     * @ORM\ManyToOne(targetEntity="Mouvement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="MOUVEMENT", referencedColumnName="ID_MOUV")
     * })
     */
    private $mouvement;

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
     * Set dateMouv
     *
     * @param \DateTime $dateMouv
     * @return MouvementStock
     */
    public function setDateMouv($dateMouv)
    {
        $this->dateMouv = $dateMouv;

        return $this;
    }

    /**
     * Get dateMouv
     *
     * @return \DateTime 
     */
    public function getDateMouv()
    {
        return $this->dateMouv;
    }

    /**
     * Set agence
     *
     * @param \Com\DaufinBundle\Entity\Agence $agence
     * @return MouvementStock
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

    /**
     * Set uniteManu
     *
     * @param \Com\DaufinBundle\Entity\UniteManu $uniteManu
     * @return MouvementStock
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

    /**
     * Set personnel
     *
     * @param \Com\DaufinBundle\Entity\Personnel $personnel
     * @return MouvementStock
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
     * Set mouvement
     *
     * @param \Com\DaufinBundle\Entity\Mouvement $mouvement
     * @return MouvementStock
     */
    public function setMouvement(\Com\DaufinBundle\Entity\Mouvement $mouvement = null)
    {
        $this->mouvement = $mouvement;

        return $this;
    }

    /**
     * Get mouvement
     *
     * @return \Com\DaufinBundle\Entity\Mouvement
     */
    public function getMouvement()
    {
        return $this->mouvement;
    }

    public function __toString(){return $this->id;}
}
