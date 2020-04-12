<?php

namespace Payment\Paypal;

use \Config;

class PayNow
{
  protected $form;

  public function __construct($sandbox = false)
  {
    if($sandbox == true)
    {
      $this->setSandboxForm();
    }
    else
    {
      $this->setProductionForm();
    }
  }

  public function getForm()
  {
    return $this->form;
  }

  private function setSandboxForm()
  {
    $config = Config::getSection('payment');

    $this->form = new Form(
      '_xclick',
      PROJECT_URL.$config['paypal_return_url'],
      $config['paypal_sandbox_receiver'],
      $config['paypal_sandbox_paynow_button']
    );
  }

  private function setProductionForm()
  {

  }
}


 ?>
