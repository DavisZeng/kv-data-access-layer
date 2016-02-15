<?php
/**
 * @filename LBDBModel.php
 * @touch    1/21/16 14:24
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Model;

use KVDataAccessLayer\Exception\DBModelException;

abstract class LBDBModel extends ModelAbstract
{
    public static $pdos = array();

    abstract public function pdos();

    protected function tableName()
    {
        return strtolower(get_class($this));
    }

    protected function index($key)
    {
        $defaultValue = static::$fields[$this->keyName()];
        $key          = is_int($defaultValue) ? (int)$key : crc32($key);

        return $key % count($this->pdos());
    }

    public function save()
    {
        $pdos = $this->pdos();
        $pdo  = $pdos[$this->index($this->keyName())];

        $sql = 'REPLACE INTO ' . $this->tableName() . ' (id, data) VALUES (:key, :value)';
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array('key' => $this->getKey(), 'value' => json_encode($this->toArray())));

            return $stmt->rowCount();
        } catch (\Exception $e) {
            $errorInfo = $e instanceof \PDOException ? $e->errorInfo : NULL;
            $message   = 'Failed to save the SQL statement, error: ' . $e->getMessage();
            throw new DBModelException($message, (int)$e->getCode(), $errorInfo);
        }
    }

    public function get($key)
    {
        $pdos = $this->pdos();
        $pdo  = $pdos[$this->index($this->keyName())];

        $sql = 'SELECT * FROM ' . $this->tableName() . ' WHERE id = :key';
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array('key' => $key));
        } catch (\Exception $e) {
            $errorInfo = $e instanceof \PDOException ? $e->errorInfo : NULL;
            $message   = 'Failed to get the SQL statement, error: ' . $e->getMessage();
            throw new DBModelException($message, (int)$e->getCode(), $errorInfo);
        }

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (is_array($result)) {
            $this->fromArray(json_decode($result['data'], true))->setDirty(false);

            return $this;
        }

        return false;
    }

    public function delete($key)
    {
        $pdos = $this->pdos();
        $pdo  = $pdos[$this->index($this->keyName())];

        $sql = 'DELETE FROM ' . $this->tableName() . ' WHERE id = :key';
        try {

            $stmt = $pdo->prepare($sql);
            $stmt->execute(array('key' => $key));
        } catch (\Exception $e) {
            $errorInfo = $e instanceof \PDOException ? $e->errorInfo : NULL;
            $message   = 'Failed to delete the SQL statement, error: ' . $e->getMessage();
            throw new DBModelException($message, (int)$e->getCode(), $errorInfo);
        }

        return true;
    }


}