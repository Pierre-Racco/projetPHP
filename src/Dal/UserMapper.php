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
        $userFinder = new UserFinder($this->con);
        
        if(!$userFinder->findOneByUsername($user->getUsername())){
            $query = 'INSERT INTO users (id, username, password) VALUES (:id, :username, :password)';
        } else {
            $query = 'UPDATE FROM users (id, username, password) VALUES (:id, :username, :password) WHERE id = :id';
        }
        $parameters = array(
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
        );
        return $this->con->executeQuery($query, $parameters);
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
            $query = 'DELETE FROM users WHERE id = :id';
            $parameters = array(
                'id' => $id,
            );
            return $this->con->executeQuery($query, $parameters);
        } else {
            return false;
        }
        
    }
}