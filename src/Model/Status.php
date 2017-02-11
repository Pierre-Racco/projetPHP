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
    public function __construct($message, $name)
    {
        $this->id = uniqid(); // uniqid & schema base id auto increment??
        $this->message = $message;
        $this->name = $name;
        $this->date = date("Y-m-d H:i:s", time());
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
