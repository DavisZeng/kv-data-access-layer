<?php
/**
 * @filename ConnectionManagerTest.php
 * @touch    1/22/16 13:37
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Tests;


use KVDataAccessLayer\Configure\ConfigureCenter;
use KVDataAccessLayer\Connection\ConnectionManager;

class ConnectionManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $instance = ConnectionManager::singleton();
        $this->assertTrue(($instance instanceof ConnectionManager));
    }

    public function testMem()
    {
        $mem_config = ConfigureCenter::singleton()->get('kvdal.memcache');
        $memcached  = ConnectionManager::singleton()->mem($mem_config);
        $this->assertTrue(($memcached instanceof \Memcached));

        return $memcached;
    }

    public function testGetMem()
    {
        $host_list_str   = ConfigureCenter::singleton()->get('kvdal.memcache.host_list_str');
        $port_list_str   = ConfigureCenter::singleton()->get('kvdal.memcache.port_list_str');
        $weight_list_str = ConfigureCenter::singleton()->get('kvdal.memcache.weight_list_str');
        $memcached       = ConnectionManager::singleton()->getMem($host_list_str, $port_list_str, $weight_list_str);
        $this->assertTrue(($memcached instanceof \Memcached));

        return $memcached;
    }

    /**
     * @depends testMem
     * @author  : De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param \Memcached $memcached
     */
    public function testMemcache(\Memcached $memcached)
    {
        $bool = $memcached->set('_var_', 123);
        $this->assertTrue($bool);
        $value = $memcached->get('_var_');
        $this->assertEquals(123, $value);
    }

    public function testGetPdo()
    {
        $host     = ConfigureCenter::singleton()->get('kvdal.mysql.host_list_str');
        $port     = ConfigureCenter::singleton()->get('kvdal.mysql.port_list_str');
        $dbname   = ConfigureCenter::singleton()->get('kvdal.mysql.dbname_list_str');
        $user     = ConfigureCenter::singleton()->get('kvdal.mysql.user_list_str');
        $password = ConfigureCenter::singleton()->get('kvdal.mysql.password_list_str');
        $pdo      = ConnectionManager::singleton()->getPdo($host, $port, $dbname, $user, $password);
        $this->assertTrue(($pdo instanceof \PDO));
    }

//    public function testPdo()
//    {
//        $mysql_config = ConfigureCenter::singleton()->get('kvdal.mysql');
//        $pdo          = ConnectionManager::singleton()->pdo($mysql_config);
//        $this->assertTrue(($pdo instanceof \PDO));
//    }
}