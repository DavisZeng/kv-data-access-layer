<?php
/**
 * @filename UserProfileCacheModel.php
 * @touch    1/28/16 13:42
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\TestModel;


use KVDataAccessLayer\Configure\ConfigureCenter;
use KVDataAccessLayer\Connection\ConnectionManager;
use KVDataAccessLayer\Model\CacheModel;
use KVDataAccessLayer\Source\MySQLSource;

class UserProfileCacheModel extends CacheModel
{

    protected static $fields = array(
        'user_id'    => 0,
        'first_name' => '',
        'last_name'  => '',
        'email'      => '',
    );

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return \KVDataAccessLayer\Cache\CacheInterface
     */
    public function cache()
    {
        $user_profile_cache_config = ConfigureCenter::singleton()->get('kvdal.user_profile_cache');
        if (!self::$cache) {
            self::$cache = ConnectionManager::singleton()->mem($user_profile_cache_config);
        }

        return self::$cache;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return MySQLSource
     */
    protected function source()
    {
        return new MySQLSource(UserProfileLBDBModel::model());
    }
}