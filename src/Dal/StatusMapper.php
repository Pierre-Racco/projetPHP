<?php

namespace Dal;

class StatusMapper
{
    private $con;

    public function __construct(\Dal\Connection $con)
    {
        $this->con = $con;
    }

    /**
     * Ajoute ou modifie un status dans la base de données
     * @param status à ajouter/modifier
     * @return boolean en fonction du résultat de la requête
     */
    public function persist(\Model\Status $status)
    {
        $statusFinder = new StatusFinder($this->con);
        $userFinder = new UserFinder($this->con);
        $user = $userFinder->findOneByUsername($status->getName());
        if($user){
            $fk_user_id = $user->getId();
        }
        $id = $status->getId();
        
        if($finder->findOneById($id)){
            $query = 'UPDATE FROM statuses (id, message, name, date) VALUES (:id, :message, :name, :date) WHERE id = :id';
            
        } else {
            $query = 'INSERT INTO statuses (id, message, name, date) VALUES (:id, :message, :name, :date)';
        }
        $parameters = array(
            'id' => $status->getId(),
            'message' => $status->getMessage(),
            'name' => $status->getName(),
            'date' => $status->getDate()
        );
        return $this->con->executeQuery($query, $parameters); 
    }

    /**
     * Supprimer un status dans la base de données
     * @param id identifiant du status
     * @return boolean en fonction du résultat de la requête
     */
    public function remove($id)
    {
        $statusFinder = new StatusFinder($this->con);
        // à tester sans le if
        // execute return false s'il a pas trouvé d'élément à supprimer??
        if($finder->findOneById($id)){
            $query = 'DELETE FROM statuses WHERE id = :id';
            $parameters = array(
                'id' => $id
            );
            return $this->con->executeQuery($query, $parameters);
        } else {
            return false;
        }
    }
}