<?php

session_start();
try {
  
  require_once __DIR__ . '/../config/common.php';

  if(DEBUG === true)
  {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
  }

  require_once __DIR__ . '/../config/autoload.php';

  $route = new Route();
  $route->run();

}
catch(MyExceptionInterface $e)
{
  $error = $e->getMessage() . PHP_EOL . $e->getTraceAsString();
  error_log($error);
  $controller = new ErrorController($e->getPublicMessage());
  $controller->actionDisplay();
}
catch(Exception $e)
{
  $error = $e->getMessage() . PHP_EOL . $e->getTraceAsString();
  error_log($error);
  $controller = new ErrorController('Unexpected error occured');
  $controller->actionDisplay();
}





 ?>
