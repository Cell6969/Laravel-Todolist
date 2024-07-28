<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServiceImpl implements UserService
{
    private array $users = [
        "jonathan" => "12345"
    ];
    function login(string $user, string $password): bool
    {
        // Check if user exists
        if (!isset($this->users[$user])) {
            return false;
        }

        $correctPassword = $this->users[$user];
        return $correctPassword == $password;
    }
}
