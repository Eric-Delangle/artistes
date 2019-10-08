<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"group1"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="categories")
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @Groups({"group1"})
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group1"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gallery", mappedBy="category")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $galleries;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->galleries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
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

    /**
     * @return Collection|Gallery[]
     */
    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    
    public function __toString() {
        return (string) $this->getName();
    }
}
