<?php
/**
 * @filename MySQLSource.php
 * @touch    1/21/16 15:20
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Source;

use KVDataAccessLayer\Model\ModelAbstract;

class MySQLSource implements SourceInterface
{
    /**
     * @var \KVDataAccessLayer\Model\ModelAbstract
     */
    private $model;

    public function __construct(ModelAbstract $model)
    {
        $this->model = $model;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->model->setKey($key)->fromArray($value)->save();
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
        return $this->model->get($key);
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $key
     *
     * @return mixed
     */
    public function delete($key)
    {
        return $this->model->delete($key);
    }
}