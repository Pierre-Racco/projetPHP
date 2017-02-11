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
        return $this->con->executeQuery($query, $parameters);
    }

    public function remove(\Model\User $user)
    {
        $id = $user->getId();

        if($finder->findOneById($id)){
            $query = 'DELETE FROM users WHERE id = :id';
            $parameters = array(
                'id' => $id,
            );
            return $this->con->executeQuery($query, $parameters);
        } else {

        }
        
    }
}