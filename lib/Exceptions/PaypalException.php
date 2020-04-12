<?php

namespace Exceptions;

class PaypalException extends \Exception implements \MyExceptionInterface
{
  const CERT = 100;
  const MISSING_POST_DATA = 101;
  const CURL = 102;

  public function getPublicMessage()
  {
    switch ($this->getCode())
    {
      default:
        return _("Paypal processing error");
    }
  }
}

 ?>
