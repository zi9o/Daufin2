<?php

namespace Com\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinColumns;
use \Com\DaufinBundle\Entity\Personnel;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Com\UserBundle\Entity\Repository\UserRepository")
 */
class User extends BaseUser
{
    
     /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var
     *
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     * @ORM\JoinTable(name="users_groups")
     */
    protected $groups;

    /**
     * @var
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    protected $address;

    /**
     * @var
     *
     * @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
     */
    protected $zipCode;

    /**
     * @var
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    protected $city;
    /**
     * @var \Com\DaufinBundle\Entity\Personnel
     *
     * @ORM\OneToOne(targetEntity="\Com\DaufinBundle\Entity\Personnel")
     * @JoinColumn(name="personnel", referencedColumnName="ID")
     */
    protected $personnel;
    

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * Get personnel
     *
     * @return \Com\DaufinBundle\Entity\Personnel
     */
	public function getPersonnel() {
		return $this->personnel;
	}
	/**
	 * Set personnel
	 *
	 * @param \Com\DaufinBundle\Entity\Personnel $personnel
	 * @return User
	 */
	public function setPersonnel(\Com\DaufinBundle\Entity\Personnel $personnel = null) {
		$this->personnel = $personnel;
		return $this;
	}
	

    
    
}
