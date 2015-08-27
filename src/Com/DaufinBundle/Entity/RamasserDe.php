<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RamasserDe
 *
 * @ORM\Table(name="ramasser_de", indexes={@ORM\Index(name="FK_RAMASSER_DE_", columns={"ORDRE"}), @ORM\Index(name="FK_RAMASSER_DE_2", columns={"Client"})})
 * @ORM\Entity
 */
class RamasserDe
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
     * @ORM\Column(name="DATE_RAMASSAGE", type="datetime", nullable=true)
     */
    private $dateRamassage;

    /**
     * @var \OrdreLvRm
     *
     * @ORM\ManyToOne(targetEntity="OrdreLvRm")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ORDRE", referencedColumnName="ID")
     * })
     */
    private $ordre;

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
     * Set dateRamassage
     *
     * @param \DateTime $dateRamassage
     * @return RamasserDe
     */
    public function setDateRamassage($dateRamassage)
    {
        $this->dateRamassage = $dateRamassage;

        return $this;
    }

    /**
     * Get dateRamassage
     *
     * @return \DateTime 
     */
    public function getDateRamassage()
    {
        return $this->dateRamassage;
    }

    /**
     * Set ordre
     *
     * @param \Com\DaufinBundle\Entity\OrdreLvRm $ordre
     * @return RamasserDe
     */
    public function setOrdre(\Com\DaufinBundle\Entity\OrdreLvRm $ordre = null)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return \Com\DaufinBundle\Entity\OrdreLvRm 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set client
     *
     * @param \Com\DaufinBundle\Entity\Client $client
     * @return RamasserDe
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
}
