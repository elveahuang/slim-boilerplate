<?php
declare(strict_types=1);

namespace tests\Controllers;

use tests\TestCase;

class HomeControllerTests extends TestCase
{

    public function testIndex()
    {
        $response = $this->get('/', []);
        $result = $this->getStringBody($response);
        $this->assertEquals('Hello world!', $result);
    }

    public function testHome()
    {
        $response = $this->get('/api/home', []);
        $result = $this->getJsonBody($response);
        $this->assertEquals(1, $result->code);
    }

}
