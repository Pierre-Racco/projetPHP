<?php
namespace Dal;

class UserMapper
{
private $con;

    public function __construct(\Dal\Connection $con)
    {
        $this->con = $con;
    }

    public function persist(\Model\User $user)
    {
        $id = $user->getId();

        if(!$finder->findOneById($id)){
            $stmt = $this->con->prepare('INSERT INTO users (id, username, password) VALUES (:id, :username, :password)');
        } else {
            $stmt = $this->con->prepare('UPDATE FROM users (id, username, password) VALUES (:id, :username, :password) WHERE id = :id');
        }
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':username', $user->getUsername(), PDO::PARAM_STR);  
            $stmt->bindParam(':password', $user->getPassword(), PDO::PARAM_STR);  
            return $stmt->execute($stmt);
    }

    public function remove(\Model\User $user)
    {
        $id = $user->getId();

        if($finder->findOneById($id)){
            $stmt = $this->con->prepare('DELETE FROM users WHERE id = :id');
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);  
            return $stmt->execute($stmt);
        } else {

        }
        
    }
}