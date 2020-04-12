<?php

namespace Payment;

interface TransactionInterface
{
  public function getPaymentSystem();
  public function getUserId();
  public function getDeviceId();
  public function getDuration();
  public function getPrice();
  public function getPaymentDate();
  public function getPaymentStatus();
  public function getReceiverEmail();
  public function getPayerEmail();
  public function getTxnId();
  public function getTxnType();
  public function getCurrency();
  public function isSandbox();
  public function getTariff();
}

 ?>
