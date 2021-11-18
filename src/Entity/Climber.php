<?php

namespace App\Entity;

use App\Repository\ClimberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClimberRepository::class)]

class Climber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstname;

    #[ORM\Column(type: 'integer')]
    private $points;

    #[ORM\OneToMany(mappedBy: 'climber', targetEntity: Meeting::class, orphanRemoval: true)]
    private $meetings;

    #[ORM\OneToMany(mappedBy: 'climber', targetEntity: ClimberMeeting::class, orphanRemoval: true)]
    private $climberMeetings;

    #[ORM\OneToMany(mappedBy: 'climber', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    public function __construct()
    {
        $this->meetings = new ArrayCollection();
        $this->climberMeetings = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    /**
     * @return Collection|Meeting[]
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting): self
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings[] = $meeting;
            $meeting->setClimber($this);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): self
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getClimber() === $this) {
                $meeting->setClimber(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ClimberMeeting[]
     */
    public function getClimberMeetings(): Collection
    {
        return $this->climberMeetings;
    }

    public function addClimberMeeting(ClimberMeeting $climberMeeting): self
    {
        if (!$this->climberMeetings->contains($climberMeeting)) {
            $this->climberMeetings[] = $climberMeeting;
            $climberMeeting->setClimber($this);
        }

        return $this;
    }

    public function removeClimberMeeting(ClimberMeeting $climberMeeting): self
    {
        if ($this->climberMeetings->removeElement($climberMeeting)) {
            // set the owning side to null (unless already changed)
            if ($climberMeeting->getClimber() === $this) {
                $climberMeeting->setClimber(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setClimber($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getClimber() === $this) {
                $comment->setClimber(null);
            }
        }

        return $this;
    }
}
