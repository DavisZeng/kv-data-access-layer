<?php
/**
 * @filename LBDBModelException.php
 * @touch    1/21/16 14:26
 * @author   De-Wu Zeng <dewuzeng@gmail.com>
 * @version  1.0.0
 */

namespace KVDataAccessLayer\Exception;


class DBModelException extends KVDALException
{
    /**
     * @var mixed the error info provided by a PDO exception. This is the same as returned
     * by {@link http://www.php.net/manual/en/pdo.errorinfo.php PDO::errorInfo}.
     */
    public $errorInfo;

    /**
     * Constructor.
     *
     * @param string  $message   PDO error message
     * @param integer $code      PDO error code
     * @param mixed   $errorInfo PDO error info
     */
    public function __construct($message, $code = 0, $errorInfo = NULL)
    {
        $this->errorInfo = $errorInfo;
        parent::__construct($message, $code);
    }
}
