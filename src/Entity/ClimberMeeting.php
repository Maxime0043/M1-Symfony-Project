<?php

namespace App\Entity;

use App\Repository\ClimberMeetingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClimberMeetingRepository::class)]
class ClimberMeeting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $has_participated;

    #[ORM\ManyToOne(targetEntity: Climber::class, inversedBy: 'climberMeetings')]
    #[ORM\JoinColumn(nullable: false)]
    private $climber;

    #[ORM\ManyToOne(targetEntity: Meeting::class, inversedBy: 'climberMeetings')]
    #[ORM\JoinColumn(nullable: false)]
    private $meeting;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHasParticipated(): ?bool
    {
        return $this->has_participated;
    }

    public function setHasParticipated(bool $has_participated): self
    {
        $this->has_participated = $has_participated;

        return $this;
    }

    public function getClimber(): ?Climber
    {
        return $this->climber;
    }

    public function setClimber(?Climber $climber): self
    {
        $this->climber = $climber;

        return $this;
    }

    public function getMeeting(): ?Meeting
    {
        return $this->meeting;
    }

    public function setMeeting(?Meeting $meeting): self
    {
        $this->meeting = $meeting;

        return $this;
    }
}
