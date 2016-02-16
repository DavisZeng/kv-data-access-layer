<?php
/**
 * @filename UserLBDBModelTest.php
 * @touch    1/26/16 13:31
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Tests;

use KVDataAccessLayer\TestModel\UserProfileLBDBModel;

class UserProfileLBDBModelTest extends \PHPUnit_Framework_TestCase
{
    protected $pdo;

    public function setUp()
    {
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

    public function testGet()
    {
        $user = UserProfileLBDBModel::model()->get(1)->toArray();
        $this->assertTrue(isset($user['email']));
        $this->assertEquals('daviszeng@outlook.com', $user['email']);
    }

    public function testSave()
    {
        $attributes = array(
            'user_id'    => 2,
            'first_name' => 'Star',
            'last_name'  => 'Jiang',
            'email'      => 'StarJiang@qq.com',
        );
        UserProfileLBDBModel::model()->setKey(2)->fromArray($attributes)->save();
        $user = UserProfileLBDBModel::model()->get(2)->toArray();
        $this->assertTrue(isset($user['email']));
        $this->assertEquals('StarJiang@qq.com', $user['email']);
    }

    public function testDelete()
    {

        $attributes = array(
            'user_id'    => 3,
            'first_name' => 'Lily',
            'last_name'  => 'Leo',
            'email'      => 'LilyLeo@qq.com',
        );
        UserProfileLBDBModel::model()->setKey(3)->fromArray($attributes)->save();
        $user = UserProfileLBDBModel::model()->get(3);
        $this->assertEquals('LilyLeo@qq.com', $user['email']);
        $bool = UserProfileLBDBModel::model()->delete(3);
        $this->assertTrue($bool);
        $user = UserProfileLBDBModel::model()->get(3);
        $this->assertFalse($user === array());
    }

    public function tearDown()
    {
        $this->pdo->exec('DROP TABLE `tbl_user_profile`');
    }
}