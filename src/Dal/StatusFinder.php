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
    public function findOneById($id)
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
    public function findAll($criterias = null)
    {
        $returnArray = [];
        $complete ="";
        foreach ($criterias as $parameter => $value) {
            if($parameter == 'orderBy'){
                $complete .= ' ORDER BY '.$value.' DESC AND ';
            } else if($parameter == 'limit') {
                $complete .= 'LIMIT '.$value.' AND ';
            } else if ($parameter == 'user'){
                $complete .= ' WHERE user_id = '.$value.' AND ';
            } else {
                $complete .= strtoupper($parameter).' '.$value.' AND ';
            }
            
        }
        $query = 'SELECT * FROM statuses';
            if (isset($criterias)) {
                $query .= ' '.preg_replace("/ AND $/", '', $complete);
            }
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $statuses = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($statuses as $status) {
            $returnArray[$status['id']] = new \Model\Status($status['id'], $status['message'], $status['user_id'], $status['date']);
        }
        return $returnArray;
    }
}
