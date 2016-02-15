<?php
/**
 * @filename YaconfHandler.php
 * @touch    1/22/16 10:02
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Configure;


class YaconfHandler implements ConfigureHandlerInterface
{

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return \Yaconf::get($key);
    }
}