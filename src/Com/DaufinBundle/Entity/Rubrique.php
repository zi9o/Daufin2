<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rubrique
 *
 * @ORM\Table(name="rubrique")
 * @ORM\Entity
 */
class Rubrique
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
     * @ORM\Column(name="LIBELLE_RUB", type="string", length=40, nullable=true)
     */
    private $libelleRub;
    /**
     * @var float
     *
     * @ORM\Column(name="taxeRubrique", type="float", precision=10, scale=0, nullable=true)
     */
    private $taxeRubrique;



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
     * Set libelleRub
     *
     * @param string $libelleRub
     * @return Rubrique
     */
    public function setLibelleRub($libelleRub)
    {
        $this->libelleRub = $libelleRub;

        return $this;
    }

    /**
     * Get libelleRub
     *
     * @return string 
     */
    public function getLibelleRub()
    {
        return $this->libelleRub;
    }
    public function __toString(){return $this->libelleRub;}
    
	public function getTaxeRubrique() {
		return $this->taxeRubrique;
	}
	public function setTaxeRubrique($taxeRubrique) {
		$this->taxeRubrique = $taxeRubrique;
		return $this;
	}
	
    
}
