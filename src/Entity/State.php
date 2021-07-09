<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StateRepository::class)
 */
class State
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Room::class, inversedBy="states")
     * @ORM\JoinColumn(nullable=false)
     */
    private $room_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $state;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomId(): ?Room
    {
        return $this->room_id;
    }

    public function setRoomId(?Room $room_id): self
    {
        $this->room_id = $room_id;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }
}
