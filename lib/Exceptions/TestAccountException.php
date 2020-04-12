<?php

namespace Exceptions;

class TestAccountException extends \Exception implements \MyExceptionInterface
{
  const LIMIT_REACHED = 100;

  public static function message($key)
  {
    switch ($key)
    {
      case 'limit_reached':
        return _("You can't add more test accounts");
      default:
        return _("Unable to create test account");
    }
  }

  public function getPublicMessage()
  {
    switch ($this->getCode())
    {
      case self::LIMIT_REACHED:
        return $this->getMessage();

      default:
        return self::message(null);
    }
  }
}

 ?>
