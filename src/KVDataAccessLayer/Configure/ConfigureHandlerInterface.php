<?php
/**
 * @filename ConfigureHandlerInterface.php
 * @touch    1/22/16 10:01
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Configure;


interface ConfigureHandlerInterface
{
    public function get($key);
}