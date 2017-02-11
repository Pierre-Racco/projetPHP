<?php

namespace Dal;

class UserFinder implements FinderInterface
{

    public function __construct(\Dal\Connection $con)
    {
        $this->con = $con;
    }

    /**
     * @return string
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
     * @return string
     */
    public function findAll()
    {

        $stmt = $this->con->prepare('SELECT * FROM users');
        $stmt->execute();
        

        foreach ($users as $user) {
            $returnArray[$user['id']] = new \Model\User($user['id'], $user['username'], $user['password']);
        }
        return $returnArray;
    }

    /**
     * @return string
     */
    public function findOneByUsername($username)
    {

        $stmt = $this->con->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(["username" => $username]);
        $user = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return new \Model\User($user[0]['id'], $user[0]['username'], $user[0]['password']);
    }
}
