<?php

use Exceptions\MyPDOException;
use Core\MyPDO;
class MyPDOFactory
{
  public static function create()
  {
    $config = __DIR__ . '/../config/database.php';
    if(!file_exists($config))
    {
      throw new MyPDOException("$config does not exist", 1);
    }

    $credits = require $config;

    return new MyPDO($credits['type'], $credits['host'], $credits['name'], $credits['user'], $credits['pass'], $credits['charset']);
  }
}


 ?>
