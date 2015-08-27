<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
/**
 * Agence
 *
 * @ORM\Table(name="agence", indexes={@ORM\Index(name="FK_RESIDER", columns={"VILLE"})})
 * @ORM\Entity
 * @ExclusionPolicy("none")
 */
class Agence  
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * 
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="CODE_AGENCE", type="string", length=10, nullable=true)
     */
    private $codeAgence;

    /**
     * @var string
     *
     * @ORM\Column(name="LIBELLE_AG", type="string", length=30, nullable=true)
     * 
     */
    private $libelleAg;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE_AGENCE", type="string", length=30, nullable=true)
     * 
     */
    private $typeAgence;

    /**
     * @var string
     *
     * @ORM\Column(name="TEL_AG", type="string", length=30, nullable=true)
     * 
     */
    private $telAg;

    /**
     * @var string
     *
     * @ORM\Column(name="FAX_AG", type="string", length=30, nullable=true)
     * 
     */
    private $faxAg;

    /**
     * @var string
     *
     * @ORM\Column(name="ADRESSE_AG", type="string", length=50, nullable=true)
     * 
     */
    private $adresseAg;

    /**
     * @var \Ville
     * 
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="VILLE", referencedColumnName="ID")
     * })
     * @Exclude
     */
    private $ville;

  
    /**
     * Get id
     *
     * @return integer 
     *  
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codeAgence
     *
     * @param string $codeAgence
     * @return Agence
     * 
     */
    public function setCodeAgence($codeAgence)
    {
        $this->codeAgence = $codeAgence;

        return $this;
    }

    /**
     * Get codeAgence
     *  
     * @return string 
     */
    public function getCodeAgence()
    {
        return $this->codeAgence;
    }

    /**
     * Set libelleAg
     *
     * @param string $libelleAg
     * @return Agence
     *
     */
    public function setLibelleAg($libelleAg)
    {
        $this->libelleAg = $libelleAg;

        return $this;
    }

    /**
     * Get libelleAg
     * 
     * @return string 
     */
    public function getLibelleAg()
    {
        return $this->libelleAg;
    }

    /**
     * Set typeAgence
     *
     * @param string $typeAgence
     * @return Agence
     */
    public function setTypeAgence($typeAgence)
    {
        $this->typeAgence = $typeAgence;

        return $this;
    }

    /**
     * Get typeAgence
     *  
     * @return string 
     */
    public function getTypeAgence()
    {
        return $this->typeAgence;
    }

    /**
     * Set telAg
     *
     * @param string $telAg
     * @return Agence
     */
    public function setTelAg($telAg)
    {
        $this->telAg = $telAg;

        return $this;
    }

    /**
     * Get telAg
     *  
     * @return string 
     */
    public function getTelAg()
    {
        return $this->telAg;
    }

    /**
     * Set faxAg
     *
     * @param string $faxAg
     * @return Agence
     */
    public function setFaxAg($faxAg)
    {
        $this->faxAg = $faxAg;

        return $this;
    }

    /**
     * Get faxAg
     *  
     * @return string 
     */
    public function getFaxAg()
    {
        return $this->faxAg;
    }

    /**
     * Set adresseAg
     *
     * @param string $adresseAg
     * @return Agence
     */
    public function setAdresseAg($adresseAg)
    {
        $this->adresseAg = $adresseAg;

        return $this;
    }

    /**
     * Get adresseAg
     *   
     * @return string 
     */
    public function getAdresseAg()
    {
        return $this->adresseAg;
    }

    /**
     * Set ville
     *
     * @param \Com\DaufinBundle\Entity\Ville $ville
     * @return Agence
     */
    public function setVille(\Com\DaufinBundle\Entity\Ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \Com\DaufinBundle\Entity\Ville 
     */
    public function getVille()
    {
        return $this->ville;
    }
    public function __toString(){return $this->libelleAg;}
 
	
    
    
}
