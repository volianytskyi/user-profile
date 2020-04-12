<?php

namespace Exceptions;

class ViewException extends \Exception implements \MyExceptionInterface
{
  public function getPublicMessage()
  {
    if(DEBUG === true)
    {
      return $this->getMessage();
    }
    return _("Unable to render the page. Please, contact website administrator.");
  }
}

 ?>
