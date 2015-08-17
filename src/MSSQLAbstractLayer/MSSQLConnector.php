<?php

/**
 * Created by PhpStorm.
 * User: Lucas Milin
 */

namespace MSSQLAbstractLayer;

use MSSQLAbstractLayer\Driver\MssqlDriver;
use MSSQLAbstractLayer\Driver\SqlsrvDriver;

/**
 * Class Connection
 * @package MSSQLAbstractLayer
 */
class MSSQLConnector
{
    /**
     * @var string
     */
    private $server;

    /**
     * @var string
     */
    private $database;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var false|resource
     */
    private $conn;

    /**
     * @var string
     */
    private $driver;

    /**
     * @var string
     */
    private $object;

    /**
     * @param $server
     * @param $database
     * @param $user
     * @param $password
     * @param $driver
     */
    public function __construct($server, $database, $user, $password, $driver)
    {
        $this->server = $server;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->driver = $driver;

        switch($this->driver) {
            case 'sqlsrv':
                $this->object = new SqlsrvDriver();
                break;
            case 'mssql':
                $this->object = new MssqlDriver();
                break;
            default:
                $this->object = new MssqlDriver();
                break;
        }

        $this->conn = $this->object->connect($this->server, $this->database, $this->user, $this->password);

    }

    /**
     * @param $sql
     */
    public function query($sql)
    {
        return $this->object->query($sql, $this->conn);
    }


    /**
     * @param $query
     *
     * @return array
     */
    public function fetch($query)
    {
        return $this->object->getResult($query);
    }

    /**
     * @param $query
     *
     * @return array
     */
    public function fetchAll($query)
    {
        return $this->object->getResults($query);
    }

    /**
     * @return mixed
     */
    public function getLastInsertId()
    {
        return $this->object->getLastInsertId($this->conn);
    }

}