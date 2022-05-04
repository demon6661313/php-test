<?php

namespace App\Controllers\Http;

use App\Database\Factory\DatabaseFactory;
use Lib\Http\Request;

class RedisController extends Controller
{
    public function __construct()
    {
        $this->redis = (new DatabaseFactory())->make('redis');
    }
    public function all(Request $request)
    {
        $keys = $this->redis->all();
        $result = [];
        foreach ($keys as $key) {
            $result[] = [$key => $this->redis->get($key)];
        }
        echo json_encode($result);
    }
    public function delete(Request $request)
    {
    }
}
