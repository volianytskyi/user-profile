<?php

use Exceptions\ConfigException;

class Config
{
  private $file;

  private static $instance = null;

  private function __construct()
  {
    $file = __DIR__.'/../config/config.ini';
    if(!is_readable($file))
    {
      throw new ConfigException("Cannot read $file", ConfigException::CANNOT_READ);
    }
    $this->file = $file;
  }

  private function __clone() {}

  public static function get($param, $default = null)
  {
    $config = self::getInstance();
    $params = parse_ini_file($config->file);
    if(isset($params[$param]))
    {
      return $params[$param];
    }
    elseif ($default !== null)
    {
      return $default;
    }
    throw new ConfigException("$param not defined", ConfigException::PARAM_NOT_DEFINED);
  }

  public static function getSection($section)
  {
    $config = self::getInstance();
    $params = parse_ini_file($config->file, true);
    if(isset($params[$section]))
    {
      return $params[$section];
    }
    return self::get($section);
  }

  private static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new self();
    }
    return self::$instance;
  }

}

 ?>
