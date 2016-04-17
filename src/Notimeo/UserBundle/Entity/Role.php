<?php

namespace Notimeo\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="Notimeo\UserBundle\Repository\RoleRepository")
 */
class Role implements RoleInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="role_name", type="string",length=50,unique=true)
     * @var string
     */
    private $roleName;

    /**
     * @var User[]
     * @ORM\ManyToMany(targetEntity="User", mappedBy="userRoles")
     * @ORM\JoinTable(name="users_roles",
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     *      },
     *      joinColumns={
     *          @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *      }
     * )
     */
    private $users;

    /**
     * Role constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->roleName;
    }


    /**
     * Get role id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set role name.
     *
     * @param string $roleName
     * @return $this
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * Get role name.
     *
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->roleName;
    }

    /**
     * Add user.
     *
     * @param User $user
     * @return $this
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param User $user
     * @return $this
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * Get users using this role.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
