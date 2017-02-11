<?php

namespace Dal;

class UserFinder implements FinderInterface
{
    private $con;

    public function __construct(\Dal\Connection $con)
    {
        $this->con = $con;
    }

    /**
     * Renvoie un user grâce à son id 
     * @param id identifiant du user
     * @param criteria
     * @return user
     */
    public function findOneById($id, $criteria = null)
    {
        $stmt = $this->con->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id,  \PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($user){
            return new \Model\User($user['id'], $user['username'], $user['password']);
        } else {
            return false;
        }
        
    }

    /**
     * Renvoie un user grâce à son username 
     * @param username nom du user
     * @param criteria
     * @return user
     */
    public function findOneByUsername($username)
    {
        
        $stmt = $this->con->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(["username" => $username]);
        
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
        if($user){
            return new \Model\User($user['id'], $user['username'], $user['password']);
        } else {
            return false;
        }
    }

    /**
     * Retourne tous les users
     * @return users
     */
    public function findAll()
    {
        $returnArray = [];
        $stmt = $this->con->prepare('SELECT * FROM users');
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($users as $user) {
            $returnArray[$user['id']] = new \Model\User($user['id'], $user['username'], $user['password']);
        }
        return $returnArray;
        
    }
}
