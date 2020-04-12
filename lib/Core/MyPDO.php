<?php

use Exceptions\MyPDOException;

namespace Core;
use \PDO;
class MyPDO implements \DatabaseInterface
{
  private $type;
  private $host;
  private $name;
  private $charset;
  private $user;
  private $pass;
  private $options;

  public function __construct($type, $host, $name, $user, $pass, $charset)
  {
    $this->type = $type;
    $this->host = $host;
    $this->name = $name;
    $this->charset = $charset;
    $this->user = $user;
    $this->pass = $pass;
    $this->options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
  }

  private function connect()
  {
    $dsn = "$this->type:host=$this->host;dbname=$this->name;charset=$this->charset";
    return new PDO($dsn, $this->user, $this->pass, $this->options);
  }

  public function delete($table, $key, $value)
  {
    $this->ensureTableExists($table);
    $sql = "DELETE FROM `$table` WHERE `$key` = :$key";
    $this->execute($sql, self::serializeData([$key => $value]));
  }

  public function insert($table, array $data)
  {
    $this->ensureTableExists($table);
    $columns = implode(",", array_keys($data));
    $values = [];
    foreach($data as $index => $value)
    {
      $values[] = ":".$index;
    }
    $values = implode(",", $values);
    $sql = "INSERT INTO `$table`($columns) VALUES($values)";
    return $this->execute($sql, self::serializeData($data), true);
  }

  public function update($table, array $data, $key = 'id')
  {
    $this->ensureTableExists($table);
    if(!isset($data[$key]))
    {
      throw new MyPDOException("Unable to update $table: data array does not contain $key");
    }
    $sql = "UPDATE `$table` SET ";
    foreach(array_keys($data) as $index)
    {
      if($index != $key)
      {
        $sql .= "$index = :$index,";
      }
    }
    $sql = rtrim($sql, ",");
    $sql .= " WHERE $key = :$key";

    $values = self::serializeData($data);

    $this->execute($sql, $values);
  }

  public function insertOrUpdate($table, array $data, array $keys = ['id'])
  {
    $this->ensureTableExists($table);
    $columns = implode(",", array_keys($data));
    $values = [];
    foreach($data as $index => $value)
    {
      $values[] = ":".$index;
    }
    $values = implode(",", $values);
    $sql = "INSERT INTO `$table`($columns) VALUES($values) ON DUPLICATE KEY UPDATE ";
    foreach(array_keys($data) as $column)
    {
      if(!in_array($column, $keys))
      {
        $sql .= "$column=VALUES($column),";
      }
    }
    $sql = rtrim($sql,",");
    return $this->execute($sql, self::serializeData($data), true);
  }

  public function execute($query, $args = [], $isInsert = false)
  {
    $connection = $this->connect();
    $stn = $connection->prepare($query);
    $stn->execute($args);
    if($isInsert)
    {
      return $connection->lastInsertId();
    }
    return $stn;
  }

  public function fetch($query, $args = [])
  {
    return $this->execute($query, $args)->fetch();
  }

  public function fetchAll($query, $args = [])
  {
    return $this->execute($query, $args)->fetchAll();
  }

  public function fetchColumn($query, $args = [])
  {
    return $this->execute($query, $args)->fetchColumn();
  }

  static public function createPlaceholders(array $args)
  {
    $placeholders = [];
    for($i = 0; $i < count($args); $i++)
    {
      $placeholders[$i] = '?';
    }
    return implode(",", $placeholders);
  }

  private function tableExists($table)
  {
    $data = $this->fetchAll("SHOW TABLES FROM ".$this->name);
    $tables = array_column($data, 'Tables_in_'.$this->name);
    (in_array($table, $tables)) ? $res = true : $res = false;
    return $res;
  }

  static private function serializeData($data)
  {
    $serialized = [];
    foreach($data as $key => $value)
    {
      $serialized[":".$key] = $value;
    }
    return $serialized;
  }

  private function ensureTableExists($table)
  {
    if(!$this->tableExists($table))
    {
      throw new MyPDOException("Update error: $table does not exist");
    }
  }
}

 ?>
