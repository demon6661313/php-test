<?php

namespace App\Database\Concrete;

use App\Database\Database;
use Predis\Client;

class RedisClient implements Database
{
    protected $redis;
    public function __construct()
    {
        $this->redis = new Client(getenv('REDIS_CONNECT'));
    }
    public function get(string $key)
    {
        return $this->redis->get($key);
    }
    public function store(string $key, $value)
    {
        return $this->redis->set($key, $value, 'EX', 3600);
    }
    public function delete(string $key)
    {
        return $this->redis->del($key);
    }
    public function all()
    {
        return $this->redis->keys('*');
    }
}
