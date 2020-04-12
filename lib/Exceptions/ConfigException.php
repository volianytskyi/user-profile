<?php

namespace Exceptions;

class ConfigException extends \Exception implements \MyExceptionInterface
{
  const CANNOT_READ = 100;
  const PARAM_NOT_DEFINED = 101;

  public function getPublicMessage()
  {
    switch ($this->getCode())
    {
      default:
        return _("Server configuration error");
    }
  }
}

 ?>
