<?php

namespace Model;

class Status implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var date
     */
    private $date;

    /**
     * @param string   $message
     * @param string   $name
     */
    public function __construct($id, $message, $userId, $date)
    {
        $this->id    = $id;
        $this->message   = $message;
        $this->userId   = $userId;
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Utile pour la sérialization d'un status
     * @return Array représentant un status
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'date' => $this->date,
            'message' => $this->message
        ];
    }
}
