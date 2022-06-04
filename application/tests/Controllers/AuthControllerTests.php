<?php

namespace tests\Controllers;

use tests\TestCase;

class AuthControllerTests extends TestCase
{

    public function testAuthByPassword()
    {
        $response = $this->post('/api/auth/token', [
            'grant_type' => 'password',
            'username' => 'admin',
            'password' => 'admin',
        ]);
        $result = $this->getJsonBody($response);
        $this->assertEquals(1, $result->code);
    }

}
