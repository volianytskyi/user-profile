<?php

use Payment\TransactionInterface;

class TestAccountTransaction implements TransactionInterface
{
  private $deviceId;
  private $userId;

  public function __construct($userId, $deviceId)
  {
    $this->userId = intval($userId);
    $this->deviceId = intval($deviceId);
  }

  public function getPaymentSystem()
  {
    return 'inner';
  }

  public function getUserId()
  {
    return $this->userId;
  }

  public function getDeviceId()
  {
    return $this->deviceId;
  }

  public function getDuration()
  {
    return DAYS_TEST;
  }

  public function getPrice()
  {
    return 0;
  }

  public function getPaymentDate()
  {
    return date("Y-m-d H:i:s");
  }

  public function getPaymentStatus()
  {
    return 'Allowed';
  }

  public function getReceiverEmail()
  {
    return null;
  }

  public function getPayerEmail()
  {
    $user = UserModel::getById($this->userId);
    return $user['email'];
  }
  public function getTxnId()
  {
    return 0;
  }

  public function getTxnType()
  {
    return 'test_account';
  }

  public function getCurrency()
  {
    return 'TEST';
  }

  public function isSandbox()
  {
    return false;
  }

  public function getTariff()
  {
    return 'test';
  }
}

 ?>
