<?php

namespace Test\Api\v1\Services;

use App\Api\v1\Services\TokenService;
use App\Models\WcmsUser;
use Faker\Factory as Faker;
use Firebase\JWT\ExpiredException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class TokenServiceTest extends TestCase
{
    protected $faker;
    protected $user;
    protected $username;
    protected $password;
    protected $service;

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

        $this->service = new TokenService($this->faker->randomNumber, TokenService::HS512);
    }

    public function testEmptyKey()
    {
        $this->expectException(InvalidArgumentException::class);
        $service = new TokenService('', TokenService::HS512);
    }

    public function testNotAllowAlgorithm()
    {
        $this->expectException(UnexpectedValueException::class);
        $service = new TokenService($this->faker->randomNumber, $this->faker->randomNumber);
    }

    public function testGenerateRefreshToken()
    {
        $token = $this->service->generateRefreshToken($this->user);
        $this->assertRegExp('/^[A-Za-z0-9-_=]+\.[A-Za-z0-9-_=]+\.?[A-Za-z0-9-_.+\/=]*$/', $token);
    }

    public function testDecodeToken()
    {
        $token = $this->service->generateRefreshToken($this->user);
        $decoded = $this->service->decodeToken($token);

        $this->assertSame($this->user->username, $decoded->username);
    }

    public function testExpiredToken()
    {
        $this->expectException(ExpiredException::class);

        $this->service->setRefreshTokenTTL('-1 sec');
        $token = $this->service->generateRefreshToken($this->user);
        $decoded = $this->service->decodeToken($token);
    }

    public function testDecodeTokenWithContent()
    {
        $name = $this->faker->name;

        $token = $this->service->generateRefreshToken($this->user, compact('name'));
        $decoded = $this->service->decodeToken($token);

        $this->assertSame($name, $decoded->name);
    }
}
