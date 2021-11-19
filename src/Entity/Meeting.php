<?php

namespace App\Entity;

use App\Repository\MeetingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[ORM\Entity(repositoryClass: MeetingRepository::class)]
class Meeting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    private $location;

    #[ORM\Column(type: 'integer')]
    private $limit_climber;

    #[ORM\Column(type: 'string', length: 255)]
    private $picture;

    #[ORM\ManyToOne(targetEntity: Level::class, inversedBy: 'meetings')]
    #[ORM\JoinColumn(nullable: false)]
    private $level;

    #[ORM\ManyToOne(targetEntity: Climber::class, inversedBy: 'meetings')]
    #[ORM\JoinColumn(nullable: false)]
    private $climber;

    #[ORM\OneToMany(mappedBy: 'meeting', targetEntity: ClimberMeeting::class, orphanRemoval: true)]
    private $climberMeetings;

    #[ORM\OneToMany(mappedBy: 'meeting', targetEntity: MeetingPicture::class, orphanRemoval: true)]
    private $meetingPictures;

    #[ORM\OneToMany(mappedBy: 'meeting', targetEntity: Comment::class, orphanRemoval: true)]
    private $comments;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    public function __construct()
    {
        $this->climberMeetings = new ArrayCollection();
        $this->meetingPictures = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getLimitClimber(): ?int
    {
        return $this->limit_climber;
    }

    public function setLimitClimber(int $limit_climber): self
    {
        $this->limit_climber = $limit_climber;

        return $this;
    }

    public function getPicture(): null|string|UploadedFile
    {
        return $this->picture;
    }

    public function setPicture(null|string|UploadedFile $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

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
            $climberMeeting->setMeeting($this);
        }

        return $this;
    }

    public function removeClimberMeeting(ClimberMeeting $climberMeeting): self
    {
        if ($this->climberMeetings->removeElement($climberMeeting)) {
            // set the owning side to null (unless already changed)
            if ($climberMeeting->getMeeting() === $this) {
                $climberMeeting->setMeeting(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MeetingPicture[]
     */
    public function getMeetingPictures(): Collection
    {
        return $this->meetingPictures;
    }

    public function addMeetingPicture(MeetingPicture $meetingPicture): self
    {
        if (!$this->meetingPictures->contains($meetingPicture)) {
            $this->meetingPictures[] = $meetingPicture;
            $meetingPicture->setMeeting($this);
        }

        return $this;
    }

    public function removeMeetingPicture(MeetingPicture $meetingPicture): self
    {
        if ($this->meetingPictures->removeElement($meetingPicture)) {
            // set the owning side to null (unless already changed)
            if ($meetingPicture->getMeeting() === $this) {
                $meetingPicture->setMeeting(null);
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
            $comment->setMeeting($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMeeting() === $this) {
                $comment->setMeeting(null);
            }
        }

        return $this;
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
}
