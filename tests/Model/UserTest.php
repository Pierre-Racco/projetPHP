<?php

class UserTest extends TestCase
{

    private $user;



    public function testConstruct()
    {
        $this->user = new \Model\User(0, 'login', password_hash("password",PASSWORD_BCRYPT));
        $this->assertNotNull($this->user);
    }

    public function testGetUsername()
    {
        $this->user = new \Model\User(0, 'login', password_hash("password",PASSWORD_BCRYPT));
        $this->assertEquals("login", $this->user->getUsername());
    }

    public function testGetId()
    {
        $this->user = new \Model\User(0, 'login', password_hash("password",PASSWORD_BCRYPT));
        $this->assertEquals("0", $this->user->getId());
    }

    public function testGetPassword()
    {
        $this->user = new \Model\User(0, 'login', password_hash("password",PASSWORD_BCRYPT));
        $this->assertTrue(password_verify("password", $this->user->getPassword()));

    }

}
