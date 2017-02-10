<?php
namespace Model;

class StatusMapper
{
private $con;

    public function __construct(\Model\Connection $con)
    {
        $this->con = $con;
    }

    public function persist(Status $status)
    {
        $id = $status->getId();

        if(!$finder->findOneById($id)){
            $stmt = $this->con->prepare('INSERT INTO statuses (id, message, name, date) VALUES (:id, :message, :name, :date)');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':message', $status->getMessage(), PDO::PARAM_STR);  
            $stmt->bindParam(':name', $status->getName(), PDO::PARAM_STR);  
            $stmt->bindParam(':date', $status->getDate(), PDO::PARAM_STR);  
            return $stmt->execute($stmt);
        } else {
            $stmt = $this->con->prepare('UPDATE FROM statuses (id, message, name, date) VALUES (:id, :message, :name, :date) WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':message', $status->getMessage(), PDO::PARAM_STR);  
            $stmt->bindParam(':name', $status->getName(), PDO::PARAM_STR);  
            $stmt->bindParam(':date', $status->getDate(), PDO::PARAM_STR);
            return $stmt->execute($stmt);
        }
    }

    public function remove(Status $status)
    {
        $id = $status->getId();

        if($finder->findOneById($id)){
            $stmt = $this->con->prepare('DELETE FROM statuses WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);  
            return $stmt->execute($stmt);
        } else {

        }
        
    }
}