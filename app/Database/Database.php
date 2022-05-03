<?php

namespace App\Database;

interface Database
{
    public function get(string $key);
    public function store(string $key, $value);
    public function delete(string $key);
}
