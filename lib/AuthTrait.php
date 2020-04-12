<?php

use Exceptions\AuthException;

trait AuthTrait
{
  public static function getByEmail($email)
  {
    $args = [
      'email' => UserInput::validateEmail($email)
    ];
    $table = static::table();
    return static::db()->fetch("SELECT * FROM `$table` WHERE `email` = :email", $args);
  }


  public static function check($email, $pass)
  {
    $user = self::getByEmail($email);

    if(empty($user) || !isset($user['email'], $user['password']))
    {
      throw new AuthException(AuthException::message('email_not_exist'), AuthException::USER_NOT_EXIST);
    }

    $password = new UserPassword($pass);

    if(!$password->verify($user['password'], $pass))
    {
      throw new AuthException(AuthException::message('password_mismatch'), AuthException::WRONG_PASSWORD);
    }

    return $user;
  }
}


 ?>
