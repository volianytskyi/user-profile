<?php

namespace Exceptions;

class ModelException extends \Exception implements \MyExceptionInterface
{
  const DATA_MISMATCH = 100;
  const DATA_NOT_ENOUGH = 101;


  public function getPublicMessage()
  {
    switch ($this->getCode())
    {
      default:
        return _("Model object processing error");
    }
  }
}

 ?>
