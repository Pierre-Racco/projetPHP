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
    private $name;

    /**
     * @var date
     */
    private $date;

    /**
     * @param string   $message
     * @param string   $name
     */
    public function __construct($id, $message, $name, $date)
    {
        $this->id    = $id;
        $this->message   = $message;
        $this->name  = $name;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * Utile pour la sérialization d'un status
     * @return Array représentant un status
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date,
            'message' => $this->message
        ];
    }
}
