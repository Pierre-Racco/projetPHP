<?php

namespace Model;

class JsonModificator
{

    private $path = __DIR__."../../../data/statuses.json";

    /**
     * write + encode
     */
    public function encodeStatus(\Model\Status $status)
    {
        file_put_contents($this->path, json_encode($status)."\n", FILE_APPEND);
    }

    /**
     * delete + encode
     */
    public function deleteStatus($id)
    {
        $finder = new JsonFinder();
        $jsonStatuses = $finder->findAll();
        $toDelete = array_search($id, array_column($jsonStatuses, 'id'));

        if($toDelete != null){
            unset($jsonStatuses[$toDelete]);

            file_put_contents($this->path, json_encode($jsonStatuses));
        } else {
            return null;
        }

    }
}
