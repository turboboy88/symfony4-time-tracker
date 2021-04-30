<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use mysql_xdevapi\Exception;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    const MAX_TIME_SPENT = 1440; //60min * 24h

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $timeSpent;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
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

    public function getTimeSpent(): ?int
    {
        return $this->timeSpent;
    }

    public function setTimeSpent(int $timeSpent): self
    {
        //Maybe bette use startAt(DateTime) and finishAt(DateTime). will be more flexible then integer value in mins
        if ($timeSpent > self::MAX_TIME_SPENT) {
            throw new \Exception(sprintf('Time spent limit %s exceeded.', self::MAX_TIME_SPENT));
        }

        $this->timeSpent = $timeSpent;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
