<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mouvement
 *
 * @ORM\Table(name="mouvement")
 * @ORM\Entity
 */
class Mouvement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_MOUV", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELLE_MOUV", type="string", length=64, nullable=true)
     */
    private $libelleMouv;



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
     * Set libelleMouv
     *
     * @param string $libelleMouv
     * @return Mouvement
     */
    public function setLibelleMouv($libelleMouv)
    {
        $this->libelleMouv = $libelleMouv;

        return $this;
    }

    /**
     * Get libelleMouv
     *
     * @return string 
     */
    public function getLibelleMouv()
    {
        return $this->libelleMouv;
    }

    public function __toString(){return $this->libelleMouv;}
}
