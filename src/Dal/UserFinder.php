<?php

namespace Dal;

class UserFinder implements FinderInterface
{

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
        $stmt = $con->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id,  \PDO::PARAM_INT);
        $stmt->execute($stmt);
        $stmt->fetchObject('User');

        return $stmt;
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
        $stmt->bindParam(':username', $username,  \PDO::PARAM_STR);
        $stmt->execute($stmt);
        $stmt->fetchAll(\PDO::FETCH_CLASS, 'User');
        
        return $stmt;
    }

    /**
     * Retourne tous les users
     * @return users
     */
    public function findAll()
    {
        $stmt = $this->con->prepare('SELECT * FROM users');
        $stmt->execute($stmt);
        $stmt->fetchAll(\PDO::FETCH_CLASS, 'User');

        return $stmt;
    }
}
