<?php

namespace Http;

class Request
{
    const GET    = 'GET';

    const POST   = 'POST';

    const PUT    = 'PUT';

    const DELETE = 'DELETE';

    private $parameters;

    public function __construct(array $query = array(), array $request = array())
    {
        $this->parameters = array_merge($query, $request);

    }

    public function getMethod()
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : self::GET;

        if (self::POST === $method) {
            return $this->getParameter('_method', $method);
        }

        return $method;

    }

    public function getUri()
    {
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        if ($pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        return $uri;

    }

    public function getParameter($name, $default = null)
    {
        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        } else {
            return $default;
        }
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public static function createFromGlobals()
    {
        if((isset($_SERVER['CONTENT_TYPE']) &&  $_SERVER['CONTENT_TYPE']==='application/json')
                ||(isset($_SERVER['HTTP_CONTENT_TYPE']) && $_SERVER['HTTP_CONTENT_TYPE']==='application/json')){
            $data    = file_get_contents('php://input');
            $request = @json_decode($data, true);

            return new self($_GET, $request);
        } else {
            //Foireux or not foireux ?
            return new self($_GET, $_POST);
        }
    }

    public function guessBestFormat()
    {
        $negotiator = new \Negotiation\Negotiator();
        $acceptHeader = $_SERVER['HTTP_ACCEPT'];

        $priorities   = array('text/html; charset=UTF-8', 'application/json');

        $mediaType = $negotiator->getBest($acceptHeader, $priorities);

        return $mediaType->getValue();
    }
}
