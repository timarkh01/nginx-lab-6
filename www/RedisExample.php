<?php
namespace App;

class RedisExample
{
    private $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('lab6_redis', 6379);
    }

    public function setValue($key, $value)
    {
        return $this->redis->set($key, $value);
    }

    public function getValue($key)
    {
        return $this->redis->get($key);
    }
}