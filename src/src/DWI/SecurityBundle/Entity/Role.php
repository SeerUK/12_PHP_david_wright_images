<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\SecurityBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * DWI\SecurityBundle\Entity\Role
 *
 * @ORM\Table(name="Role")
 * @ORM\Entity(repositoryClass="DWI\SecurityBundle\Entity\UserRepository")
 */
class Role implements RoleInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(name="role", type="string", length=20, unique=true)
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     * @JoinTable(name="UserRole",
     *     joinColumns={@JoinColumn(name="roleId", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="userId", referencedColumnName="id")}
     * )
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @inheritDoc
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsers()
    {
        return $this->users;
    }
}
