<?php

namespace Exceptions;

class PermissionException extends \Exception implements \MyExceptionInterface
{
  const FOREIGN_DEVICE = 100;

  public function getPublicMessage()
  {
    switch ($this->getCode())
    {
      case self::FOREIGN_DEVICE:
        return _("No access to this user device");

      default:
        return _("No Access");
    }
  }
}

 ?>
