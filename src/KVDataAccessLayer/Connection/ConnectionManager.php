<?php
/**
 * @filename ConnectionManager.php
 * @touch    1/22/16 09:13
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Connection;


use KVDataAccessLayer\Exception\DBModelException;

class ConnectionManager
{
    /**
     * @var array
     */
    private $pdos = array();

    private $mems = array();

    /**
     * @var \KVDataAccessLayer\Connection\ConnectionManager
     */
    private static $instance;

    private function __construct()
    {
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return ConnectionManager
     */
    public static function singleton()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $host
     * @param $port
     * @param $dbname
     * @param $user
     * @param $password
     *
     * @return mixed
     * @throws DBModelException
     */
    public function getPdo($host, $port, $dbname, $user, $password)
    {
        $key = $host . $port . $dbname;
        if (!isset($this->pdos[$key])) {
            $dsn = "mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname;
            try {
                $this->pdos[$key] = new \PDO(
                    $dsn,
                    $user,
                    $password,
                    array(
                        \PDO::ATTR_PERSISTENT => true,
                        \PDO::ATTR_ERRMODE    => \PDO::ERRMODE_EXCEPTION)
                );
            } catch (\PDOException $e) {
                throw new DBModelException('New PDO object failed.', (int)$e->getCode(), $e->errorInfo);
            }
        }

        return $this->pdos[$key];
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param array $config
     *
     * @return bool|\PDO
     */
    public function pdo(Array $config)
    {
        if ($config === array()) {
            return false;
        }

        return $this->getPdo($config['host'], $config['port'], $config['dbname'], $config['user'], $config['password']);
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param array $config
     *
     * @return array|bool
     */
    public function pdos(Array $config)
    {
        $pdos = array();
        if ($config == array()) {
            return false;
        }
        $host_list_arr     = explode(',', $config['host_list_str']);
        $port_list_arr     = explode(',', $config['port_list_str']);
        $user_list_arr     = explode(',', $config['user_list_str']);
        $password_list_arr = explode(',', $config['password_list_str']);
        $dbname_list_arr   = explode(',', $config['dbname_list_str']);
        $len               = count($host_list_arr);

        for ($i = 0; $i < $len; $i++) {
            $pdos[] = $this->getPdo($host_list_arr[$i], $port_list_arr[$i], $dbname_list_arr[$i], $user_list_arr[$i], $password_list_arr[$i]);
        }

        return $pdos;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $host_list_str
     * @param $port_list_str
     * @param $weight_list_str
     *
     * @return \Memcached
     */
    public function getMem($host_list_str, $port_list_str, $weight_list_str)
    {
        $key = $host_list_str . $port_list_str;
        if (!isset($this->mems[$key])) {
            $memcached       = new \Memcached();
            $host_list_arr   = explode(',', $host_list_str);
            $port_list_arr   = explode(',', $port_list_str);
            $weight_list_arr = explode(',', $weight_list_str);
            $len             = count($host_list_arr);
            for ($i = 0; $i < $len; $i++) {
                $memcached->addServer($host_list_arr[$i], (int)$port_list_arr[$i], (int)$weight_list_arr[$i]);
            }
            $this->mems[$key] = $memcached;
        }

        return $this->mems[$key];
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param array $config
     *
     * @return bool|\Memcached
     */
    public function mem(Array $config)
    {
        if ($config == array()) {
            return false;
        }

        return $this->getMem($config['host_list_str'], $config['port_list_str'], $config['weight_list_str']);
    }
}
