<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity
 */
class Client
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
     * @ORM\Column(name="CODE_CLIENT", type="string", length=56, nullable=true)
     */
    private $codeClient;

    /**
     * @var string
     *
     * @ORM\Column(name="TEL_CLT", type="string", length=30, nullable=true)
     */
    private $telClt;

    /**
     * @var string
     *
     * @ORM\Column(name="FAX_CLT", type="string", length=30, nullable=true)
     */
    private $faxClt;

    /**
     * @var string
     *
     * @ORM\Column(name="CONTACT", type="string", length=30, nullable=true)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="ADRESSE_CLT", type="string", length=100, nullable=true)
     */
    private $adresseClt;

    /**
     * @var string
     *
     * @ORM\Column(name="R_SOCIALE", type="string", length=30, nullable=true)
     */
    private $rSociale;

    /**
     * @var string
     *
     * @ORM\Column(name="PATENTE", type="string", length=30, nullable=true)
     */
    private $patente;

    /**
     * @var string
     *
     * @ORM\Column(name="R_COMMERCE", type="string", length=30, nullable=true)
     */
    private $rCommerce;

    /**
     * @var string
     *
     * @ORM\Column(name="ID_FISCALE", type="string", length=30, nullable=true)
     */
    private $idFiscale;

    /**
     * @var string
     *
     * @ORM\Column(name="DIR_GENERAL", type="string", length=30, nullable=true)
     */
    private $dirGeneral;

    /**
     * @var string
     *
     * @ORM\Column(name="DIR_FINANCIER", type="string", length=30, nullable=true)
     */
    private $dirFinancier;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_PART", type="string", length=30, nullable=true)
     */
    private $nomPart;

    /**
     * @var string
     *
     * @ORM\Column(name="PRENOM_PART", type="string", length=30, nullable=true)
     */
    private $prenomPart;

    /**
     * @var string
     *
     * @ORM\Column(name="CIN_PER", type="string", length=30, nullable=true)
     */
    private $cinPer;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE_CLIENT", type="string", length=30, nullable=true)
     */
    private $typeClient;



    /**
     * @var \Secteur
     *
     * @ORM\ManyToOne(targetEntity="Secteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="secteur", referencedColumnName="ID")
     * })
     */
    private $secteur;

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
     * Set codeClient
     *
     * @param string $codeClient
     * @return Client
     */
    public function setCodeClient($codeClient)
    {
        $this->codeClient = $codeClient;

        return $this;
    }

    /**
     * Get codeClient
     *
     * @return string 
     */
    public function getCodeClient()
    {
        return $this->codeClient;
    }

    /**
     * Set telClt
     *
     * @param string $telClt
     * @return Client
     */
    public function setTelClt($telClt)
    {
        $this->telClt = $telClt;

        return $this;
    }

    /**
     * Get telClt
     *
     * @return string 
     */
    public function getTelClt()
    {
        return $this->telClt;
    }

    /**
     * Set faxClt
     *
     * @param string $faxClt
     * @return Client
     */
    public function setFaxClt($faxClt)
    {
        $this->faxClt = $faxClt;

        return $this;
    }

    /**
     * Get faxClt
     *
     * @return string 
     */
    public function getFaxClt()
    {
        return $this->faxClt;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Client
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set adresseClt
     *
     * @param string $adresseClt
     * @return Client
     */
    public function setAdresseClt($adresseClt)
    {
        $this->adresseClt = $adresseClt;

        return $this;
    }

    /**
     * Get adresseClt
     *
     * @return string 
     */
    public function getAdresseClt()
    {
        return $this->adresseClt;
    }

    /**
     * Set rSociale
     *
     * @param string $rSociale
     * @return Client
     */
    public function setRSociale($rSociale)
    {
        $this->rSociale = $rSociale;

        return $this;
    }

    /**
     * Get rSociale
     *
     * @return string 
     */
    public function getRSociale()
    {
        return $this->rSociale;
    }

    /**
     * Set patente
     *
     * @param string $patente
     * @return Client
     */
    public function setPatente($patente)
    {
        $this->patente = $patente;

        return $this;
    }

    /**
     * Get patente
     *
     * @return string 
     */
    public function getPatente()
    {
        return $this->patente;
    }

    /**
     * Set rCommerce
     *
     * @param string $rCommerce
     * @return Client
     */
    public function setRCommerce($rCommerce)
    {
        $this->rCommerce = $rCommerce;

        return $this;
    }

    /**
     * Get rCommerce
     *
     * @return string 
     */
    public function getRCommerce()
    {
        return $this->rCommerce;
    }

    /**
     * Set idFiscale
     *
     * @param string $idFiscale
     * @return Client
     */
    public function setIdFiscale($idFiscale)
    {
        $this->idFiscale = $idFiscale;

        return $this;
    }

    /**
     * Get idFiscale
     *
     * @return string 
     */
    public function getIdFiscale()
    {
        return $this->idFiscale;
    }

    /**
     * Set dirGeneral
     *
     * @param string $dirGeneral
     * @return Client
     */
    public function setDirGeneral($dirGeneral)
    {
        $this->dirGeneral = $dirGeneral;

        return $this;
    }

    /**
     * Get dirGeneral
     *
     * @return string 
     */
    public function getDirGeneral()
    {
        return $this->dirGeneral;
    }

    /**
     * Set dirFinancier
     *
     * @param string $dirFinancier
     * @return Client
     */
    public function setDirFinancier($dirFinancier)
    {
        $this->dirFinancier = $dirFinancier;

        return $this;
    }

    /**
     * Get dirFinancier
     *
     * @return string 
     */
    public function getDirFinancier()
    {
        return $this->dirFinancier;
    }

    /**
     * Set nomPart
     *
     * @param string $nomPart
     * @return Client
     */
    public function setNomPart($nomPart)
    {
        $this->nomPart = $nomPart;

        return $this;
    }

    /**
     * Get nomPart
     *
     * @return string 
     */
    public function getNomPart()
    {
        return $this->nomPart;
    }

    /**
     * Set prenomPart
     *
     * @param string $prenomPart
     * @return Client
     */
    public function setPrenomPart($prenomPart)
    {
        $this->prenomPart = $prenomPart;

        return $this;
    }

    /**
     * Get prenomPart
     *
     * @return string 
     */
    public function getPrenomPart()
    {
        return $this->prenomPart;
    }

    /**
     * Set cinPer
     *
     * @param string $cinPer
     * @return Client
     */
    public function setCinPer($cinPer)
    {
        $this->cinPer = $cinPer;

        return $this;
    }

    /**
     * Get cinPer
     *
     * @return string 
     */
    public function getCinPer()
    {
        return $this->cinPer;
    }

    /**
     * Set typeClient
     *
     * @param string $typeClient
     * @return Client
     */
    public function setTypeClient($typeClient)
    {
        $this->typeClient = $typeClient;

        return $this;
    }

    /**
     * Get typeClient
     *
     * @return string 
     */
    public function getTypeClient()
    {
        return $this->typeClient;
    }
    public function __toString(){
    	if($this->typeClient=="Compte") return $this->id.' '.$this->rSociale;
    	else return $this->id.' '.$this->nomPart.' '.$this->prenomPart;
    
    }
    
    /**
     * Get secteur
     *
     * @return Secteur
     */
	public function getSecteur() {
		return $this->secteur;
	}
	/**
	 * Set secteur
	 *
	 * @param Secteur $secteur
	 * @return Client
	 */
	public function setSecteur(\Com\DaufinBundle\Entity\Secteur $secteur) {
		$this->secteur = $secteur;
		return $this;
	}
	

	
}
