<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class Taxation
{


	protected $ramasseur;
	protected $receptionneur;
	protected $agenceDepart;
	protected $agenceArrivee;
	protected $expediteur;
	protected $siteExp;
	protected $siteDest;	
	protected $destinataire;	
	protected $expedition;
	
	protected $villeExpediteur;
	protected $villeDestinataire;
	
	protected $AdresseExpediteur;
	protected $AdresseDestinataire;
	
	protected $TelExpediteur;
	protected $TelDestinataire;
	
	protected $modeExp;
	protected $typeExp;
	protected $natureExp;
	protected $nbreColis;
	protected $poids;
	protected $volume;
	protected $nbrePalettes;
	protected $typeLivraison;
	protected $remarque;
	
	protected $codeDeclaration;
	
	protected $montant;
	
	protected $crbt;
	protected $cheque;
	protected $traite;
	protected $cBonLivr;
	protected $valeurDecl;
	protected $dateDeclaration;
	
	protected $agenceTransit;
	protected $typeTransit;
	protected $ExpTransTransit;
	
	
	public function __construct()
	{
		$this->ramasseur = new Personnel();
		$this->receptionneur=new Personnel();
		$this->expediteur=new Client();		
		$this->destinataire=new Client();
		

		
	}
	
	
	public function getRamasseur() {
		return $this->ramasseur;
	}
	public function setRamasseur($ramasseur) {
		$this->ramasseur = $ramasseur;
		return $this;
	}
	public function getReceptionneur() {
		return $this->receptionneur;
	}
	public function setReceptionneur($receptionneur) {
		$this->receptionneur = $receptionneur;
		return $this;
	}
	public function getAgence() {
		return $this->agence;
	}
	public function setAgence($agence) {
		$this->agence = $agence;
		return $this;
	}
	public function getDate() {
		return $this->date;
	}
	public function setDate($date) {
		$this->date = $date;
		return $this;
	}
	public function getExpediteur() {
		return $this->expediteur;
	}
	public function setExpediteur($expediteur) {
		$this->expediteur = $expediteur;
		return $this;
	}
	public function getDestinataire() {
		return $this->destinataire;
	}
	public function setDestinataire($destinataire) {
		$this->destinataire = $destinataire;
		return $this;
	}
	public function getExpedition() {
		return $this->expedition;
	}
	public function setExpedition($expedition) {
		$this->expedition = $expedition;
		return $this;
	}
	public function getCrbt() {
		return $this->crbt;
	}
	public function setCrbt($crbt) {
		$this->crbt = $crbt;
		return $this;
	}
	public function getCheque() {
		return $this->cheque;
	}
	public function setCheque($cheque) {
		$this->cheque = $cheque;
		return $this;
	}
	public function getTraite() {
		return $this->traite;
	}
	public function setTraite($traite) {
		$this->traite = $traite;
		return $this;
	}
	public function getCBonLivr() {
		return $this->cBonLivr;
	}
	public function setCBonLivr($cBonLivr) {
		$this->cBonLivr = $cBonLivr;
		return $this;
	}
	public function getModeExp() {
		return $this->modeExp;
	}
	public function setModeExp($modeExp) {
		$this->modeExp = $modeExp;
		return $this;
	}
	public function getTypeExp() {
		return $this->typeExp;
	}
	public function setTypeExp($typeExp) {
		$this->typeExp = $typeExp;
		return $this;
	}
	public function getNatureExp() {
		return $this->natureExp;
	}
	public function setNatureExp($natureExp) {
		$this->natureExp = $natureExp;
		return $this;
	}
	public function getNbreColis() {
		return $this->nbreColis;
	}
	public function setNbreColis($nbreColis) {
		$this->nbreColis = $nbreColis;
		return $this;
	}
	public function getPoids() {
		return $this->poids;
	}
	public function setPoids($poids) {
		$this->poids = $poids;
		return $this;
	}
	public function getVolume() {
		return $this->volume;
	}
	public function setVolume($volume) {
		$this->volume = $volume;
		return $this;
	}
	public function getNbrePalettes() {
		return $this->nbrePalettes;
	}
	public function setNbrePalettes($nbrePalettes) {
		$this->nbrePalettes = $nbrePalettes;
		return $this;
	}
	public function getTypeLivraison() {
		return $this->typeLivraison;
	}
	public function setTypeLivraison($typeLivraison) {
		$this->typeLivraison = $typeLivraison;
		return $this;
	}
	public function getRemarque() {
		return $this->remarque;
	}
	public function setRemarque($remarque) {
		$this->remarque = $remarque;
		return $this;
	}
	public function getMontant() {
		return $this->montant;
	}
	public function setMontant($montant) {
		$this->montant = $montant;
		return $this;
	}
	public function getValeurDecl() {
		return $this->valeurDecl;
	}
	public function setValeurDecl($valeurDecl) {
		$this->valeurDecl = $valeurDecl;
		return $this;
	}
	public function getVilleExpediteur() {
		return $this->villeExpediteur;
	}
	public function setVilleExpediteur($villeExpediteur) {
		$this->villeExpediteur = $villeExpediteur;
		return $this;
	}
	public function getVilleDestinataire() {
		return $this->villeDestinataire;
	}
	public function setVilleDestinataire($villeDestinataire) {
		$this->villeDestinataire = $villeDestinataire;
		return $this;
	}
	public function getAdresseExpediteur() {
		return $this->AdresseExpediteur;
	}
	public function setAdresseExpediteur($AdresseExpediteur) {
		$this->AdresseExpediteur = $AdresseExpediteur;
		return $this;
	}
	public function getAdresseDestinataire() {
		return $this->AdresseDestinataire;
	}
	public function setAdresseDestinataire($AdresseDestinataire) {
		$this->AdresseDestinataire = $AdresseDestinataire;
		return $this;
	}
	public function getTelExpediteur() {
		return $this->TelExpediteur;
	}
	public function setTelExpediteur($TelExpediteur) {
		$this->TelExpediteur = $TelExpediteur;
		return $this;
	}
	public function getTelDestinataire() {
		return $this->TelDestinataire;
	}
	public function setTelDestinataire($TelDestinataire) {
		$this->TelDestinataire = $TelDestinataire;
		return $this;
	}
	public function getSiteExp() {
		return $this->siteExp;
	}
	public function setSiteExp($siteExp) {
		$this->siteExp = $siteExp;
		return $this;
	}
	public function getSiteDest() {
		return $this->siteDest;
	}
	public function setSiteDest($siteDest) {
		$this->siteDest = $siteDest;
		return $this;
	}
	public function getDateDeclaration() {
		return $this->dateDeclaration;
	}
	public function setDateDeclaration($dateDeclaration) {
		$this->dateDeclaration = $dateDeclaration;
		return $this;
	}
	public function getCodeDeclaration() {
		return $this->codeDeclaration;
	}
	public function setCodeDeclaration($codeDeclaration) {
		$this->codeDeclaration = $codeDeclaration;
		return $this;
	}
	public function getAgenceDepart() {
		return $this->agenceDepart;
	}
	public function setAgenceDepart($agenceDepart) {
		$this->agenceDepart = $agenceDepart;
		return $this;
	}
	public function getAgenceArrivee() {
		return $this->agenceArrivee;
	}
	public function setAgenceArrivee($agenceArrivee) {
		$this->agenceArrivee = $agenceArrivee;
		return $this;
	}
	public function getAgenceTransit() {
		return $this->agenceTransit;
	}
	public function setAgenceTransit($agenceTransit) {
		$this->agenceTransit = $agenceTransit;
		return $this;
	}
	public function getTypeTransit() {
		return $this->typeTransit;
	}
	public function setTypeTransit($typeTransit) {
		$this->typeTransit = $typeTransit;
		return $this;
	}
	public function getExpTransTransit() {
		return $this->ExpTransTransit;
	}
	public function setExpTransTransit($ExpTransTransit) {
		$this->ExpTransTransit = $ExpTransTransit;
		return $this;
	}
	
	
	
	
	
	
	
	
	
	

	 
	

}
