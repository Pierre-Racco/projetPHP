<?php

namespace Model;

class InMemoryFinder implements FinderInterface
{
    private $fakeArray = array();

    public function __construct()
    {
        $this->fakeArray[] = new Status(1, "unMessage", "unNom");
        $this->fakeArray[] = new Status(2, "unMessage2", "unNom2");
        $this->fakeArray[] = new Status(3, "unMessage3", "unNom3");
    }

    /**
     * Returns all statuses.
     *
     * @return array
     */
    public function findAll()
    {
        return $this->fakeArray;
    }

    /**
     * Retrieve a status by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
        if (!empty($this->fakeArray)) {
            foreach ($this->fakeArray as $aStatus) {
                if ($aStatus->getId() == $id) {
                    return $aStatus;
                }
            }
        }
    }
}
