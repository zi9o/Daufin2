<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock", indexes={@ORM\Index(name="FK_STOCK", columns={"AGENCE"}), @ORM\Index(name="FK_STOCK2", columns={"UNITE_MANU"})})
 * @ORM\Entity
 */
class Stock
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
     * @ORM\Column(name="TYPE_STOCK", type="string", length=64, nullable=true)
     */
    private $typeStock;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set typeStock
     *
     * @param string $typeStock
     * @return Stock
     */
    public function setTypeStock($typeStock)
    {
        $this->typeStock = $typeStock;

        return $this;
    }

    /**
     * Get typeStock
     *
     * @return string
     */
    public function getTypeStock()
    {
        return $this->typeStock;
    }

    /**
     * Set agence
     *
     * @param \Com\DaufinBundle\Entity\Agence $agence
     * @return Stock
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
     * @return Stock
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
