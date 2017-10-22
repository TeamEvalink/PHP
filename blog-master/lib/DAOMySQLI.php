<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/4/29
 * Time: 22:05
 */
class DAOMySQLI{
    private $host;
    private $user;
    private $pwd;
    private $port;
    private $dbname;
    private $charset;
    private $mysqli;

    private static $instance;
    private function __construct(array $configure)
    {
        $this->initOpiton($configure);
        $this->initmysqli($configure);
    }
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
    public static function Single(array $configure = array())
    {
        if(!(self::$instance instanceof self))
        {
            self::$instance = new self($configure);
        }
        return self::$instance;
    }
    private function initmysqli(array $configure=[])
    {
        $this->mysqli = new mysqli($this->host,$this->user,$this->pwd,$this->dbname,$this->port);
        if($this->mysqli->errno)
        {
            die('连接失败' . $this->mysqli->connect_error);
        }
        $this->mysqli->set_charset($this->charset);
    }
    private function initOpiton(array $configure)
    {
        $this->host  = isset($configure['host']) ? $configure['host'] : 'localhost';
        $this->user  = isset($configure['user']) ? $configure['user'] : 'root';
        $this->pwd   = isset($configure['pwd'])  ? $configure['pwd']  : 'root';
        $this->dbname= isset($configure['dbname']) ? $configure['dbname'] : 'blog';
        $this->port  = isset($configure['port']) ? $configure['port'] : '3306';
        $this->charset=isset($configure['charset']) ? $configure['charset'] : 'utf8';
    }
   public function query($sql ='')
    {
        $res = $this->mysqli->query($sql);
        if(!$res)
        {
            die('查询失败');
        }
        return $res;
    }
    public function fetchAll($sql='')
    {
        $res = $this->query($sql);
        $arr = array();
        while($row = $res->fetch_assoc())
        {
            $arr[] = $row;
        }
        $res->free();
        return $arr;
    }

    public function fetchRow($sql ='')
    {
        $res = $this->query($sql);
        $row = $res->fetch_array(MYSQLI_ASSOC);
        $res->free();
        return $row ? $row : false;
    }
}