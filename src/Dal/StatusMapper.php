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
        if($user){
            $fk_user_id = $user->getId();
        }
        $id = $status->getId();
        

        if($statusFinder->findOneById($id)){
            $query = 'INSERT INTO statuses (id, message, name, date) VALUES (:id, :message, :name, :date)';
        } else {
            $query = 'UPDATE FROM statuses (id, message, name, date) VALUES (:id, :message, :name, :date) WHERE id = :id';
        }
        $parameters = array(
            'id' => $status->getId(),
            'message' => $status->getMessage(),
            'name' => $status->getName(),
            'date' => $status->getDate()
        );
        return $this->con->executeQuery($query, $parameters); 
    }
    public function remove(\Model\Status $status)
    {
        $statusFinder = new StatusFinder($this->con);

        $id = $status->getId();

        if($statusFinder->findOneById($id)){
            $query = 'DELETE FROM statuses WHERE id = :id';
            $parameters = array(
                'id' => $id
            );
            return $this->con->executeQuery($query, $parameters); 
        } else {

        }
        
    }
}