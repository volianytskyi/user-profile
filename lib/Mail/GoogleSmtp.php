<?php

namespace Mail;

class GoogleSmtp implements SmtpInterface
{
  public function getHost()
  {
    return 'smtp.gmail.com';
  }

  public function getPort()
  {
    return 587;
  }

  public function getAuth()
  {
    return true;
  }

  public function getSecurityOption()
  {
    return 'tls';
  }

}

 ?>
