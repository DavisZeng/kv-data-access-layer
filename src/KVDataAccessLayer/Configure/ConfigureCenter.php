<?php
/**
 * @filename ConfigureCenter.php
 * @touch    1/22/16 09:57
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Configure;


class ConfigureCenter
{
    /**
     * @var \KVDataAccessLayer\Configure\ConfigureCenter
     */
    private static $instance;

    /**
     * @var \KVDataAccessLayer\Configure\ConfigureHandlerInterface
     */
    private static $handler;

    private function __construct(ConfigureHandlerInterface $handler)
    {
        self::$handler = $handler;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param ConfigureHandlerInterface|NULL $handler
     *
     * @return ConfigureCenter
     */
    public static function singleton(ConfigureHandlerInterface $handler = NULL)
    {
        if (!self::$instance) {
            if (!$handler) {
                if (extension_loaded('yaconf')) {
                    $handler = new YaconfHandler();
                } else {
                    $handler = new ConfigIniHandler();
                }
            }
            self::$instance = new self($handler);
        }

        return self::$instance;
    }

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
        return self::$handler->get($key);
    }
}