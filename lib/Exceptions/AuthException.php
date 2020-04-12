<?php
namespace Exceptions;
class AuthException extends \Exception implements \MyExceptionInterface
{
  const USER_NOT_EXIST = 100;
  const WRONG_PASSWORD = 101;

  public static function message($key)
  {
    switch ($key)
    {
      case 'email_not_exist':
        return _("Email not exist");
      case 'password_mismatch':
        return _("Password mismatch");
      default:
        return _("Authorization error");
    }
  }

  public function getPublicMessage()
  {
    return $this->getMessage();
  }
}

 ?>
