<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OpererOrdre
 *
 * @ORM\Table(name="operer_ordre", indexes={@ORM\Index(name="FK_OPERER_ORDRE", columns={"PERSONNEL"}), @ORM\Index(name="FK_OPERER_ORDRE2", columns={"ORDRE_LV_RM"})})
 * @ORM\Entity
 */
class OpererOrdre
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
     * @ORM\Column(name="DATE_OPERATION", type="datetime", nullable=true)
     */
    private $dateOperation;

    /**
     * @var \Personnel
     *
     * @ORM\ManyToOne(targetEntity="Personnel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PERSONNEL", referencedColumnName="ID")
     * })
     */
    private $personnel;

    /**
     * @var \OrdreLvRm
     *
     * @ORM\ManyToOne(targetEntity="OrdreLvRm")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ORDRE_LV_RM", referencedColumnName="ID")
     * })
     */
    private $ordreLvRm;



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
     * Set dateOperation
     *
     * @param \DateTime $dateOperation
     * @return OpererOrdre
     */
    public function setDateOperation($dateOperation)
    {
        $this->dateOperation = $dateOperation;

        return $this;
    }

    /**
     * Get dateOperation
     *
     * @return \DateTime 
     */
    public function getDateOperation()
    {
        return $this->dateOperation;
    }

    /**
     * Set personnel
     *
     * @param \Com\DaufinBundle\Entity\Personnel $personnel
     * @return OpererOrdre
     */
    public function setPersonnel(\Com\DaufinBundle\Entity\Personnel $personnel = null)
    {
        $this->personnel = $personnel;

        return $this;
    }

    /**
     * Get personnel
     *
     * @return \Com\DaufinBundle\Entity\Personnel 
     */
    public function getPersonnel()
    {
        return $this->personnel;
    }

    /**
     * Set ordreLvRm
     *
     * @param \Com\DaufinBundle\Entity\OrdreLvRm $ordreLvRm
     * @return OpererOrdre
     */
    public function setOrdreLvRm(\Com\DaufinBundle\Entity\OrdreLvRm $ordreLvRm = null)
    {
        $this->ordreLvRm = $ordreLvRm;

        return $this;
    }

    /**
     * Get ordreLvRm
     *
     * @return \Com\DaufinBundle\Entity\OrdreLvRm 
     */
    public function getOrdreLvRm()
    {
        return $this->ordreLvRm;
    }
    public function __toString(){return $this->id;}
}
