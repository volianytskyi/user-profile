<?php

class CSRF
{
  public static function createToken()
  {
    $token = sha1(CSRF_SALT.time());
    $_SESSION[CSRF_TOKEN_KEY] = $token;
    return $token;
  }

  public static function checkToken()
  {
    if(!isset($_POST[CSRF_TOKEN_KEY], $_SESSION[CSRF_TOKEN_KEY]) || $_SESSION[CSRF_TOKEN_KEY] !== UserInput::filterString($_POST[CSRF_TOKEN_KEY]))
    {
      error_log("CSRF token check failed");
      Route::redirect('/logout');
    }
  }




}

 ?>
