<?php

namespace App\Controllers\Cli;

use App\Controllers\Controller;
use App\Database\Factory\DatabaseFactory;

class RedisCliController extends Controller
{
    protected $redis;
    public function __construct()
    {
        $this->redis = (new DatabaseFactory())->make('redis');
    }
    public function run($argv)
    {
        $name = isset($argv[2]) ? $argv[2] : null;
        if ($name) {

            $this->$name($argv);
        }
    }

    public function all()
    {
    }
    protected function get($argv)
    {
        if (isset($argv[3])) {
            print_r($this->redis->get($argv[3]));
        }
    }
    protected function add($argv)
    {
        if (isset($argv[3]) && isset($argv[4])) {
            $this->redis->store($argv[3], $argv[4]);
        }
    }
    protected function delete($argv)
    {
        if (isset($argv[3])) {
            $this->redis->delete($argv[3]);
        }
    }
}
