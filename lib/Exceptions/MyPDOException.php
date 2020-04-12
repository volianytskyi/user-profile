<?php

namespace Exceptions;

class MyPDOException extends \Exception implements \MyExceptionInterface
{
  public function getPublicMessage()
  {
    return _("Database error. Please, contact website administrator");
  }
}

 ?>
