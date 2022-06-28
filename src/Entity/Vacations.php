<?php

namespace App\Entity;

use App\Repository\VacationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VacationsRepository::class)
 */
class Vacations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_start;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $day_count;

    /**
     * @ORM\ManyToOne(targetEntity=VacationStatus::class)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vacations")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(?\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDayCount(): ?int
    {
        return $this->day_count;
    }

    public function setDayCount(?int $day_count): self
    {
        $this->day_count = $day_count;

        return $this;
    }

    public function getStatus(): ?VacationStatus
    {
        return $this->status;
    }

    public function setStatus(?VacationStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
