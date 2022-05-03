<?php

namespace App\Database\Factory;

use App\Database\Concrete\RedisClient;
use App\Database\Database;

class DatabaseFactory
{
    public function make($key): Database
    {
        if ($key == 'redis') {
            return new RedisClient();
        }
    }
}
