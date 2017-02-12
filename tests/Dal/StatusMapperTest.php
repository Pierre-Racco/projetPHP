<?php

class StatusMapperTest extends TestCase
{
    private $con;

    private $mapper;
    private $statusFinder;

    // il faudrait supprimer l'auto_increment
    public function setUp()
    {
        $this->con = new \Dal\Connection('sqlite::memory:');

        $this->mapper = new \Dal\StatusMapper($this->con);
        $this->statusFinder = new \Dal\StatusFinder($this->con);

        $this->mapper->persist(new \Model\Status(1, "message",  0, date("Y-m-d H:i:s", time())));
    }

	public function testPersist()
	{
        $status = new \Model\Status(0, 'un super message', 0 , date("Y-m-d H:i:s", time()));
        $this->assertTrue($this->mapper->persist($status));
	}
	
	public function testRemove()
	{
        $status = new \Model\Status(0, 'un super message', 0 , date("Y-m-d H:i:s", time()));
		$this->mapper->persist($status);
		$this->assertTrue($this->mapper->remove($status));
	}

    public function testFindAll()
    {
        $statuses = $this->statusFinder->findAll();
        $this->assertEquals(1, count($statuses));
    }

    public function testFindOneById()
    {
        $status = $this->statusFinder->findOneById(1);
        $this->assertEquals(1, $status->getId());
    }
}