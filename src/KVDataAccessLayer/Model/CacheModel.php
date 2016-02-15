<?php
/**
 * @filename CacheModel.php
 * @touch    1/21/16 16:43
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Model;

abstract class CacheModel extends ModelAbstract
{
    /**
     * @var null
     */
    public $keyPrefix = NULL;

    /**
     * @var bool
     */
    public $hashKey = true;

    /**
     * @var int
     */
    protected $persist = 1;

    /**
     * @var \KVDataAccessLayer\Cache\CacheInterface;
     */
    protected static $cache;

    /**
     * @var \KVDataAccessLayer\Source\SourceInterface;
     */
    protected $source;

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return \KVDataAccessLayer\Cache\CacheInterface
     */
    public abstract function cache();

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return bool
     */
    protected function persist()
    {
        return $this->persist;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return \KVDataAccessLayer\Source\SourceInterface
     */
    protected function source()
    {
        return false;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return bool
     */
    protected function queue()
    {
        return false;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return bool
     */
    protected function delay()
    {
        return false;
    }


    protected function getKeyPrefix()
    {
        if (!$this->keyPrefix) {
            $this->keyPrefix = strtolower(get_called_class());
        }

        return $this->keyPrefix;
    }

    protected function generateUniqueKey($key)
    {
        $this->setKey($key);
        $keyPrefix = $this->getKeyPrefix();

        return $this->hashKey ? md5($keyPrefix . $key) : $keyPrefix . $key;
    }

    public function save()
    {
        $key   = $this->getKey();
        $value = $this->toArray();

        if ($this->persist() && $this->source()) {
            $this->source()->set($key, $value);
        }

        $this->cache()->set($this->generateUniqueKey($key), json_encode($value));

        return true;
    }

    public function get($key)
    {
        $value = $this->cache()->get($this->generateUniqueKey($key));
        if ($value !== false) {
            $this->fromArray(json_decode($value, true))->setDirty(false);

            return $this;
        } else {
            if ($this->persist() && $this->source()) {
                $value = $this->source()->get($key);
                if ($value !== false) {
                    $this->fromArray($value)->setDirty(false);
                    $this->source()->set($this->generateUniqueKey($key), json_encode($value));

                    return $this;
                }
            }

            $this->setDirty(false);

            return false;
        }
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $key
     *
     * @return bool|mixed
     */
    public function delete($key)
    {
        if ($this->cache()->delete($this->generateUniqueKey($key))) {
            if ($this->persist() && $this->source()) {
                return $this->source()->delete($key);
            }

            return true;
        }

        return false;
    }
}