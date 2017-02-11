<?php

namespace Dal;

class StatusFinder implements FinderInterface
{

    public function __construct(\Dal\Connection $con)
    {
        $this->con = $con;
    }

    /**
     * @return string
     */
    public function findOneById($id, $criteria = null)
    {

        $stmt = $this->con->prepare('SELECT * FROM statuses WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $status = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return new \Model\Status($status[0]['id'], $status[0]['message'], $status[0]['name'], $status[0]['date']);
    }

    /**
     * @return string
     */
    public function findAll()
    {
        $returnArray = [];
        $stmt = $this->con->prepare('SELECT * FROM statuses');
        $stmt->execute();
        $statuses = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($statuses as $status) {
            $returnArray[$status['id']] = new \Model\Status($status['id'], $status['message'], $status['name'], $status['date']);
        }
        return $returnArray;
    }
}
