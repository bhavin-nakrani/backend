<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAdd;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEdit;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDelete;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isView;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="userRole")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Setting::class, mappedBy="userRole")
     */
    private $settings;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->settings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsAdd(): ?bool
    {
        return $this->isAdd;
    }

    public function setIsAdd(bool $isAdd): self
    {
        $this->isAdd = $isAdd;

        return $this;
    }

    public function getIsEdit(): ?bool
    {
        return $this->isEdit;
    }

    public function setIsEdit(bool $isEdit): self
    {
        $this->isEdit = $isEdit;

        return $this;
    }

    public function getIsDelete(): ?bool
    {
        return $this->isDelete;
    }

    public function setIsDelete(bool $isDelete): self
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    public function getIsView(): ?bool
    {
        return $this->isView;
    }

    public function setIsView(bool $isView): self
    {
        $this->isView = $isView;

        return $this;
    }

    /**
     * @return Collection|SubCategory[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setUserRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUserRole() === $this) {
                $user->setUserRole(null);
            }
        }

        return $this;
    }

    public function getSettings(): Collection
    {
        return $this->settings;
    }
}
