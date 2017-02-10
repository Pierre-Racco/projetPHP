<?php

namespace Model;

class Status implements \JsonSerializable
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var date
     */
    private $date;

    /**
     * @param string   $method
     * @param string   $pattern
     * @param callable $callable
     */
    public function __construct($message, $name)
    {
        $this->id    = uniqid();
        $this->message   = $message;
        $this->name  = $name;
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
