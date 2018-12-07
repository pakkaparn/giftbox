<?php

namespace App\Api\v1\Services;

use App\Models\WcmsUser;

class WcmsUserService
{
    public function getByUsername($username)
    {
        return WcmsUser::whereUsername($username)->first();
    }

    public function verifyPassword(WcmsUser $user, $password)
    {
        return password_verify($password, $user->password);
    }
}
