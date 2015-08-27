<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trajet
 *
 * @ORM\Table(name="trajet")
 * @ORM\Entity
 */
class Trajet
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
     * @ORM\Column(name="CODE_TRAJET", type="string", length=50, nullable=true)
     */
    private $codeTrajet;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELLE_TRAJET", type="string", length=50, nullable=true)
     */
    private $libelleTrajet;



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
     * Set codeTrajet
     *
     * @param string $codeTrajet
     * @return Trajet
     */
    public function setCodeTrajet($codeTrajet)
    {
        $this->codeTrajet = $codeTrajet;

        return $this;
    }

    /**
     * Get codeTrajet
     *
     * @return string 
     */
    public function getCodeTrajet()
    {
        return $this->codeTrajet;
    }

    /**
     * Set libelleTrajet
     *
     * @param string $libelleTrajet
     * @return Trajet
     */
    public function setLibelleTrajet($libelleTrajet)
    {
        $this->libelleTrajet = $libelleTrajet;

        return $this;
    }

    /**
     * Get libelleTrajet
     *
     * @return string 
     */
    public function getLibelleTrajet()
    {
        return $this->libelleTrajet;
    }
    public function __toString(){return $this->libelleTrajet;}
}
