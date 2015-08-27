<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="ville")
 * @ORM\Entity
 */
class Ville
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
     * @ORM\Column(name="CODE_VILLE", type="string", length=16, nullable=true)
     */
    private $codeVille;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELLE_VILLE", type="string", length=40, nullable=true)
     */
    private $libelleVille;



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
     * Set codeVille
     *
     * @param string $codeVille
     * @return Ville
     */
    public function setCodeVille($codeVille)
    {
        $this->codeVille = $codeVille;

        return $this;
    }

    /**
     * Get codeVille
     *
     * @return string 
     */
    public function getCodeVille()
    {
        return $this->codeVille;
    }

    /**
     * Set libelleVille
     *
     * @param string $libelleVille
     * @return Ville
     */
    public function setLibelleVille($libelleVille)
    {
        $this->libelleVille = $libelleVille;

        return $this;
    }

    /**
     * Get libelleVille
     *
     * @return string 
     */
    public function getLibelleVille()
    {
        return $this->libelleVille;
    }
    public function __toString(){return $this->libelleVille;}
}
