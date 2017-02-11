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
        $stmt = $this->prepare($query);

        foreach ($parameters as $name => $value) {
            $stmt->bindValue(':'. $name, $value);
        }

        return $stmt->execute();
    }
}