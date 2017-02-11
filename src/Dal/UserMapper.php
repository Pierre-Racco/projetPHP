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
        $userFinder = new UserFinder($this->con);

        $id = $user->getId();
        
        if(!$userFinder->findOneByUsername($user->getUsername())){
            $query = 'INSERT INTO users (id, username, password) VALUES (:id, :username, :password)';
        } else {
            $query = 'UPDATE FROM users (id, username, password) VALUES (:id, :username, :password) WHERE id = :id';
        }
        $parameters = array(
            'id' => $id,
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
        );
        var_dump('ok');
        var_dump($this->con->executeQuery($query, $parameters));
        var_dump('ok');
        return $this->con->executeQuery($query, $parameters);
    }

    public function remove(\Model\User $user)
    {
        $id = $user->getId();

        if($finder->findOneById($id)){
            $stmt = $this->con->prepare('DELETE FROM users WHERE id = :id');
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);  
            return $stmt->execute();
        } else {

        }
        
    }
}