<?php
require_once "Priority.php";
require_once "Department.php";

class Ticket
{
    private int $userId;
    private string $title;
    private Priority $priority;
    private Department $department;
    private string $assignee;
    private string $attachment;
    private DateTime $dateAdded;
    private DateTime $dateClosed;
    private DateTime $deadline;
    private bool $isClosed;

    /**
     * @param int $userId
     * @param string $title
     * @param Priority $priority
     * @param Department $department
     * @param string $assignee
     * @param string $attachment
     * @param DateTime $deadline
     */
    public function __construct(int $userId, string $title, Priority $priority, Department $department, string $assignee, string $attachment, DateTime $deadline)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->priority = $priority;
        $this->department = $department;
        $this->assignee = $assignee;
        $this->attachment = $attachment;
        $this->dateAdded = new DateTime();
        $this->deadline = $deadline;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return Priority
     */
    public function getPriority(): Priority
    {
        return $this->priority;
    }

    /**
     * @param Priority $priority
     */
    public function setPriority(Priority $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return Department
     */
    public function getDepartment(): Department
    {
        return $this->department;
    }

    /**
     * @param Department $department
     */
    public function setDepartment(Department $department): void
    {
        $this->department = $department;
    }

    /**
     * @return string
     */
    public function getAssignee(): string
    {
        return $this->assignee;
    }

    /**
     * @param string $assignee
     */
    public function setAssignee(string $assignee): void
    {
        $this->assignee = $assignee;
    }

    /**
     * @return string
     */
    public function getAttachment(): string
    {
        return $this->attachment;
    }

    /**
     * @param string $attachment
     */
    public function setAttachment(string $attachment): void
    {
        $this->attachment = $attachment;
    }

    /**
     * @return DateTime
     */
    public function getDateAdded(): DateTime
    {
        return $this->dateAdded;
    }

    /**
     * @param DateTime $dateAdded
     */
    public function setDateAdded(DateTime $dateAdded): void
    {
        $this->dateAdded = $dateAdded;
    }

    /**
     * @return DateTime
     */
    public function getDateClosed(): DateTime
    {
        return $this->dateClosed;
    }

    /**
     * @param DateTime $dateClosed
     */
    public function setDateClosed(DateTime $dateClosed): void
    {
        $this->dateClosed = $dateClosed;
    }

    /**
     * @return DateTime
     */
    public function getDeadline(): DateTime
    {
        return $this->deadline;
    }

    /**
     * @param DateTime $deadline
     */
    public function setDeadline(DateTime $deadline): void
    {
        $this->deadline = $deadline;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->isClosed;
    }

    /**
     * @param bool $isClosed
     */
    public function setIsClosed(bool $isClosed): void
    {
        $this->isClosed = $isClosed;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }


}