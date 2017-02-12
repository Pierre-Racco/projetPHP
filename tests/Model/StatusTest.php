<?php

class StatusTest extends TestCase
{

    private $status;



    public function testConstruct()
    {
        $this->status = new \Model\Status(1, "message",  0, date("Y-m-d H:i:s", time()));
        $this->assertNotNull($this->status);
    }

    public function testGetMessage()
    {
        $this->status = new \Model\Status(1, "message",  0, date("Y-m-d H:i:s", time()));
        $this->assertEquals("message", $this->status->getMessage());
    }

    public function testGetId()
    {
        $this->status = new \Model\Status(1, "message",  0, date("Y-m-d H:i:s", time()));
        $this->assertEquals("1", $this->status->getId());
    }

    public function testGetUserId()
    {
        $this->status = new \Model\Status(1, "message",  0, date("Y-m-d H:i:s", time()));
        $this->assertEquals(0, $this->status->getUserId());
    }

}
