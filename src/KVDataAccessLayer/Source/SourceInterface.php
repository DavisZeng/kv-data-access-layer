<?php
namespace KVDataAccessLayer\Source;

/**
 * @filename SourceInterface.php
 * @touch    1/20/16 17:21
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */
interface SourceInterface
{
    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $key
     * @param $value
     *
     * @return mixed
     */
    public function set($key, $value);

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $key
     *
     * @return mixed
     */
    public function delete($key);
}