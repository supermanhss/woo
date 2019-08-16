<?php

namespace woo\process;

use woo\base\register\ApplicationRegister;

abstract class Base
{
    static $DB;
    static $stmts = [];

    public function __construct()
    {
        $dsn = ApplicationRegister::getDsn();
        $dbUsername = ApplicationRegister::getDbUsername();
        $dbPassword = ApplicationRegister::getDbPassword();

        if (! $dsn || ! $dbUsername || ! $dbPassword) {
            exit('no dsn or no db_username or no db_password');
        }

        self::$DB = new \PDO($dsn, $dbUsername, $dbPassword);
        self::$DB->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param $stmt_s
     * @return \PDOStatement
     */
    public function prepareStatement($stmt_s)
    {
        if (isset(self::$stmts[$stmt_s])) {
            return self::$stmts[$stmt_s];
        }

        $stmt_handle = self::$DB->prepare($stmt_s);
        self::$stmts[$stmt_s] = $stmt_handle;
        return $stmt_handle;
    }

    protected function doStatement($stmt_s, $values_a)
    {
        $sth = $this->prepareStatement($stmt_s);
        $sth->closeCursor();

        $db_result = $sth->execute($values_a);
        return $sth;
    }
}
