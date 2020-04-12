<?php

namespace Mail;

interface SmtpInterface
{
  public function getHost();
  public function getPort();
  public function getAuth();
  public function getSecurityOption();
}


 ?>
