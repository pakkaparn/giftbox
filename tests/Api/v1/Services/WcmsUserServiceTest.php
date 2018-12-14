<?php

namespace Test\Api\v1\Services;

use App\Api\v1\Services\WcmsUserService;
use App\Models\WcmsUser;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\TestCase;

class WcmsUserServiceTest extends TestCase
{
    protected $faker;
    protected $username;
    protected $password;

    public function setUp()
    {
        $this->faker = Faker::create();
        $this->username = $this->faker->userName;
        $this->password = $this->faker->password;

        WcmsUser::unguard();

        $this->user = WcmsUser::make([
            'username' => $this->username,
            'password' => $this->password,
        ]);

        $this->user->save();

        $this->service = new WcmsUserService;
    }

    public function tearDown()
    {
        WcmsUser::truncate();
    }

    public function testGetByUsername()
    {
        $user = $this->service->getByUsername($this->username);
        $this->assertSame($this->user->id, $user->id);
    }

    public function testGetWrongUsername()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->service->getByUsername($this->faker->userName);
    }

    public function testVerifyPassword()
    {
        $this->assertTrue($this->service->verifyPassword($this->user, $this->password));
    }

    public function testVerifyPasswordNotPass()
    {
        $this->assertFalse($this->service->verifyPassword($this->user, $this->faker->password));
    }
}
