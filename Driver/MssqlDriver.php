<?php

/**
 * Created by PhpStorm.
 * User: Lucas Milin
 */

namespace MSSQLAbstractLayer\Driver;


/**
 * Class MssqlDriver
 * @package MSSQLAbstractLayer\Driver
 */
class MssqlDriver
{
    /**
     * @param $server
     * @param $database
     * @param $user
     * @param $password
     * @return false|resource
     * @throws \Exception
     */
    public function connect($server, $database, $user, $password)
    {
        $conn = mssql_connect($server, $user, $password);

        if (!conn){
            throw new \Exception('Unable to connect!');
        }
        if (!mssql_select_db($database, $conn)){
            throw new \Exception('Unable to select database!');
        }

        return $conn;
    }

    /**
     * @param $sql
     * @return bool|null|resource
     * @throws \Exception
     */
    public function query($sql, $conn = null)
    {
        $stmt = mssql_query($sql, $conn);

        return $stmt;
    }

    /**
     * @param $stmt
     */
    public function getResult($stmt)
    {
        $result = array();

        while ($row = mssql_fetch_array($stmt)) {
            $result[] = $row;
        }

        mssql_free_result($stmt);


        return $result;
    }
}