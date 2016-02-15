<?php
/**
 * @filename UserProfileCacheModelTest.php
 * @touch    1/28/16 14:03
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Tests;


use KVDataAccessLayer\TestModel\UserProfileCacheModel;
use KVDataAccessLayer\TestModel\UserProfileLBDBModel;


class UserProfileCacheModelTest extends \PHPUnit_Framework_TestCase
{
    protected $key;
    protected $pdo;

    public function setUp()
    {
        $this->key = 100;
        $pdos      = UserProfileLBDBModel::model()->pdos();
        $this->pdo = array_pop($pdos);
        if ($this->pdo instanceof \PDO) {
            $sql = "CREATE TABLE `tbl_user_profile` (
  `id` bigint(20) unsigned NOT NULL,
  `data` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
            $this->pdo->exec($sql);
            $demo_user_profile = array(
                'user_id'    => 1,
                'first_name' => 'Davis',
                'last_name'  => 'Zeng',
                'email'      => 'daviszeng@outlook.com',
            );
            $id                = 1;
            $data              = json_encode($demo_user_profile);
            $sql               = "INSERT INTO `tbl_user_profile` VALUES (:id, :data)";
            $stmt              = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':data', $data);
            $stmt->execute();
        } else {
            $this->assertTrue(false);
        }
    }

    public function testSet()
    {
        $user_profile = array(
            'user_id'    => 100,
            'first_name' => 'Ray',
            'last_name'  => 'Chen',
            'email'      => 'RayChen@qq.com',
        );
        $bool         = UserProfileCacheModel::model()->setKey($this->key)->fromArray($user_profile)->save();
        $this->assertTrue($bool);
    }

    /**
     *
     * @depends testSet
     *
     * @author  : De-Wu Zeng <dewuzeng@gmail.com>
     */
    public function testGet()
    {
        $user_profile = UserProfileCacheModel::model()->get($this->key);
        $this->assertEquals('RayChen@qq.com', $user_profile['email']);
    }

    /**
     *
     * @depends testSet
     *
     * @author  : De-Wu Zeng <dewuzeng@gmail.com>
     */
    public function testDelete()
    {
        UserProfileCacheModel::model()->delete($this->key);
        $user_profile = UserProfileCacheModel::model()->get($this->key);
        $this->assertFalse($user_profile);
    }

    public function tearDown()
    {
        if ($this->pdo instanceof \PDO) {
            $this->pdo->exec('DROP TABLE `tbl_user_profile`');
        }
    }

}