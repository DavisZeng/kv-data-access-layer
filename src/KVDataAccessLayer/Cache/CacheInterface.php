<?php
/**
 * @filename CacheInterface.php
 * @touch    1/20/16 17:28
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Cache;

interface CacheInterface
{
    public function set($key, $value);

    public function get($key);

    public function delete($key);
}