<?php

namespace Dal;

class UserMapper
{
    private $con;

    public function __construct(\Dal\Connection $con)
    {
        $this->con = $con;
    }

    /**
     * Ajoute ou modifie un user dans la base de données
     * @param user à ajouter/modifier
     * @return boolean en fonction du résultat de la requête
     */
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

    /**
     * Supprimer un user dans la base de données
     * @param id identifiant du user
     * @return boolean en fonction du résultat de la requête
     */
    public function remove($id)
    {
        //$id = $user->getId();
        // idem statusMapper
        if($finder->findOneById($id)){
            $stmt = $this->con->prepare('DELETE FROM users WHERE id = :id');
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);  
            return $stmt->execute($stmt);
        } else {
            return false;
        }
        
    }
}