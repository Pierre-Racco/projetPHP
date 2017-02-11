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
        $stmt->bindParam(':id', $id, \PDO::PARAM_STR);
        $stmt->execute();
        $status = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($status){
            return new \Model\Status($status['id'], $status['message'], $status['user_id'], $status['date']);
        } else {
            return false;
        }
        
    }

    /**
     * Retourne tous les status
     * @return statuses
     */
    public function findAll()
    {
        $returnArray = [];
        $stmt = $this->con->prepare('SELECT * FROM statuses');
        $stmt->execute();
        $statuses = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($statuses as $status) {
            $returnArray[$status['id']] = new \Model\Status($status['id'], $status['message'], $status['user_id'], $status['date']);
        }
        return $returnArray;
    }
}
