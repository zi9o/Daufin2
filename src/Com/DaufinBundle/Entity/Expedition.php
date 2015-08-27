<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expedition
 *
 * @ORM\Table(name="expedition", indexes={@ORM\Index(name="FK_REGROUPER", columns={"EXP_TRANSP"}), @ORM\Index(name="FK_ENV_CLIENT", columns={"ENV_Client"}), @ORM\Index(name="FK_REC_CLIENT", columns={"REC_Client"}), @ORM\Index(name="FK_REC_VILLE", columns={"REC_VILLE"}), @ORM\Index(name="FK_EXP_Fact", columns={"FACTURE"}), @ORM\Index(name="FK_EXP_CLientRegl", columns={"Client_Reglee"}), @ORM\Index(name="FK_ENV_VILLE", columns={"ENV_VILLE"})})
 * @ORM\Entity
 */
class Expedition
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
     * @ORM\Column(name="ENV_DATE", type="datetime", nullable=true)
     */
    private $envDate;

    /**
     * @var string
     *
     * @ORM\Column(name="ENV_REMARQUE", type="string", length=50, nullable=true)
     */
    private $envRemarque;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="REC_DATE", type="datetime", nullable=true)
     */
    private $recDate;

    /**
     * @var string
     *
     * @ORM\Column(name="REC_REMARQUE", type="string", length=50, nullable=true)
     */
    private $recRemarque;

    /**
     * @var float
     *
     * @ORM\Column(name="POIDS_EXP", type="float", precision=10, scale=0, nullable=true)
     */
    private $poidsExp;

    /**
     * @var float
     *
     * @ORM\Column(name="VOLUME_EXP", type="float", precision=10, scale=0, nullable=true)
     */
    private $volumeExp;

    /**
     * @var integer
     *
     * @ORM\Column(name="NBR_COLIS", type="integer", nullable=true)
     */
    private $nbrColis;

    /**
     * @var integer
     *
     * @ORM\Column(name="NBR_PALETS", type="integer", nullable=true)
     */
    private $nbrPalets;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_DECL", type="datetime", nullable=true)
     */
    private $dateDecl;

    /**
     * @var string
     *
     * @ORM\Column(name="MD_PORT", type="string", length=56, nullable=true)
     */
    private $mdPort;

    /**
     * @var float
     *
     * @ORM\Column(name="EXP_VAL", type="float", precision=10, scale=0, nullable=true)
     */
    private $expVal;

    /**
     * @var string
     *
     * @ORM\Column(name="ETAT_EXP", type="string", length=56, nullable=true)
     */
    private $etatExp;

    /**
     * @var float
     *
     * @ORM\Column(name="TOTAL_MONTANT", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalMontant;

    /**
     * @var string
     *
     * @ORM\Column(name="TAX_TYPE", type="string", length=30, nullable=true)
     */
    private $taxType;
    
    /**
     * @var string
     *
     * @ORM\Column(name="type_Livraison", type="string", length=20, nullable=true)
     */
    private $typeLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="MODE_REGL", type="string", length=30, nullable=true)
     */
    private $modeRegl;

    /**
     * @var string
     *
     * @ORM\Column(name="ETAT_REGL", type="string", length=56, nullable=true)
     */
    private $etatRegl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_REGLEMENT", type="datetime", nullable=true)
     */
    private $dateReglement;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ENV_Client", referencedColumnName="ID")
     * })
     */
    private $envClient;

    /**
     * @var \Ville
     *
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ENV_VILLE", referencedColumnName="ID")
     * })
     */
    private $envVille;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="REC_Client", referencedColumnName="ID")
     * })
     */
    private $recClient;

    /**
     * @var \Ville
     *
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="REC_VILLE", referencedColumnName="ID")
     * })
     */
    private $recVille;

    /**
     * @var \ExpTransp
     *
     * @ORM\ManyToOne(targetEntity="ExpTransp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EXP_TRANSP", referencedColumnName="ID")
     * })
     */
    private $expTransp;

    /**
     * @var \Facture
     *
     * @ORM\ManyToOne(targetEntity="Facture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="FACTURE", referencedColumnName="ID")
     * })
     */
    private $facture;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Client_Reglee", referencedColumnName="ID")
     * })
     */
    private $clientReglee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="LV_DATE", type="datetime", nullable=true)
     */
    private $lvDate;

    /**
     * @var string
     *
     * @ORM\Column(name="LV_REMARQUE", type="string", length=50, nullable=true)
     */
    private $lvRemarque;


    /**
     * @var \OrdreLvRm
     *
     * @ORM\ManyToOne(targetEntity="OrdreLvRm")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ORDRE_LV", referencedColumnName="ID")
     * })
     */
    private $ordreLv;

    
    /**
     * @var \Site
     *
     * @ORM\ManyToOne(targetEntity="Site")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EnvSite", referencedColumnName="ID")
     * })
     */
    private $envSite;
    
    /**
     * @var \Site
     *
     * @ORM\ManyToOne(targetEntity="Site")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RecSite", referencedColumnName="ID")
     * })
     */
    private $recSite;
    
    

    /**
     * @var \Secteur
     *
     * @ORM\ManyToOne(targetEntity="Secteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EnvSecteur", referencedColumnName="ID")
     * })
     */
    private $envSecteur;
    
    /**
     * @var \Secteur
     *
     * @ORM\ManyToOne(targetEntity="Secteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RecSecteur", referencedColumnName="ID")
     * })
     */
    private $recSecteur;
    
    

    /**
     * @var \Agence
     *
     * @ORM\ManyToOne(targetEntity="Agence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EnvAgence", referencedColumnName="ID")
     * })
     */
    private $envAgence;
    
    /**
     * @var \Agence
     *
     * @ORM\ManyToOne(targetEntity="Agence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RecAgence", referencedColumnName="ID")
     * })
     */
    private $recAgence;
    
    /**
     * @var string
     *
     * @ORM\Column(name="code_Declaration", type="string", length=30, nullable=true)
     */
    private $codeDeclaration;
    
    /**
     * @var string
     *
     * @ORM\Column(name="RefPaiement", type="string", length=56, nullable=true)
     */
    private $RefPaiement;
    
    /**
     * @var \Agence
     *
     * @ORM\ManyToOne(targetEntity="Agence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agenceTransit", referencedColumnName="ID")
     * })
     */
    private $agenceTransit;
    /**
     * @var string
     *
     * @ORM\Column(name="typeTransit", type="string", length=30, nullable=true)
     */
    private $typeTransit;
    
    /**
     * @var \ExpTransp
     *
     * @ORM\ManyToOne(targetEntity="ExpTransp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ExpTransTransit", referencedColumnName="ID")
     * })
     */
    private $ExpTransTransit;
    
    /**
     * @var \Ville
     *
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TransitVille", referencedColumnName="ID")
     * })
     */
    private $transitVille;
    
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
     * Set envDate
     *
     * @param \DateTime $envDate
     * @return Expedition
     */
    public function setEnvDate($envDate)
    {
        $this->envDate = $envDate;

        return $this;
    }

    /**
     * Get envDate
     *
     * @return \DateTime 
     */
    public function getEnvDate()
    {
        return $this->envDate;
    }

    /**
     * Set envRemarque
     *
     * @param string $envRemarque
     * @return Expedition
     */
    public function setEnvRemarque($envRemarque)
    {
        $this->envRemarque = $envRemarque;

        return $this;
    }

    /**
     * Get envRemarque
     *
     * @return string 
     */
    public function getEnvRemarque()
    {
        return $this->envRemarque;
    }

    /**
     * Set recDate
     *
     * @param \DateTime $recDate
     * @return Expedition
     */
    public function setRecDate($recDate)
    {
        $this->recDate = $recDate;

        return $this;
    }

    /**
     * Get recDate
     *
     * @return \DateTime 
     */
    public function getRecDate()
    {
        return $this->recDate;
    }

    /**
     * Set recRemarque
     *
     * @param string $recRemarque
     * @return Expedition
     */
    public function setRecRemarque($recRemarque)
    {
        $this->recRemarque = $recRemarque;

        return $this;
    }

    /**
     * Get recRemarque
     *
     * @return string 
     */
    public function getRecRemarque()
    {
        return $this->recRemarque;
    }

    /**
     * Set poidsExp
     *
     * @param float $poidsExp
     * @return Expedition
     */
    public function setPoidsExp($poidsExp)
    {
        $this->poidsExp = $poidsExp;

        return $this;
    }

    /**
     * Get poidsExp
     *
     * @return float 
     */
    public function getPoidsExp()
    {
        return $this->poidsExp;
    }

    /**
     * Set volumeExp
     *
     * @param float $volumeExp
     * @return Expedition
     */
    public function setVolumeExp($volumeExp)
    {
        $this->volumeExp = $volumeExp;

        return $this;
    }

    /**
     * Get volumeExp
     *
     * @return float 
     */
    public function getVolumeExp()
    {
        return $this->volumeExp;
    }

    /**
     * Set nbrColis
     *
     * @param integer $nbrColis
     * @return Expedition
     */
    public function setNbrColis($nbrColis)
    {
        $this->nbrColis = $nbrColis;

        return $this;
    }

    /**
     * Get nbrColis
     *
     * @return integer 
     */
    public function getNbrColis()
    {
        return $this->nbrColis;
    }

    /**
     * Set nbrPalets
     *
     * @param integer $nbrPalets
     * @return Expedition
     */
    public function setNbrPalets($nbrPalets)
    {
        $this->nbrPalets = $nbrPalets;

        return $this;
    }

    /**
     * Get nbrPalets
     *
     * @return integer 
     */
    public function getNbrPalets()
    {
        return $this->nbrPalets;
    }

    /**
     * Set dateDecl
     *
     * @param \DateTime $dateDecl
     * @return Expedition
     */
    public function setDateDecl($dateDecl)
    {
        $this->dateDecl = $dateDecl;

        return $this;
    }

    /**
     * Get dateDecl
     *
     * @return \DateTime 
     */
    public function getDateDecl()
    {
        return $this->dateDecl;
    }

    /**
     * Set mdPort
     *
     * @param string $mdPort
     * @return Expedition
     */
    public function setMdPort($mdPort)
    {
        $this->mdPort = $mdPort;

        return $this;
    }

    /**
     * Get mdPort
     *
     * @return string 
     */
    public function getMdPort()
    {
        return $this->mdPort;
    }

    /**
     * Set expVal
     *
     * @param float $expVal
     * @return Expedition
     */
    public function setExpVal($expVal)
    {
        $this->expVal = $expVal;

        return $this;
    }

    /**
     * Get expVal
     *
     * @return float 
     */
    public function getExpVal()
    {
        return $this->expVal;
    }

    /**
     * Set etatExp
     *
     * @param string $etatExp
     * @return Expedition
     */
    public function setEtatExp($etatExp)
    {
        $this->etatExp = $etatExp;

        return $this;
    }

    /**
     * Get etatExp
     *
     * @return string 
     */
    public function getEtatExp()
    {
        return $this->etatExp;
    }

    /**
     * Set totalMontant
     *
     * @param float $totalMontant
     * @return Expedition
     */
    public function setTotalMontant($totalMontant)
    {
        $this->totalMontant = $totalMontant;

        return $this;
    }

    /**
     * Get totalMontant
     *
     * @return float 
     */
    public function getTotalMontant()
    {
        return $this->totalMontant;
    }

    /**
     * Set taxType
     *
     * @param string $taxType
     * @return Expedition
     */
    public function setTaxType($taxType)
    {
        $this->taxType = $taxType;

        return $this;
    }

    /**
     * Get taxType
     *
     * @return string 
     */
    public function getTaxType()
    {
        return $this->taxType;
    }

    /**
     * Set modeRegl
     *
     * @param string $modeRegl
     * @return Expedition
     */
    public function setModeRegl($modeRegl)
    {
        $this->modeRegl = $modeRegl;

        return $this;
    }

    /**
     * Get modeRegl
     *
     * @return string 
     */
    public function getModeRegl()
    {
        return $this->modeRegl;
    }

    /**
     * Set etatRegl
     *
     * @param string $etatRegl
     * @return Expedition
     */
    public function setEtatRegl($etatRegl)
    {
        $this->etatRegl = $etatRegl;

        return $this;
    }

    /**
     * Get etatRegl
     *
     * @return string 
     */
    public function getEtatRegl()
    {
        return $this->etatRegl;
    }

    /**
     * Set dateReglement
     *
     * @param \DateTime $dateReglement
     * @return Expedition
     */
    public function setDateReglement($dateReglement)
    {
        $this->dateReglement = $dateReglement;

        return $this;
    }

    /**
     * Get dateReglement
     *
     * @return \DateTime 
     */
    public function getDateReglement()
    {
        return $this->dateReglement;
    }

    /**
     * Set envClient
     *
     * @param \Com\DaufinBundle\Entity\Client $envClient
     * @return Expedition
     */
    public function setEnvClient(\Com\DaufinBundle\Entity\Client $envClient = null)
    {
        $this->envClient = $envClient;

        return $this;
    }

    /**
     * Get envClient
     *
     * @return \Com\DaufinBundle\Entity\Client 
     */
    public function getEnvClient()
    {
        return $this->envClient;
    }

/**
     * Set envDate
     *
     * @param \DateTime $lvDate
     * @return Expedition
     */
    public function setLvDate($lvDate)
    {
        $this->lvDate = $lvDate;

        return $this;
    }

    /**
     * Get lvDate
     *
     * @return \DateTime 
     */
    public function getLvDate()
    {
        return $this->lvDate;
    }

    /**
     * Set lvRemarque
     *
     * @param string $lvRemarque
     * @return Expedition
     */
    public function setLvRemarque($lvRemarque)
    {
        $this->lvRemarque = $lvRemarque;

        return $this;
    }

    /**
     * Get lvRemarque
     *
     * @return string 
     */
    public function getLvRemarque()
    {
        return $this->lvRemarque;
    }
    
    
    /**
     * Set envVille
     *
     * @param \Com\DaufinBundle\Entity\Ville $envVille
     * @return Expedition
     */
    public function setEnvVille(\Com\DaufinBundle\Entity\Ville $envVille = null)
    {
        $this->envVille = $envVille;

        return $this;
    }

    /**
     * Get envVille
     *
     * @return \Com\DaufinBundle\Entity\Ville 
     */
    public function getEnvVille()
    {
        return $this->envVille;
    }

    /**
     * Set recClient
     *
     * @param \Com\DaufinBundle\Entity\Client $recClient
     * @return Expedition
     */
    public function setRecClient(\Com\DaufinBundle\Entity\Client $recClient = null)
    {
        $this->recClient = $recClient;

        return $this;
    }

    /**
     * Get recClient
     *
     * @return \Com\DaufinBundle\Entity\Client 
     */
    public function getRecClient()
    {
        return $this->recClient;
    }

    /**
     * Set recVille
     *
     * @param \Com\DaufinBundle\Entity\Ville $recVille
     * @return Expedition
     */
    public function setRecVille(\Com\DaufinBundle\Entity\Ville $recVille = null)
    {
        $this->recVille = $recVille;

        return $this;
    }

    /**
     * Get recVille
     *
     * @return \Com\DaufinBundle\Entity\Ville 
     */
    public function getRecVille()
    {
        return $this->recVille;
    }

    /**
     * Set expTransp
     *
     * @param \Com\DaufinBundle\Entity\ExpTransp $expTransp
     * @return Expedition
     */
    public function setExpTransp(\Com\DaufinBundle\Entity\ExpTransp $expTransp = null)
    {
        $this->expTransp = $expTransp;

        return $this;
    }

    /**
     * Get expTransp
     *
     * @return \Com\DaufinBundle\Entity\ExpTransp 
     */
    public function getExpTransp()
    {
        return $this->expTransp;
    }

    /**
     * Set facture
     *
     * @param \Com\DaufinBundle\Entity\Facture $facture
     * @return Expedition
     */
    public function setFacture(\Com\DaufinBundle\Entity\Facture $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \Com\DaufinBundle\Entity\Facture 
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set clientReglee
     *
     * @param \Com\DaufinBundle\Entity\Client $clientReglee
     * @return Expedition
     */
    public function setClientReglee(\Com\DaufinBundle\Entity\Client $clientReglee = null)
    {
        $this->clientReglee = $clientReglee;

        return $this;
    }

    /**
     * Get clientReglee
     *
     * @return \Com\DaufinBundle\Entity\Client 
     */
    public function getClientReglee()
    {
        return $this->clientReglee;
    }

    /**
     * Set clientReglee
     *
     * @param \Com\DaufinBundle\Entity\OrdreLvRm $ordreLv
     * @return Expedition
     */
    public function setOrdreLv(\Com\DaufinBundle\Entity\OrdreLvRm $ordreLv = null)
    {
        $this->ordreLv =$ordreLv;

        return $this;
    }

    /**
     * Get ordreLv
     *
     * @return \Com\DaufinBundle\Entity\OrdreLvRm 
     */
    public function getOrdreLv()
    {
        return $this->ordreLv;
    }    
    
    public function __toString(){return $this->codeDeclaration;}
    
    
	public function getTypeLivraison() {
		return $this->typeLivraison;
	}
	
	public function setTypeLivraison($typeLivraison) {
		$this->typeLivraison = $typeLivraison;
		return $this;
	}
	
	public function getEnvSite() {
		return $this->envSite;
	}
	public function setEnvSite(\Com\DaufinBundle\Entity\Site $envSite) {
		$this->envSite = $envSite;
		return $this;
	}
	public function getRecSite() {
		return $this->recSite;
	}
	public function setRecSite(\Com\DaufinBundle\Entity\Site $recSite) {
		$this->recSite = $recSite;
		return $this;
	}
	public function getCodeDeclaration() {
		return $this->codeDeclaration;
	}
	public function setCodeDeclaration($codeDeclaration) {
		$this->codeDeclaration = $codeDeclaration;
		return $this;
	}
	public function getEnvSecteur() {
		return $this->envSecteur;
	}
	public function setEnvSecteur(\Com\DaufinBundle\Entity\Secteur $envSecteur = NULL) {
		$this->envSecteur = $envSecteur;
		return $this;
	}
	public function getRecSecteur() {
		return $this->recSecteur;
	}
	public function setRecSecteur(\Com\DaufinBundle\Entity\Secteur $recSecteur = NULL) {
		$this->recSecteur = $recSecteur;
		return $this;
	}
	/**
	 * Get EnvAgence
	 *
	 * @return \Com\DaufinBundle\Entity\Agence
	 */
	public function getEnvAgence() {
		return $this->envAgence;
	}
	/**
	 * Set envAgence
	 *
	 * @param \Com\DaufinBundle\Entity\Agence $envAgence
	 * @return Expedition
	 */
	public function setEnvAgence(\Com\DaufinBundle\Entity\Agence $envAgence = NULL) {
		$this->envAgence = $envAgence;
		return $this;
	}
	/**
	 * Get RecAgence
	 *
	 * @return \Com\DaufinBundle\Entity\Agence
	 */
	public function getRecAgence() {
		return $this->recAgence;
	}
	
	/**
	 * Set recAgence
	 *
	 * @param \Com\DaufinBundle\Entity\Agence $recAgence
	 * @return Expedition
	 */
	
	public function setRecAgence(\Com\DaufinBundle\Entity\Agence $recAgence = NULL) {
		$this->recAgence = $recAgence;
		return $this;
	}
	public function getRefPaiement() {
		return $this->RefPaiement;
	}
	public function setRefPaiement($RefPaiement) {
		$this->RefPaiement = $RefPaiement;
		return $this;
	}
	public function getAgenceTransit() {
		return $this->agenceTransit;
	}
	public function setAgenceTransit(\Com\DaufinBundle\Entity\Agence $agenceTransit) {
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
	public function setExpTransTransit(\Com\DaufinBundle\Entity\ExpTransp $ExpTransTransit) {
		$this->ExpTransTransit = $ExpTransTransit;
		return $this;
	}
	public function getTransitVille() {
		return $this->transitVille;
	}
	public function setTransitVille(\Com\DaufinBundle\Entity\Ville $transitVille) {
		$this->transitVille = $transitVille;
		return $this;
	}
	
	
	
	
	
	
	
	
	
}
