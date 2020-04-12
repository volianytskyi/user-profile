<?php

namespace Payment\Paypal;

interface FormInterface
{
  public function getActionUrl();
  public function getReceiverEmail();
  public function getReturnUrl();
  public function getCmd();
}

 ?>
