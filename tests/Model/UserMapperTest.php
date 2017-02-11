<?php

class UserMapperTest extends TestCase
{
    private $con;

    private $mapper;

    public function setUp()
    {
        $this->con = new \Model\Connection('sqlite::memory:');

        $this->mapper = new \Model\userMapper($this->con);
    }

	public function testPersist()
	{
        $user = new Model\User('login', 'password');
        $this->assertTrue($this->mapper->persist($user));
	}
	
	public function testRemove()
	{
        $user = new Model\User('login', 'password');
		$this->mapper->persist($user);
		$this->assertTrue($this->mapper->remove($user));
	}
}