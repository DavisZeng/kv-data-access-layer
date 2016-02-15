<?php
/**
 * @filename ConfigureCenterTest.php
 * @touch    1/22/16 11:05
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Tests;

use KVDataAccessLayer\Configure\ConfigureCenter;

class ConfigureCenterTest extends \PHPUnit_Framework_TestCase
{

    public function testGet()
    {
        $mem_host = ConfigureCenter::singleton()->get('kvdal.memcache.host_list_str');
        $this->assertEquals('127.0.0.1,127.0.0.1', $mem_host);
        $mysql_port = ConfigureCenter::singleton()->get('kvdal.mysql.port_list_str');
        $this->assertEquals(3306, $mysql_port);
    }

    public function testInstance()
    {
        $instance = ConfigureCenter::singleton();
        $this->assertTrue(is_a($instance, 'KVDataAccessLayer\Configure\ConfigureCenter'));
    }
}