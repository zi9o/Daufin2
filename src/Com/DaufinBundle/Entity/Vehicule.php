<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vehicule
 *
 * @ORM\Table(name="vehicule")
 * @ORM\Entity
 */
class Vehicule
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
     * @ORM\Column(name="MATRICULE_VEH", type="string", length=48, nullable=true)
     */
    private $matriculeVeh;

    /**
     * @var string
     *
     * @ORM\Column(name="MARQUE_VEH", type="string", length=48, nullable=true)
     */
    private $marqueVeh;

    /**
     * @var string
     *
     * @ORM\Column(name="MODEL_VEH", type="string", length=48, nullable=true)
     */
    private $modelVeh;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE_VEHICULE", type="string", length=48, nullable=true)
     */
    private $typeVehicule;

    /**
     * @var float
     *
     * @ORM\Column(name="POIDS_VIDE", type="float", precision=10, scale=0, nullable=true)
     */
    private $poidsVide;

    /**
     * @var float
     *
     * @ORM\Column(name="POIDS_PLEIN", type="float", precision=10, scale=0, nullable=true)
     */
    private $poidsPlein;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Voyage", inversedBy="vehicule")
     * @ORM\JoinTable(name="effectuer",
     *   joinColumns={
     *     @ORM\JoinColumn(name="VEHICULE", referencedColumnName="ID")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="VOYAGE", referencedColumnName="ID")
     *   }
     * )
     */
    private $voyage;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->voyage = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
     * Set matriculeVeh
     *
     * @param string $matriculeVeh
     * @return Vehicule
     */
    public function setMatriculeVeh($matriculeVeh)
    {
        $this->matriculeVeh = $matriculeVeh;

        return $this;
    }

    /**
     * Get matriculeVeh
     *
     * @return string 
     */
    public function getMatriculeVeh()
    {
        return $this->matriculeVeh;
    }

    /**
     * Set marqueVeh
     *
     * @param string $marqueVeh
     * @return Vehicule
     */
    public function setMarqueVeh($marqueVeh)
    {
        $this->marqueVeh = $marqueVeh;

        return $this;
    }

    /**
     * Get marqueVeh
     *
     * @return string 
     */
    public function getMarqueVeh()
    {
        return $this->marqueVeh;
    }

    /**
     * Set modelVeh
     *
     * @param string $modelVeh
     * @return Vehicule
     */
    public function setModelVeh($modelVeh)
    {
        $this->modelVeh = $modelVeh;

        return $this;
    }

    /**
     * Get modelVeh
     *
     * @return string 
     */
    public function getModelVeh()
    {
        return $this->modelVeh;
    }

    /**
     * Set typeVehicule
     *
     * @param string $typeVehicule
     * @return Vehicule
     */
    public function setTypeVehicule($typeVehicule)
    {
        $this->typeVehicule = $typeVehicule;

        return $this;
    }

    /**
     * Get typeVehicule
     *
     * @return string 
     */
    public function getTypeVehicule()
    {
        return $this->typeVehicule;
    }

    /**
     * Set poidsVide
     *
     * @param float $poidsVide
     * @return Vehicule
     */
    public function setPoidsVide($poidsVide)
    {
        $this->poidsVide = $poidsVide;

        return $this;
    }

    /**
     * Get poidsVide
     *
     * @return float 
     */
    public function getPoidsVide()
    {
        return $this->poidsVide;
    }

    /**
     * Set poidsPlein
     *
     * @param float $poidsPlein
     * @return Vehicule
     */
    public function setPoidsPlein($poidsPlein)
    {
        $this->poidsPlein = $poidsPlein;

        return $this;
    }

    /**
     * Get poidsPlein
     *
     * @return float 
     */
    public function getPoidsPlein()
    {
        return $this->poidsPlein;
    }

    /**
     * Add voyage
     *
     * @param \Com\DaufinBundle\Entity\Voyage $voyage
     * @return Vehicule
     */
    public function addVoyage(\Com\DaufinBundle\Entity\Voyage $voyage)
    {
        $this->voyage[] = $voyage;

        return $this;
    }

    /**
     * Remove voyage
     *
     * @param \Com\DaufinBundle\Entity\Voyage $voyage
     */
    public function removeVoyage(\Com\DaufinBundle\Entity\Voyage $voyage)
    {
        $this->voyage->removeElement($voyage);
    }

    /**
     * Get voyage
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVoyage()
    {
        return $this->voyage;
    }
    public function __toString(){return $this->matriculeVeh;}
}
