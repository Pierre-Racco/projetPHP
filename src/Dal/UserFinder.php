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
        $user = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return new \Model\User($user[0]['id'], $user[0]['username'], $user[0]['password']);
    }

    /**
     * Renvoie un user grâce à son username 
     * @param username nom du user
     * @param criteria
     * @return user
     */
    public function findOneByUsername($username)
    {
        $stmt = $this->con->prepare('SELECT * FROM users');
        $stmt->execute();
        

        foreach ($users as $user) {
            $returnArray[$user['id']] = new \Model\User($user['id'], $user['username'], $user['password']);
        }
        return $returnArray;
    }

    /**
     * Retourne tous les users
     * @return users
     */
    public function findAll()
    {
        $stmt = $this->con->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(["username" => $username]);
        $user = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return new \Model\User($user[0]['id'], $user[0]['username'], $user[0]['password']);
    }
}
