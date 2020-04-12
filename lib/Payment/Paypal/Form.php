<?php

namespace Payment\Paypal;

class Form implements FormInterface
{
  private $cmd;
  private $returnUrl;
  private $receiverEmail;
  private $actionUrl;

  public function __construct($cmd, $returnUrl, $receiverEmail, $actionUrl)
  {
    $this->setCmd($cmd);
    $this->setReturnUrl($returnUrl);
    $this->setReceiverEmail($receiverEmail);
    $this->setActionUrl($actionUrl);
  }

  public function setCmd($cmd)
  {
    $allowedCmd = [
      '_xclick',
      '_cart',
      '_xclick-subscriptions',
      '_xclick-auto-billing',
      '_xclick-payment-plan',
      '_donations',
      '_s-xclick',
    ];
    if(in_array($cmd, $allowedCmd))
    {
      $this->cmd = $cmd;
    }
  }

  public function setReturnUrl($url)
  {
    $this->returnUrl = filter_var($url, FILTER_VALIDATE_URL);
  }

  public function setActionUrl($url)
  {
    $this->actionUrl = filter_var($url, FILTER_VALIDATE_URL);
  }

  public function setReceiverEmail($email)
  {
    $this->receiverEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  public function getActionUrl()
  {
    return $this->actionUrl;
  }

  public function getReceiverEmail()
  {
    return $this->receiverEmail;
  }

  public function getReturnUrl()
  {
    return $this->returnUrl;
  }

  public function getCmd()
  {
    return $this->cmd;
  }
}

 ?>
