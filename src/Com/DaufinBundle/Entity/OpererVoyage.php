<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OpererVoyage
 *
 * @ORM\Table(name="operer_voyage", indexes={@ORM\Index(name="FK_OPERER_VOYAGE", columns={"PERSONNEL"}), @ORM\Index(name="FK_OPERER_VOYAGE2", columns={"VOYAGE"})})
 * @ORM\Entity
 */
class OpererVoyage
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
     * @var string
     *
     * @ORM\Column(name="TYPE_OPERATION", type="string", length=30, nullable=true)
     */
    private $typeOperation;

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
     * @var \Voyage
     *
     * @ORM\ManyToOne(targetEntity="Voyage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="VOYAGE", referencedColumnName="ID")
     * })
     */
    private $voyage;



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
     * @return OpererVoyage
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
     * Set typeOperation
     *
     * @param string $typeOperation
     * @return OpererVoyage
     */
    public function setTypeOperation($typeOperation)
    {
        $this->typeOperation = $typeOperation;

        return $this;
    }

    /**
     * Get typeOperation
     *
     * @return string 
     */
    public function getTypeOperation()
    {
        return $this->typeOperation;
    }

    /**
     * Set personnel
     *
     * @param \Com\DaufinBundle\Entity\Personnel $personnel
     * @return OpererVoyage
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
     * Set voyage
     *
     * @param \Com\DaufinBundle\Entity\Voyage $voyage
     * @return OpererVoyage
     */
    public function setVoyage(\Com\DaufinBundle\Entity\Voyage $voyage = null)
    {
        $this->voyage = $voyage;

        return $this;
    }

    /**
     * Get voyage
     *
     * @return \Com\DaufinBundle\Entity\Voyage 
     */
    public function getVoyage()
    {
        return $this->voyage;
    }
    public function __toString(){return $this->id;}
}
