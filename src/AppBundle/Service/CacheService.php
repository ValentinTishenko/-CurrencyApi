<?php

namespace AppBundle\Service;

use Symfony\Component\Cache\Simple\FilesystemCache;

class  CacheService
{
    private $cache;

    public function removeCache($key) {
        $this->cache->delete($key);
    }

    public function setCache($key, $value) {
        $this->cache->set($key, $value);
    }

    public function getCache($key) {
        return $this->cache->get($key, false);
    }

    public function __construct() {
        $this->cache = new FilesystemCache('cache', '900');
    }
}