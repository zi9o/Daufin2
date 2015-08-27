<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caisse
 *
 * @ORM\Table(name="caisse", indexes={@ORM\Index(name="FK_Caisse_Agence", columns={"AGENCE"})})
 * @ORM\Entity
 */
class Caisse
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
     * @ORM\Column(name="TYPE_Caisse", type="string", length=20, nullable=true)
     */
    private $typeCaisse;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle_Caisse", type="string", length=30, nullable=true)
     */
    private $libelleCaisse;
    /**
     * @var string
     *
     * @ORM\Column(name="categorieCaisse", type="string", length=30, nullable=true)
     */
    private $categorieCaisse;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_Debut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var float
     *
     * @ORM\Column(name="Solde_Caisse", type="float", precision=10, scale=0, nullable=true)
     */
    private $soldeCaisse;

    /**
     * @var \Agence
     *
     * @ORM\ManyToOne(targetEntity="Agence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="AGENCE", referencedColumnName="ID")
     * })
     */
    private $agence;
    
	public function getId() {
		return $this->id;
	}
	public function getTypeCaisse() {
		return $this->typeCaisse;
	}
	public function setTypeCaisse($typeCaisse) {
		$this->typeCaisse = $typeCaisse;
		return $this;
	}
	public function getLibelleCaisse() {
		return $this->libelleCaisse;
	}
	public function setLibelleCaisse($libelleCaisse) {
		$this->libelleCaisse = $libelleCaisse;
		return $this;
	}
	public function getDateDebut() {
		return $this->dateDebut;
	}
	public function setDateDebut(\DateTime $dateDebut) {
		$this->dateDebut = $dateDebut;
		return $this;
	}
	public function getSoldeCaisse() {
		return $this->soldeCaisse;
	}
	public function setSoldeCaisse($soldeCaisse) {
		$this->soldeCaisse = $soldeCaisse;
		return $this;
	}
	public function getAgence() {
		return $this->agence;
	}
	public function setAgence(\Com\DaufinBundle\Entity\Agence $agence) {
		$this->agence = $agence;
		return $this;
	}
	

	public function  __toString(){
		return $this->libelleCaisse.' - '.$this->categorieCaisse;
	}
	public function getCategorieCaisse() {
		return $this->categorieCaisse;
	}
	public function setCategorieCaisse($categorieCaisse) {
		$this->categorieCaisse = $categorieCaisse;
		return $this;
	}
	

	
}
