<?php
namespace Dal;

class StatusMapper
{
private $con;

    public function __construct(\Dal\Connection $con)
    {
        $this->con = $con;
    }

    public function persist(\Model\Status $status)
    {
        $statusFinder = new StatusFinder($this->con);
        $userFinder = new UserFinder($this->con);
        $user = $userFinder->findOneByUsername($status->getName());
        var_dump($user);
        $fk_user_id = $user->getId();

        if(!$statusFinder->findOneById($id)){
            $query = 'INSERT INTO statuses (id, message, name, date) VALUES (:id, :message, :name, :date)';
        } else {
            $query = 'UPDATE FROM statuses (id, message, name, date) VALUES (:id, :message, :name, :date) WHERE id = :id';
        }
        $parameters = array(
            'id' => $status->getId(),
            'message' => $status->getMessage(),
            'name' => $status->getName(),
            'date' => $status->getDate(),
            'fk_user_id' => $fk_user_id
        );
        return $this->con->executeQuery($query, $parameters); 
    }
    public function remove(\Model\Status $status)
    {
        $statusFinder = new StatusFinder($this->con);

        $id = $status->getId();

        if($statusFinder->findOneById($id)){
            $stmt = $this->con->prepare('DELETE FROM statuses WHERE id = :id');
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);  
            return $stmt->execute();
        } else {

        }
        
    }
}