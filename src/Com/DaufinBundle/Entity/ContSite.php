<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContSite
 *
 * @ORM\Table(name="cont_site", indexes={@ORM\Index(name="FK_CONT_SITE", columns={"CONTART"}), @ORM\Index(name="FK_CONT_SITE2", columns={"SITE"})})
 * @ORM\Entity
 */
class ContSite
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
     * @ORM\Column(name="TYPE_SITE", type="string", length=25, nullable=true)
     */
    private $typeSite;

    /**
     * @var \Contrat
     *
     * @ORM\ManyToOne(targetEntity="Contrat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CONTART", referencedColumnName="ID")
     * })
     */
    private $contart;

    /**
     * @var \Site
     *
     * @ORM\ManyToOne(targetEntity="Site")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SITE", referencedColumnName="ID")
     * })
     */
    private $site;



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
     * Set typeSite
     *
     * @param string $typeSite
     * @return ContSite
     */
    public function setTypeSite($typeSite)
    {
        $this->typeSite = $typeSite;

        return $this;
    }

    /**
     * Get typeSite
     *
     * @return string 
     */
    public function getTypeSite()
    {
        return $this->typeSite;
    }

    /**
     * Set contart
     *
     * @param \Com\DaufinBundle\Entity\Contrat $contart
     * @return ContSite
     */
    public function setContart(\Com\DaufinBundle\Entity\Contrat $contart = null)
    {
        $this->contart = $contart;

        return $this;
    }

    /**
     * Get contart
     *
     * @return \Com\DaufinBundle\Entity\Contrat 
     */
    public function getContart()
    {
        return $this->contart;
    }

    /**
     * Set site
     *
     * @param \Com\DaufinBundle\Entity\Site $site
     * @return ContSite
     */
    public function setSite(\Com\DaufinBundle\Entity\Site $site = null)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return \Com\DaufinBundle\Entity\Site 
     */
    public function getSite()
    {
        return $this->site;
    }
    public function __toString(){return $this->id;}
}
