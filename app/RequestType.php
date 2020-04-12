<?php

class RequestType
{
  public static function isAjax()
  {
    return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' );
  }
}

 ?>
