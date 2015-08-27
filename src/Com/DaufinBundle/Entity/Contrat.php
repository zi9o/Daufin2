<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrat
 *
 * @ORM\Table(name="contrat", indexes={@ORM\Index(name="FK_OUVRIR_COMPTE", columns={"Client"})})
 * @ORM\Entity
 */
class Contrat
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
     * @ORM\Column(name="DATE_OUVERT", type="datetime", nullable=true)
     */
    private $dateOuvert;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_FERMETURE", type="datetime", nullable=true)
     */
    private $dateFermeture;

    /**
     * @var string
     *
     * @ORM\Column(name="M_PAIMENT", type="string", length=54, nullable=true)
     */
    private $mPaiment;

    /**
     * @var string
     *
     * @ORM\Column(name="ETAT_CONTART", type="string", length=25, nullable=true)
     */
    private $etatContart;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Client", referencedColumnName="ID")
     * })
     */
    private $client;



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
     * Set dateOuvert
     *
     * @param \DateTime $dateOuvert
     * @return Contrat
     */
    public function setDateOuvert($dateOuvert)
    {
        $this->dateOuvert = $dateOuvert;

        return $this;
    }

    /**
     * Get dateOuvert
     *
     * @return \DateTime 
     */
    public function getDateOuvert()
    {
        return $this->dateOuvert;
    }

    /**
     * Set mPaiment
     *
     * @param string $mPaiment
     * @return Contrat
     */
    public function setMPaiment($mPaiment)
    {
        $this->mPaiment = $mPaiment;

        return $this;
    }

    /**
     * Get mPaiment
     *
     * @return string 
     */
    public function getMPaiment()
    {
        return $this->mPaiment;
    }

    /**
     * Set etatContart
     *
     * @param string $etatContart
     * @return Contrat
     */
    public function setEtatContart($etatContart)
    {
        $this->etatContart = $etatContart;

        return $this;
    }

    /**
     * Get etatContart
     *
     * @return string 
     */
    public function getEtatContart()
    {
        return $this->etatContart;
    }

    /**
     * Set client
     *
     * @param \Com\DaufinBundle\Entity\Client $client
     * @return Contrat
     */
    public function setClient(\Com\DaufinBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Com\DaufinBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }
    public function __toString(){return $this->id;}
	public function getDateFermeture() {
		return $this->dateFermeture;
	}
	public function setDateFermeture(\DateTime $dateFermeture) {
		$this->dateFermeture = $dateFermeture;
		return $this;
	}
	
}
