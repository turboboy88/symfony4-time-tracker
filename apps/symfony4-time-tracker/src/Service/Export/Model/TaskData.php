<?php

namespace App\Service\Export\Model;

use App\Entity\Task;
use JMS\Serializer\Annotation as Serializer;

class TaskData
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("title")
     */
    protected string $title;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("comment")
     */
    protected ?string $comment;

    /**
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\SerializedName("date")
     */
    protected $date;

    /**
     * @Serializer\Type("int")
     * @Serializer\SerializedName("time_spent")
     */
    protected $timeSpent;

    public function __construct(Task $task)
    {
        $this->title = $task->getTitle();
        $this->comment = $task->getComment();
        $this->date = $task->getDate();
        $this->timeSpent = $task->getTimeSpent();
    }

    /**
     * @return bool
     */
    public function isTitle()
    {
        return $this->title;
    }

    /**
     * @param bool $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     */
    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface|null $date
     */
    public function setDate(?\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    /**
     * @return int|null
     */
    public function getTimeSpent(): ?int
    {
        return $this->timeSpent;
    }

    /**
     * @param int|null $timeSpent
     */
    public function setTimeSpent(?int $timeSpent): void
    {
        $this->timeSpent = $timeSpent;
    }
}


