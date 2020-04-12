<?php

namespace Payment;

use Tariffs\PaymentTariffs;
use \Config;
use \TransactionModel;
use \AbilityChecker;

class TransactionVerifier
{
  private $tr;
  private $errors;

  public function __construct(TransactionInterface $tr)
  {
    $this->tr = $tr;
    $this->errors = '';
  }

  public function verify()
  {
    $result = ($this->verifyPrice() && $this->verifyReceiverEmail() && $this->verifyPaymentStatus() && $this->verifyUserId());
    if($this->errors)
    {
      error_log("transaction processing errors:\n $this->errors");
    }
    return $result;
  }

  private function verifyPrice()
  {
    $tariff = PaymentTariffs::createByAlias($this->tr->getTariff());
    $correctPrice = $tariff->getPrice($this->tr->getDuration());
    $realPrice = $this->tr->getPrice();
    if($realPrice != $correctPrice)
    {
      $this->errors .= "real price $realPrice != correctPrice $correctPrice\n";
      return false;
    }
    return true;
  }

  private function verifyReceiverEmail()
  {
    ($this->tr->isSandbox()) ? $email = Config::get('paypal_sandbox_receiver') : $email = Config::get('receiver');
    if($this->tr->getReceiverEmail() != $email)
    {
      $this->errors .= "bad receiver email: ". $this->tr->getReceiverEmail() . "\n";
      return false;
    }
    return true;
  }

  private function verifyPaymentStatus()
  {
    $status = $this->tr->getPaymentStatus();
    if($status != 'Completed')
    {
      $this->errors . "payment status: $status\n";
      return false;
    }
    if(TransactionModel::transactionExists($this->tr) == true)
    {
      $this->errors .= "transaction ". $this->tr->getTxnId()." already processed\n";
      return false;
    }
    return true;
  }

  private function verifyUserId()
  {
    $user = $this->tr->getUserId();
    $device = $this->tr->getDeviceId();
    $able = (AbilityChecker::canUserManageDevice($user, $device));
    if($able == false)
    {
      $this->errors .= "user $user cannot manage $device\n";
      return false;
    }
    return true;
  }
}

 ?>
