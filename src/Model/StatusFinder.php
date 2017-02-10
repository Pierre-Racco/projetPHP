<?php

namespace Model;

class StatusFinder implements FinderInterface
{

    public function __construct(\Model\Connection $con)
    {
        $this->con = $con;
    }

    /**
     * @return string
     */
    public function findOneById($id, $criteria = null)
    {

        $stmt = $con->prepare('SELECT * FROM statuses WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute($stmt);
        $stmt->fetchObject('Status');

        return $stmt
;    }

    /**
     * @return string
     */
    public function findAll()
    {

        $stmt = $con->prepare('SELECT * FROM statuses');
        $stmt->execute($stmt);
        $stmt->fetchAll(PDO::FETCH_CLASS, 'Status');
        return $stmt;
    }
}
