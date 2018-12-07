<?php

namespace Test\Api\v1\Services;

use App\Api\v1\Services\WcmsUserService;
use App\Models\WcmsUser;
use PHPUnit\Framework\TestCase;

class WcmsUserServiceTest extends TestCase
{
    public function setUp()
    {
        WcmsUser::unguard();
        $this->user = WcmsUser::make([
            'username' => 'admin',
            'password' => 'password',
        ]);

        $this->user->save();
    }

    public function tearDown()
    {
        WcmsUser::truncate();
    }

    public function testVerifyPassword()
    {
        $service = new WcmsUserService;

        $this->assertTrue($service->verifyPassword($this->user, 'password'));
    }

    public function testVerifyPasswordNotPass()
    {
        $service = new WcmsUserService;

        $this->assertFalse($service->verifyPassword($this->user, 'Password'));
    }
}
