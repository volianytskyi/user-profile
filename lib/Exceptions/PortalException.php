<?php

namespace Exceptions;

class PortalException extends \Exception implements \MyExceptionInterface
{
  const INCORRECT_PROPERTY_VALUE = 100;

  public function getPublicMessage()
  {
    switch ($this->getCode())
    {
      case self::INCORRECT_PROPERTY_VALUE:
        return _("Incorrect portal property value");

      default:
        return _("Middleware setup error");
    }
  }
}

 ?>
