<?php

namespace Com\DaufinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OpererExpedition
 *
 * @ORM\Table(name="operer_expedition", indexes={@ORM\Index(name="FK_OPERER_EXPEDITION", columns={"EXEPT"}), @ORM\Index(name="FK_OPERER_EXPEDITION2", columns={"PERSONNEL"})})
 * @ORM\Entity
 */
class OpererExpedition
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
     * @var \Expedition
     *
     * @ORM\ManyToOne(targetEntity="Expedition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="EXEPT", referencedColumnName="ID")
     * })
     */
    private $exept;

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
     * @return OpererExpedition
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
     * @return OpererExpedition
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
     * Set exept
     *
     * @param \Com\DaufinBundle\Entity\Expedition $exept
     * @return OpererExpedition
     */
    public function setExept(\Com\DaufinBundle\Entity\Expedition $exept = null)
    {
        $this->exept = $exept;

        return $this;
    }

    /**
     * Get exept
     *
     * @return \Com\DaufinBundle\Entity\Expedition 
     */
    public function getExept()
    {
        return $this->exept;
    }

    /**
     * Set personnel
     *
     * @param \Com\DaufinBundle\Entity\Personnel $personnel
     * @return OpererExpedition
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
    public function __toString(){return $this->id;}
}
