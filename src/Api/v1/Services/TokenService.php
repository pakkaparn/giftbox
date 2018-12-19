<?php

namespace App\Api\v1\Services;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use UnexpectedValueException;

class TokenService
{
    const HS256 = 'HS256';
    const HS512 = 'HS512';

    private $key;
    private $algorithm;
    private $refreshTokenTTL = '+1 week';
    private $accessTokenTTL = '+15 minutes';

    public function __construct($key, $algorithm, $leeway = 0)
    {
        if (empty($key)) {
            throw new InvalidArgumentException('Key may not be empty');
        }

        if (!in_array($algorithm, $this->getAllowedAlgorithm())) {
            throw new UnexpectedValueException('Algorithm not allowed');
        }

        $this->key = $key;
        $this->algorithm = $algorithm;

        JWT::$leeway = $leeway;
    }

    public function generateRefreshToken(Model $user, array $content = [], $ttl = null): String
    {
        $ttl = $ttl ?: $this->refreshTokenTTL;
        return $this->generateToken($user, $content, $ttl);
    }

    public function generateAccessToken(Model $user, array $content = [], $ttl = null): String
    {
        $ttl = $ttl ?: $this->accessTokenTTL;
        return $this->generateToken($user, $content, $ttl);
    }

    public function decodeToken($token): Object
    {
        $decoded = JWT::decode($token, $this->getKey(), $this->getAllowedAlgorithm());

        return $decoded->data;
    }

    public function setRefreshTokenTTL($ttl)
    {
        $this->refreshTokenTTL = $ttl;
    }

    public function setAccessTokenTTL($ttl)
    {
        $this->accessTokenTTL = $ttl;
    }

    public function getKey()
    {
        return $this->key;
    }

    protected function generateToken(Model $user, array $content = [], $ttl): String
    {
        $payload = [
            'iat' => Carbon::now()->timestamp,
            'nbf' => Carbon::now()->timestamp,
            'exp' => Carbon::parse($ttl)->timestamp,
            'data' => [
                'username' => $user->username,
            ] + $content,
        ];

        return JWT::encode($payload, $this->getKey(), $this->getAlgorithm());
    }

    protected function getAlgorithm()
    {
        return 'HS512';
    }

    protected function getAllowedAlgorithm()
    {
        return [static::HS256, static::HS512];
    }
}
