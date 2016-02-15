<?php
/**
 * @filename UserLBDBModel.php
 * @touch    1/26/16 13:20
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\TestModel;


use KVDataAccessLayer\Configure\ConfigureCenter;
use KVDataAccessLayer\Connection\ConnectionManager;
use KVDataAccessLayer\Model\LBDBModel;

class UserProfileLBDBModel extends LBDBModel
{


    protected static $fields = array(
        'user_id'    => 0,
        'first_name' => '',
        'last_name'  => '',
        'email'      => '',
    );

    public function pdos()
    {
        if (self::$pdos === array()) {
            $user_profile_lbdb_config = ConfigureCenter::singleton()->get('kvdal.user_profile_lbdb');
            self::$pdos               = ConnectionManager::singleton()->pdos($user_profile_lbdb_config);
        }

        return self::$pdos;
    }

    protected function tableName()
    {
        return 'tbl_user_profile';
    }
}