<?php
/**
 * @filename ConfigIniHandler.php
 * @touch    1/22/16 10:31
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Configure;


class ConfigIniHandler implements ConfigureHandlerInterface
{
    private $config_ini_directory = '/vagrant/ini/';

    public function __construct()
    {

    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $key
     *
     * @return string
     */
    public function get($key)
    {
        $value = '';
        $keys  = explode('.', $key);
        do {
            $count = count($keys);
            foreach ($keys as $key) {
                $file = $this->config_ini_directory . $key . '.ini';
                if (!file_exists($file)) {
                    break;
                }
                $data = parse_ini_file($file, true);
            }
            if ($count == 2 && isset($keys[1]) && isset($data[$keys[1]])) {
                $value = $data[$keys[1]];
                break;
            }
            if ($count == 3 && isset($keys[1]) && isset($keys[2]) && isset($data[$keys[1]][$keys[2]])) {
                $value = $data[$keys[1]][$keys[2]];
                break;
            }
            if ($count == 4 && isset($keys[1]) && isset($keys[2]) && isset($keys[3]) && isset($data[$keys[1]][$keys[2]][$keys[3]])) {
                $value = $data[$keys[1]][$keys[2]][$keys[3]];
                break;
            }
        } while (0);

        return $value;
    }
}