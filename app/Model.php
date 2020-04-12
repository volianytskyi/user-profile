<?php

use Exceptions\ModelException;

abstract class Model
{

  protected $data;

  final public function getData()
  {
    return $this->data;
  }

  public function setTrustedData(array $data)
  {
    $this->data = $data;
    return $this;
  }

  public function __construct()
  {
    $this->data = [];
  }

  protected static function table()
  {
    ($pos = strrpos(get_called_class(), '\\'))
      ? $fullClassName = substr(get_called_class(), $pos + 1)
      : $fullClassName = get_called_class();

    return strtolower(str_replace('_Model', '', ltrim(preg_replace("~[A-Z]~", "_$0", $fullClassName), "_")) . 's');
  }

  final protected static function db()
  {
    $factory = DB_FACTORY;
    $method = DB_FACTORY_METHOD;
    return $factory::$method();
  }

  public static function getAll()
  {
    $table = static::table();
    return self::db()->fetchAll("SELECT * FROM `$table`");
  }

  public static function getById($id)
  {
    $table = static::table();
    $sql = "SELECT * FROM `$table` WHERE id = :id";
    $args = [
      'id' => UserInput::filterInt($id)
    ];
    return static::db()->fetch($sql, $args);
  }

  public static function getFieldsAll(array $fields)
  {
    $columns = implode(',', array_map(function($column){
      return '`'.UserInput::filterString($column).'`';
    }, $fields));
    $table = static::table();
    return self::db()->fetchAll("SELECT $columns FROM `$table`");
  }

  public static function deleteById($id)
  {
    return self::db()->delete(static::table(), 'id', UserInput::filterInt($id));
  }

  public static function save(Model $model)
  {
    if(get_class($model) != get_called_class())
    {
      throw new ModelException(get_class($model) ." does not match ". get_called_class(), ModelException::DATA_MISMATCH);
    }

    return self::db()->insertOrUpdate(static::table(), $model->getData());
  }


}


 ?>
