<?php

/**
 * Created by PhpStorm.
 * User: Lucas Milin
 */

namespace MSSQLAbstractLayer\Driver;

/**
 * Class SqlsrvDriver
 * @package MSSQLAbstractLayer\Driver
 */
class SqlsrvDriver
{
    /**
     * @param $server
     * @param $database
     * @param $user
     * @param $password
     * @return false|resource
     * @throws \Exception
     */
    public function connect($server, $database, $user, $password, $charset)
    {
        $connectionInfo = array( "Database"=>$database, "UID"=>$user, "PWD"=>$password, "CharacterSet" => $charset);
        $conn = sqlsrv_connect( $server, $connectionInfo);

        if( $conn === false ) {
            throw new \Exception( sqlsrv_errors());
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
        $stmt = sqlsrv_query($conn, $sql);

        if ($stmt === false) {
            throw new \Exception(sqlsrv_errors());
        }

        return $stmt;
    }

    /**
     * @param $stmt
     */
    public function getResults($stmt)
    {
        $result = array();

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $result[] = $row;
        }

        return $result;
    }

    public function getResult($stmt)
    {
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $result;
    }

    /**
     * @param $conn
     *
     * @return mixed
     */
    public function getLastInsertId($conn)
    {
        $stmt = sqlsrv_query($conn, 'SELECT SCOPE_IDENTITY() AS id');
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        return $result['id'];
    }
}
