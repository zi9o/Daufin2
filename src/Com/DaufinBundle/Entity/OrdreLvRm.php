<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdreLvRm
 *
 * @ORM\Table(name="ordre_lv_rm", indexes={@ORM\Index(name="FK_DIRIGER", columns={"SECTEUR"}), @ORM\Index(name="FK_TRANSPORTER_LV_RM", columns={"VEHICULE"})})
 * @ORM\Entity
 */
class OrdreLvRm
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
     * @ORM\Column(name="DATE_CREATION", type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE_ORDRE", type="string", length=26, nullable=true)
     */
    private $typeOrdre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_LIVRAISON", type="datetime", nullable=true)
     */
    private $dateLivraison;

    /**
     * @var integer
     *
     * @ORM\Column(name="ORDRE_LIVRAISON", type="integer", nullable=true)
     */
    private $ordreLivraison;

    /**
     * @var \Secteur
     *
     * @ORM\ManyToOne(targetEntity="Secteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SECTEUR", referencedColumnName="ID")
     * })
     */
    private $secteur;

    /**
     * @var \Vehicule
     *
     * @ORM\ManyToOne(targetEntity="Vehicule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="VEHICULE", referencedColumnName="ID")
     * })
     */
    private $vehicule;



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
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return OrdreLvRm
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set typeOrdre
     *
     * @param string $typeOrdre
     * @return OrdreLvRm
     */
    public function setTypeOrdre($typeOrdre)
    {
        $this->typeOrdre = $typeOrdre;

        return $this;
    }

    /**
     * Get typeOrdre
     *
     * @return string 
     */
    public function getTypeOrdre()
    {
        return $this->typeOrdre;
    }

    /**
     * Set dateLivraison
     *
     * @param \DateTime $dateLivraison
     * @return OrdreLvRm
     */
    public function setDateLivraison($dateLivraison)
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    /**
     * Get dateLivraison
     *
     * @return \DateTime 
     */
    public function getDateLivraison()
    {
        return $this->dateLivraison;
    }

    /**
     * Set ordreLivraison
     *
     * @param integer $ordreLivraison
     * @return OrdreLvRm
     */
    public function setOrdreLivraison($ordreLivraison)
    {
        $this->ordreLivraison = $ordreLivraison;

        return $this;
    }

    /**
     * Get ordreLivraison
     *
     * @return integer 
     */
    public function getOrdreLivraison()
    {
        return $this->ordreLivraison;
    }

    /**
     * Set secteur
     *
     * @param \Com\DaufinBundle\Entity\Secteur $secteur
     * @return OrdreLvRm
     */
    public function setSecteur(\Com\DaufinBundle\Entity\Secteur $secteur = null)
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * Get secteur
     *
     * @return \Com\DaufinBundle\Entity\Secteur 
     */
    public function getSecteur()
    {
        return $this->secteur;
    }

    /**
     * Set vehicule
     *
     * @param \Com\DaufinBundle\Entity\Vehicule $vehicule
     * @return OrdreLvRm
     */
    public function setVehicule(\Com\DaufinBundle\Entity\Vehicule $vehicule = null)
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    /**
     * Get vehicule
     *
     * @return \Com\DaufinBundle\Entity\Vehicule 
     */
    public function getVehicule()
    {
        return $this->vehicule;
    }
    public function __toString(){return $this->id;}
}
