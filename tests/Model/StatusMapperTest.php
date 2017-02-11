<?php

class StatusMapperTest extends TestCase
{
    private $con;

    private $mapper;

    public function setUp()
    {
        $this->con = new \Model\Connection('sqlite::memory:');

        $this->mapper = new \Model\StatusMapper($this->con);
    }

	public function testPersist()
	{
        $status = new Model\Status('un super message', 'un super pseudo');
        $this->assertTrue($this->mapper->persist($status));
	}
	
	public function testRemove()
	{
        $status = new Model\Status('un super message', 'un super pseudo');
		$this->mapper->persist($status);
		$this->assertTrue($this->mapper->remove($status));
	}
}