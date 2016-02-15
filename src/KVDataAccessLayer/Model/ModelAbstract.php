<?php
/**
 * @filename ModelAbstract.php
 * @touch    1/20/16 17:31
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Model;

abstract class ModelAbstract implements \ArrayAccess
{
    /**
     * @var array
     */
    protected static $fields = array();

    /**
     * @var bool
     */
    private $dirty = false;

    /**
     * @var string
     */
    private $keyName;

    public abstract function save();

    public abstract function get($key);

    public abstract function delete($key);


    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return static
     */
    public static function model()
    {
        return new static;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return mixed|string
     */
    public function keyName()
    {
        if (!$this->keyName) {
            $this->keyName = key(static::$fields);
        }

        return $this->keyName;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $keyName        = $this->keyName();
        $this->$keyName = $key;
        $this->dirty    = true;

        return $this;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return mixed
     */
    public function getKey()
    {
        $keyName = $this->keyName();

        return $this->$keyName;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return bool
     */
    public function isDirty()
    {
        return $this->dirty;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param $bool
     *
     * @return $this
     */
    public function setDirty($bool)
    {
        $this->dirty = $bool;

        return $this;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     * @return array
     */
    public function toArray()
    {
        return static::$fields;
    }

    /**
     *
     * @author: De-Wu Zeng <dewuzeng@gmail.com>
     *
     * @param array $data
     *
     * @return $this
     */
    public function fromArray(Array $data)
    {
        foreach ($data as $key => $value) {
            if (isset(static::$fields[$key])) {
                static::$fields[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Whether a offset exists
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset(static::$fields[$offset]);
    }

    /**
     * Offset to retrieve
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return isset(static::$fields[$offset]) ? static::$fields[$offset] : NULL;
    }

    /**
     * Offset to set
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === NULL) {
            static::$fields[] = $value;
        } else {
            static::$fields[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        if (isset(static::$fields[$offset])) {
            unset(static::$fields[$offset]);
        }
    }


}
