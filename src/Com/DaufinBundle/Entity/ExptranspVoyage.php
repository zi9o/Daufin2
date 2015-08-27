<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExptranspVoyage
 *
 * @ORM\Table(name="exptransp_voyage", indexes={@ORM\Index(name="FK_EXPTRANSP_VOYAGE", columns={"VOYAGE"})}, indexes={@ORM\Index(name="FK_EXPTRANSP_VOYAGE2", columns={"EXP_TRANSP"})})
 * @ORM\Entity
 */

class ExptranspVoyage
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
     * @ORM\Column(name="DATE_AFF", type="datetime", nullable=true)
     */
    private $dateAff;

    /**
     * @var \Voyage
     *
     * @ORM\ManyToOne(targetEntity="Voyage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="VOYAGE", referencedColumnName="ID")
     * })
     */
    private $voyage;
    
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateAff
     *
     * @param \DateTime $dateAff
     * @return ExptranspVoyage
     */
    public function setdateAff($dateAff)
    {
        $this->dateAff = $dateAff;

        return $this;
    }

    /**
     * Get dateAff
     *
     * @return \DateTime 
     */
    public function getdateAff()
    {
        return $this->dateAff;
    }

 /**
     * Get voyage
     *
     * @return \Com\DaufinBundle\Entity\Voyage 
     */
    public function getvoyage()
    {
        return $this->voyage;
    }

    /**
     * Set voyage
     *
     * @param \Com\DaufinBundle\Entity\Voyage $voyage
     * @return ExptranspVoyage
     */
    public function setvoyage(\Com\DaufinBundle\Entity\Voyage $voyage = null)
    {
        $this->voyage = $voyage;

        return $this;
    }
 /**
     * Get expTransp
     *
     * @return \Com\DaufinBundle\Entity\ExpTransp 
     */
    public function getexpTransp()
    {
        return $this->expTransp;
    }

    /**
     * Set expTransp
     *
     * @param \Com\DaufinBundle\Entity\ExpTransp $expTransp
     * @return ExptranspVoyage
     */
    public function setexpTransp(\Com\DaufinBundle\Entity\ExpTransp $expTransp = null)
    {
        $this->expTransp = $expTransp;

        return $this;
    }
    
    public function __toString(){return $this->id;}
}
