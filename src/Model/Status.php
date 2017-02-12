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
    private $user_username;

    /**
     * @var date
     */
    private $date;

    /**
     * @param string $message
     * @param string $name
     */
    public function __construct($id = null, $message, $user_username = null, $date)
    {
        $this->id    = $id;
        $this->message   = $message;
        $this->user_username   = ($user_username == null) ? "Anonymous" : $user_username;
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
    public function getUserUsername()
    {
        return $this->user_username;
    }

    /**
     * Utile pour la sérialization d'un status
     * @return Array représentant un status
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'user_username' => $this->user_username,
            'date' => $this->date,
            'message' => $this->message
        ];
    }
}
