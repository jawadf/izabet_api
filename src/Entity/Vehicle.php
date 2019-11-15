<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleRepository")
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $vehicleId;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $vehicleCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vehicleName;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_os;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="vehicle")
     */
    private $tickets;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UsersAnd", inversedBy="vehicles")
     */
    private $user;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(?\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getVehicleId(): ?int
    {
        return $this->vehicleId;
    }

    public function setVehicleId(int $vehicleId): self
    {
        $this->vehicleId = $vehicleId;

        return $this;
    }

    public function getVehicleCode(): ?string
    {
        return $this->vehicleCode;
    }

    public function setVehicleCode(string $vehicleCode): self
    {
        $this->vehicleCode = $vehicleCode;

        return $this;
    }

    public function getVehicleName(): ?string
    {
        return $this->vehicleName;
    }

    public function setVehicleName(?string $vehicleName): self
    {
        $this->vehicleName = $vehicleName;

        return $this;
    } 

    public function getUserOs(): ?int
    {
        return $this->user_os;
    }

    public function setUserOs(?int $user_os): self
    {
        $this->user_os = $user_os;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setVehicle($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getVehicle() === $this) {
                $ticket->setVehicle(null);
            }
        }

        return $this;
    }

    public function getUser(): ?UsersAnd
    {
        return $this->user;
    }

    public function setUser(?UsersAnd $user): self
    {
        $this->user = $user;

        return $this;
    }

}
