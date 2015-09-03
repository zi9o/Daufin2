<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="reglement_facture")
 * @ORM\Entity
 */
class ReglementFacture {

    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Reglement
     *
     * @ORM\ManyToOne(targetEntity="Reglement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reglement", referencedColumnName="ID")
     * })
     */
    private $reglement;

    /**
     * @var \Facture
     *
     * @ORM\ManyToOne(targetEntity="Facture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="facture", referencedColumnName="ID")
     * })
     */
    private $facture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime", nullable=true)
     */
    private $dateCreation;

    /**
     * @var float
     *
     * @ORM\Column(name="montantReglement", type="float", precision=10, scale=0, nullable=true)
     */
    private $montant;

    public function __construct() {
        $this->dateCreation = new \DateTime();
    }

    public function getId() {
        return $this->id;
    }

    public function getReglement() {
        return $this->reglement;
    }

    public function setReglement(\Com\DaufinBundle\Entity\Reglement $reglement) {
        $this->reglement = $reglement;
        return $this;
    }

    public function getFacture() {
        return $this->facture;
    }

    public function setFacture(\Com\DaufinBundle\Entity\Facture $facture) {
        $this->facture = $facture;
        return $this;
    }

    public function getDateCreation() {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTime $dateCreation) {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getMontant() {
        return $this->montant;
    }

    public function setMontant($montant) {
        $this->montant = $montant;
        return $this;
    }

    public function __toString() {
        return $this->id;
    }

}
