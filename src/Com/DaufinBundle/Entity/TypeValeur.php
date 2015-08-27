<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeValeur
 *
 * @ORM\Table(name="type_valeur")
 * @ORM\Entity
 */
class TypeValeur
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
     * @ORM\Column(name="LIBELLE_T_VAL", type="string", length=50, nullable=true)
     */
    private $libelleTVal;

    /**
     * @var integer
     *
     * @ORM\Column(name="MAX_Type", type="integer", nullable=true)
     */
    private $maxType;

    /**
     * @var integer
     *
     * @ORM\Column(name="MIN_Min", type="integer", nullable=true)
     */
    private $minMin;



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
     * Set libelleTVal
     *
     * @param string $libelleTVal
     * @return TypeValeur
     */
    public function setLibelleTVal($libelleTVal)
    {
        $this->libelleTVal = $libelleTVal;

        return $this;
    }

    /**
     * Get libelleTVal
     *
     * @return string 
     */
    public function getLibelleTVal()
    {
        return $this->libelleTVal;
    }

    /**
     * Set maxType
     *
     * @param integer $maxType
     * @return TypeValeur
     */
    public function setMaxType($maxType)
    {
        $this->maxType = $maxType;

        return $this;
    }

    /**
     * Get maxType
     *
     * @return integer 
     */
    public function getMaxType()
    {
        return $this->maxType;
    }

    /**
     * Set minMin
     *
     * @param integer $minMin
     * @return TypeValeur
     */
    public function setMinMin($minMin)
    {
        $this->minMin = $minMin;

        return $this;
    }

    /**
     * Get minMin
     *
     * @return integer 
     */
    public function getMinMin()
    {
        return $this->minMin;
    }
    public function __toString(){
    	return '('.$this->minMin.','.$this->maxType.') '.$this->libelleTVal;
    }
}
