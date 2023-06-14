<?php

class Comment
{
    private int $userId;
    private int $ticketId;
    private string $body;

    /**
     * @param int $userId
     * @param int $ticketId
     * @param string $body
     */
    public function __construct(int $userId, int $ticketId, string $body)
    {
        $this->userId = $userId;
        $this->ticketId = $ticketId;
        $this->body = $body;
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

    /**
     * @return int
     */
    public function getTicketId(): int
    {
        return $this->ticketId;
    }

    /**
     * @param int $ticketId
     */
    public function setTicketId(int $ticketId): void
    {
        $this->ticketId = $ticketId;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }




}