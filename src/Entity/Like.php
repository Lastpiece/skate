<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikeRepository::class)
 * @ORM\Table(name="`like`")
 */
class Like
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $islike;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=Post::class, inversedBy="likes")
     */
    private $postId;

    public function __construct()
    {
        $this->postId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIslike(): ?int
    {
        return $this->islike;
    }

    public function setIslike(int $islike): self
    {
        $this->islike = $islike;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPostId(): Collection
    {
        return $this->postId;
    }

    public function addPostId(Post $postId): self
    {
        if (!$this->postId->contains($postId)) {
            $this->postId[] = $postId;
        }

        return $this;
    }

    public function removePostId(Post $postId): self
    {
        $this->postId->removeElement($postId);

        return $this;
    }
}
