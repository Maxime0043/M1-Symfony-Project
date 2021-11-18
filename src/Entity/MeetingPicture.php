<?php

namespace App\Entity;

use App\Repository\MeetingPictureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeetingPictureRepository::class)]
class MeetingPicture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $picture;

    #[ORM\ManyToOne(targetEntity: Meeting::class, inversedBy: 'meetingPictures')]
    #[ORM\JoinColumn(nullable: false)]
    private $meeting;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

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
