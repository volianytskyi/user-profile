<?php

namespace Exceptions;

class DeviceRegistrationException extends \Exception implements \MyExceptionInterface
{
  const MAC_HASH_MISMATCH = 100;
  const CUSTOM_HASH_MISMATCH = 101;


  public function getPublicMessage()
  {
    switch ($this->getCode())
    {
      default:
        return _("Device registration failed");
    }
  }
}

 ?>
