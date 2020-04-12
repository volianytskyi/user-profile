<?php

namespace Exceptions;

class RegistrationException extends \Exception implements \MyExceptionInterface
{
  const ALREADY_REGISTERED = 100;
  const TOKEN_EXPIRED = 101;
  const MAIL_SENDER_NOT_INITED = 102;

  public function getPublicMessage()
  {
    switch ($this->getCode())
    {
      case self::ALREADY_REGISTERED:
        return sprintf(_("User with such e-mail %s is already regisered. Please, sign in."), $this->getMessage());

      case self::TOKEN_EXPIRED:
        return _("Temporary link was expired. Please, register again.");

      case self::MAIL_SENDER_NOT_INITED:
        return _("Inner server error.");

      default:
        return _("Registration processing error");
    }
  }
}

 ?>
