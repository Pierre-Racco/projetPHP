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

        $stmt = $con->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->bindParam(':id', $id,  \PDO::PARAM_INT);
        $stmt->execute();
        $stmt->fetchObject('Model\User');

        return $stmt
;    }

    /**
     * @return string
     */
    public function findAll()
    {

        $stmt = $this->con->prepare('SELECT * FROM users');
        $stmt->execute();
        $stmt->fetchAll(\PDO::FETCH_CLASS, 'Model\User');
        return $stmt;
    }

    /**
     * @return string
     */
    public function findOneByUsername($username)
    {

        $stmt = $this->con->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(["username" => $username]);
        $stmt->fetchObject('Model\User');
        return $stmt;
    }
}
