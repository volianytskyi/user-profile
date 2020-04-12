<?php

namespace Mail;

class OnlineNetSmtp implements SmtpInterface
{
  public function getHost()
  {
    return 'smtp.online.net';
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
