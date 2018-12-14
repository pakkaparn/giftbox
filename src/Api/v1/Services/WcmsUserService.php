<?php

namespace App\Api\v1\Services;

use App\Models\WcmsUser;

class WcmsUserService
{
    public function getByUsername($username): WcmsUser
    {
        return WcmsUser::whereUsername($username)->firstOrFail();
    }

    public function verifyPassword(WcmsUser $user, $password): bool
    {
        return password_verify($password, $user->password);
    }
}
