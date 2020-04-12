<?php

namespace Exceptions;

class NotFoundException extends \Exception implements \MyExceptionInterface
{
  const NOT_FOUND_IN_DATABASE = 100;
  const USER_NOT_EXIST = 101;

  public function getPublicMessage()
  {
    switch ($this->getCode())
    {
      case self::NOT_FOUND_IN_DATABASE:
        return _("There is no required data in database");

      case self::USER_NOT_EXIST:
        return _("User does not exist in the database");

      default:
        return _("Required data not found");
    }
  }
}

 ?>
