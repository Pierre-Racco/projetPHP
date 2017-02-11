<?php

namespace Dal;

class Connection extends \PDO
{
	/**
     * @param string $query
     * @param array  $parameters
     *
     * @return bool Returns `true` on success, `false` otherwise
     */
	public function executeQuery($query, array $parameters = [])
    {
        $this->stmt = parent::prepare($query);
        foreach ($parameter as $name => $value) {
            $this->stmt->bindValue(':' . $name, $value);
        }
        return $this->stmt->execute();
    }
}