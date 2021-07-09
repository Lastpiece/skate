<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RoomRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=RoomRepository::class)
 */
class Room
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=Post::class, mappedBy="roomId", cascade={"persist", "remove"})
     */
    private $postID;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="room")
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity=State::class, mappedBy="room_id")
     */
    private $states;

    public function __construct()
    {
        $this->comment = new ArrayCollection();
        $this->state = 0;
        $this->states = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPostID(): ?Post
    {
        return $this->postID;
    }

    public function setPostID(Post $postID): self
    {
        // set the owning side of the relation if necessary
        if ($postID->getRoomId() !== $this) {
            $postID->setRoomId($this);
        }

        $this->postID = $postID;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Post $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setRoom($this);
        }

        return $this;
    }

    public function removeComment(Post $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRoom() === $this) {
                $comment->setRoom(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->name;
    }

    /**
     * @return Collection|State[]
     */
    public function getStates(): Collection
    {
        return $this->states;
    }

    public function addState(State $state): self
    {
        if (!$this->states->contains($state)) {
            $this->states[] = $state;
            $state->setRoomId($this);
        }

        return $this;
    }

    public function removeState(State $state): self
    {
        if ($this->states->removeElement($state)) {
            // set the owning side to null (unless already changed)
            if ($state->getRoomId() === $this) {
                $state->setRoomId(null);
            }
        }

        return $this;
    }
}
