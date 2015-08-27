<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personnel
 *
 * @ORM\Table(name="personnel")
 * @ORM\Entity
 */
class Personnel
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
     * @var integer
     *
     * @ORM\Column(name="MATRICULE_PERS", type="bigint", nullable=true)
     */
    private $matriculePers;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_PERS", type="string", length=56, nullable=true)
     */
    private $nomPers;

    /**
     * @var string
     *
     * @ORM\Column(name="PRENOM_PERS", type="string", length=56, nullable=true)
     */
    private $prenomPers;

    /**
     * @var string
     *
     * @ORM\Column(name="FONCTION", type="string", length=56, nullable=true)
     */
    private $fonction;

    /**
     * @var string
     *
     * @ORM\Column(name="TEL_PERS", type="string", length=56, nullable=true)
     */
    private $telPers;

    /**
     * @var string
     *
     * @ORM\Column(name="GSM_PERS", type="string", length=56, nullable=true)
     */
    private $gsmPers;

    /**
     * @var string
     *
     * @ORM\Column(name="CIN_PERS", type="string", length=56, nullable=true)
     */
    private $cinPers;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_DEBUT", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var string
     *
     * @ORM\Column(name="ETAT_ACTIVITEE", type="string", length=56, nullable=true)
     */
    private $etatActivitee;



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
     * Set matriculePers
     *
     * @param integer $matriculePers
     * @return Personnel
     */
    public function setMatriculePers($matriculePers)
    {
        $this->matriculePers = $matriculePers;

        return $this;
    }

    /**
     * Get matriculePers
     *
     * @return integer 
     */
    public function getMatriculePers()
    {
        return $this->matriculePers;
    }

    /**
     * Set nomPers
     *
     * @param string $nomPers
     * @return Personnel
     */
    public function setNomPers($nomPers)
    {
        $this->nomPers = $nomPers;

        return $this;
    }

    /**
     * Get nomPers
     *
     * @return string 
     */
    public function getNomPers()
    {
        return $this->nomPers;
    }

    /**
     * Set prenomPers
     *
     * @param string $prenomPers
     * @return Personnel
     */
    public function setPrenomPers($prenomPers)
    {
        $this->prenomPers = $prenomPers;

        return $this;
    }

    /**
     * Get prenomPers
     *
     * @return string 
     */
    public function getPrenomPers()
    {
        return $this->prenomPers;
    }

    /**
     * Set fonction
     *
     * @param string $fonction
     * @return Personnel
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string 
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set telPers
     *
     * @param string $telPers
     * @return Personnel
     */
    public function setTelPers($telPers)
    {
        $this->telPers = $telPers;

        return $this;
    }

    /**
     * Get telPers
     *
     * @return string 
     */
    public function getTelPers()
    {
        return $this->telPers;
    }

    /**
     * Set gsmPers
     *
     * @param string $gsmPers
     * @return Personnel
     */
    public function setGsmPers($gsmPers)
    {
        $this->gsmPers = $gsmPers;

        return $this;
    }

    /**
     * Get gsmPers
     *
     * @return string 
     */
    public function getGsmPers()
    {
        return $this->gsmPers;
    }

    /**
     * Set cinPers
     *
     * @param string $cinPers
     * @return Personnel
     */
    public function setCinPers($cinPers)
    {
        $this->cinPers = $cinPers;

        return $this;
    }

    /**
     * Get cinPers
     *
     * @return string 
     */
    public function getCinPers()
    {
        return $this->cinPers;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Personnel
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set etatActivitee
     *
     * @param string $etatActivitee
     * @return Personnel
     */
    public function setEtatActivitee($etatActivitee)
    {
        $this->etatActivitee = $etatActivitee;

        return $this;
    }

    /**
     * Get etatActivitee
     *
     * @return string 
     */
    public function getEtatActivitee()
    {
        return $this->etatActivitee;
    }
    public function __toString(){return $this->nomPers.' '.$this->prenomPers;}
}
