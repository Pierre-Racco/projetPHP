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
        $user = $userFinder->findOneByUsername($status->getUserUsername());
        $id = $status->getId();
        if ($user != null) {
            $user_id = $user->getId();
        } else {
            $user_id = null;
        }
        if ($statusFinder->findOneById($id)) {
            $query = 'UPDATE FROM statuses (id, message, user_id, date) VALUES (:id, :message, :user_id, :date) WHERE id = :id';

        } else {
            $query = 'INSERT INTO statuses (id, message, user_id, date) VALUES (:id, :message, :user_id, :date)';
        }
        $parameters = array(
            'id' => $status->getId(),
            'message' => $status->getMessage(),
            'user_id' => $user_id,
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

        if ($statusFinder->findOneById($id)) {
            $query = 'DELETE FROM statuses WHERE id = :id';
            $parameters = array(
                'id' => $id
            );

            return $this->con->executeQuery($query, $parameters);
        }
    }
}
