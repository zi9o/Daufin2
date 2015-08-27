<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Com;

/**
 * Site
 *
 * @ORM\Table(name="site", indexes={@ORM\Index(name="FK_Site_Client", columns={"CLIENT"})})
 * @ORM\Entity
 */
class Site
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
     * @ORM\Column(name="LIBELLE_SITE", type="string", length=56, nullable=true)
     */
    private $libelleSite;

    /**
     * @var string
     *
     * @ORM\Column(name="ADRES_SITE", type="string", length=56, nullable=true)
     */
    private $adresSite;


    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CLIENT", referencedColumnName="ID")
     * })
     */
    private $client;
    
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelleSite
     *
     * @param string $libelleSite
     * @return Site
     */
    public function setLibelleSite($libelleSite)
    {
        $this->libelleSite = $libelleSite;

        return $this;
    }

    /**
     * Get libelleSite
     *
     * @return string 
     */
    public function getLibelleSite()
    {
        return $this->libelleSite;
    }

    /**
     * Set adresSite
     *
     * @param string $adresSite
     * @return Site
     */
    public function setAdresSite($adresSite)
    {
        $this->adresSite = $adresSite;

        return $this;
    }

    /**
     * Get adresSite
     *
     * @return string 
     */
    public function getAdresSite()
    {
        return $this->adresSite;
    }
    public function __toString(){return $this->libelleSite;}
    
	public function getClient() {
		return $this->client;
	}
	public function setClient($client) {
		$this->client = $client;
		return $this;
	}
	/**
	 * Get secteur
	 *
	 * @return Secteur
	 */
	public function getSecteur() {
		return $this->secteur;
	}
	public function setSecteur(Com\DaufinBundle\Entity\Secteur $secteur) {
		$this->secteur = $secteur;
		return $this;
	}
	
	
}
