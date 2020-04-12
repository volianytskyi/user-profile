<?php


function classRegister($class)
{
  //error_log($class);
  $classFile = '';
  $app = __DIR__ . '/../app/' . $class . '.php';
  $lib = __DIR__ . '/../lib/' . $class . '.php';

  if(preg_match('~.+Model$~', $class))
  {
    $classFile = __DIR__ . '/../app/models/' . $class . '.php';
  }
  elseif (preg_match('~.+View$~', $class))
  {
    $classFile = __DIR__ . '/../app/views/' . $class . '.php';
  }
  elseif (preg_match('~.+Controller$~', $class))
  {
    $classFile = __DIR__ . '/../app/controllers/' . $class . '.php';
  }
  elseif(strpos($class, '\\') !== false)
  {
    $class = str_replace('\\', "/", $class);
    $classFile = __DIR__ . '/../lib/' . $class . ".php";
  }

  if(file_exists($app))
  {
    $classFile = $app;
  }
  elseif (file_exists($lib))
  {
    $classFile = $lib;
  }

  require_once($classFile);

}

spl_autoload_register('classRegister');


 ?>
