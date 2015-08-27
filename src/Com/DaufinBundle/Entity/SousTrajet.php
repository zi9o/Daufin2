<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SousTrajet
 *
 * @ORM\Table(name="sous_trajet", indexes={@ORM\Index(name="FK_VILLEARRIVEE", columns={"VILLE_Arrivee"}), @ORM\Index(name="FK_VILLEDEPART", columns={"VILLE_Depart"})})
 * @ORM\Entity
 */
class SousTrajet
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
     * @ORM\Column(name="CODE_SOUS_TRAJET", type="string", length=56, nullable=true)
     */
    private $codeSousTrajet;

    /**
     * @var \Ville
     *
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="VILLE_Arrivee", referencedColumnName="ID")
     * })
     */
    private $villeArrivee;

    /**
     * @var \Ville
     *
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="VILLE_Depart", referencedColumnName="ID")
     * })
     */
    private $villeDepart;



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
     * Set codeSousTrajet
     *
     * @param string $codeSousTrajet
     * @return SousTrajet
     */
    public function setCodeSousTrajet($codeSousTrajet)
    {
        $this->codeSousTrajet = $codeSousTrajet;

        return $this;
    }

    /**
     * Get codeSousTrajet
     *
     * @return string 
     */
    public function getCodeSousTrajet()
    {
        return $this->codeSousTrajet;
    }

    /**
     * Set villeArrivee
     *
     * @param \Com\DaufinBundle\Entity\Ville $villeArrivee
     * @return SousTrajet
     */
    public function setVilleArrivee(\Com\DaufinBundle\Entity\Ville $villeArrivee = null)
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    /**
     * Get villeArrivee
     *
     * @return \Com\DaufinBundle\Entity\Ville 
     */
    public function getVilleArrivee()
    {
        return $this->villeArrivee;
    }

    /**
     * Set villeDepart
     *
     * @param \Com\DaufinBundle\Entity\Ville $villeDepart
     * @return SousTrajet
     */
    public function setVilleDepart(\Com\DaufinBundle\Entity\Ville $villeDepart = null)
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    /**
     * Get villeDepart
     *
     * @return \Com\DaufinBundle\Entity\Ville 
     */
    public function getVilleDepart()
    {
        return $this->villeDepart;
    }
    public function __toString(){
    	return $this->codeSousTrajet.'-'.$this->villeDepart->getLibelleVille().'->'.$this->villeArrivee->getLibelleVille();
    }
}
