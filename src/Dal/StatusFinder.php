<?php

namespace Dal;

class StatusFinder implements FinderInterface
{
    private $con;

    public function __construct(\Dal\Connection $con)
    {
        $this->con = $con;
    }

    /**
     * Renvoie un status grâce à son id 
     * @param id identifiant du status
     * @param criteria
     * @return status
     */
    public function findOneById($id, $criteria = null)
    {
        $stmt = $this->con->prepare('SELECT * FROM statuses WHERE id = :id');
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute($stmt);
        $stmt->fetchObject('Status');

        return $stmt;
    }

    /**
     * Retourne tous les status
     * @return statuses
     */
    public function findAll()
    {
        $stmt = $this->con->prepare('SELECT * FROM statuses');
        $stmt->execute($stmt);
        $stmt->fetchAll(\PDO::FETCH_CLASS, 'Status');

        return $stmt;
    }
}
