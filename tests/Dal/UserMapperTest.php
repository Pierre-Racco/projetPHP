<?php

class UserMapperTest extends TestCase
{
    private $con;

    private $mapper;
    private $userFinder;
    
    // il faudrait supprimer l'auto_increment
    public function setUp()
    {
        $this->con = new \Dal\Connection('sqlite::memory:');

        $this->mapper = new \Dal\UserMapper($this->con);
        $this->userFinder = new \Dal\UserFinder($this->con);

        $this->mapper->persist(new \Model\User(1,"K","phoen"));
    }

	public function testPersist()
	{
        $user = new \Model\User(null, 'login', 'password');
        $this->assertTrue($this->mapper->persist($user));
	}
	
	public function testRemove()
	{
        $user = new \Model\User(0, 'login', 'password');
		$this->mapper->persist($user);
		$this->assertTrue($this->mapper->remove($user));
	}

    public function testFindAll()
    {
        $users = $this->userFinder->findAll();
        $this->assertEquals(1, count($users));
    }

    public function testFindOneById()
    {
        $user = $this->userFinder->findOneById('1');
        $this->assertEquals("K", $user->getUsername());
    }

    public function testFindOneByUsername()
    {
        $user = $this->userFinder->findOneByUsername('K');
        $this->assertEquals("1", $user->getId());
    }

    
}