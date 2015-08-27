<?php

namespace Com\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Sonata\UserBundle\Entity\BaseGroup;

/**
 * Group
 *
 * @ORM\Table(name="fos_group")
 * @ORM\Entity
 */
class Group extends BaseGroup
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
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     */
    protected $users;
}
