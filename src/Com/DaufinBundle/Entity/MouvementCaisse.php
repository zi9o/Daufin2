<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MouvementCaisse
 *
 * @ORM\Table(name="mouvement_caisse", indexes={@ORM\Index(name="FK_MOUVEMENT_Caisse_AGENCE", columns={"AGENCE"}), @ORM\Index(name="FK_MOUVEMENT_Caisse_PERSONNEL", columns={"PERSONNEL"}), @ORM\Index(name="FK_MOUVEMENT_Caisse_CAISSE", columns={"Caisse"}), @ORM\Index(name="FK_MOUVEMENT_Caisse_EXPEDITION", columns={"Expedition"})})
 * @ORM\Entity
 */
class MouvementCaisse
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
     * @ORM\Column(name="TYPE_Mouvement", type="string", length=20, nullable=true)
     */
    private $typeMouvement;

    /**
     * @var string
     *
     * @ORM\Column(name="Libelle_Mouvement", type="string", length=50, nullable=true)
     */
    private $libelleMouvement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_MOUVEMENT", type="datetime", nullable=true)
     */
    private $dateMouvement;

    /**
     * @var float
     *
     * @ORM\Column(name="Valeur", type="float", precision=10, scale=0, nullable=true)
     */
    private $valeur;

    /**
     * @var \Agence
     *
     * @ORM\ManyToOne(targetEntity="Agence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="AGENCE", referencedColumnName="ID")
     * })
     */
    private $agence;

    /**
     * @var \Personnel
     *
     * @ORM\ManyToOne(targetEntity="Personnel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PERSONNEL", referencedColumnName="ID")
     * })
     */
    private $personnel;

    /**
     * @var \Caisse
     *
     * @ORM\ManyToOne(targetEntity="Caisse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Caisse", referencedColumnName="ID")
     * })
     */
    private $caisse;

    /**
     * @var \Expedition
     *
     * @ORM\ManyToOne(targetEntity="Expedition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Expedition", referencedColumnName="ID")
     * })
     */
    private $expedition;
    
	public function getId() {
		return $this->id;
	}
	public function getTypeMouvement() {
		return $this->typeMouvement;
	}
	public function setTypeMouvement($typeMouvement) {
		$this->typeMouvement = $typeMouvement;
		return $this;
	}
	public function getLibelleMouvement() {
		return $this->libelleMouvement;
	}
	public function setLibelleMouvement($libelleMouvement) {
		$this->libelleMouvement = $libelleMouvement;
		return $this;
	}
	public function getDateMouvement() {
		return $this->dateMouvement;
	}
	public function setDateMouvement(\DateTime $dateMouvement) {
		$this->dateMouvement = $dateMouvement;
		return $this;
	}
	public function getValeur() {
		return $this->valeur;
	}
	public function setValeur($valeur) {
		$this->valeur = $valeur;
		return $this;
	}
	public function getAgence() {
		return $this->agence;
	}
	public function setAgence(\Com\DaufinBundle\Entity\Agence $agence) {
		$this->agence = $agence;
		return $this;
	}
	public function getPersonnel() {
		return $this->personnel;
	}
	public function setPersonnel(\Com\DaufinBundle\Entity\Personnel $personnel) {
		$this->personnel = $personnel;
		return $this;
	}
	public function getCaisse() {
		return $this->caisse;
	}
	public function setCaisse(\Com\DaufinBundle\Entity\Caisse $caisse) {
		$this->caisse = $caisse;
		return $this;
	}
	public function getExpedition() {
		return $this->expedition;
	}
	public function setExpedition(\Com\DaufinBundle\Entity\Expedition $expedition) {
		$this->expedition = $expedition;
		return $this;
	}
	


}
