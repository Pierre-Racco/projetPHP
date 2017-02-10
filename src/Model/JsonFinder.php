<?php

namespace Model;

class JsonFinder implements FinderInterface
{

    private $path = __DIR__."../../../data/statuses.json";

    /**
     * @return string
     */
    public function findOneById($id)
    {

        $jsonStatuses = json_decode(file_get_contents($this->path));

        foreach ($jsonStatuses as $key) {
            if ($key->id == $id) {
                return $key;
            }
        }

    }

    /**
     * @return string
     */
    public function findAll()
    {
        return json_decode(file_get_contents($this->path));
    }
}
