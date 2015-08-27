<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secteur
 *
 * @ORM\Table(name="secteur", indexes={@ORM\Index(name="FK_ORGANISER", columns={"VILLE"})})
 * @ORM\Entity
 */
class Secteur
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
     * @ORM\Column(name="Code_Secteur", type="string", length=20, nullable=false)
     */
    private $codeSecteur;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELLE_SECTEUR", type="string", length=40, nullable=true)
     */
    private $libelleSecteur;

    /**
     * @var \Ville
     *
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="VILLE", referencedColumnName="ID")
     * })
     */
    private $ville;



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
     * Set codeSecteur
     *
     * @param string $codeSecteur
     * @return Secteur
     */
    public function setCodeSecteur($codeSecteur)
    {
        $this->codeSecteur = $codeSecteur;

        return $this;
    }

    /**
     * Get codeSecteur
     *
     * @return string 
     */
    public function getCodeSecteur()
    {
        return $this->codeSecteur;
    }

    /**
     * Set libelleSecteur
     *
     * @param string $libelleSecteur
     * @return Secteur
     */
    public function setLibelleSecteur($libelleSecteur)
    {
        $this->libelleSecteur = $libelleSecteur;

        return $this;
    }

    /**
     * Get libelleSecteur
     *
     * @return string 
     */
    public function getLibelleSecteur()
    {
        return $this->libelleSecteur;
    }

    /**
     * Set ville
     *
     * @param \Com\DaufinBundle\Entity\Ville $ville
     * @return Secteur
     */
    public function setVille(\Com\DaufinBundle\Entity\Ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \Com\DaufinBundle\Entity\Ville 
     */
    public function getVille()
    {
        return $this->ville;
    }
    public function __toString(){return $this->libelleSecteur;}
}
