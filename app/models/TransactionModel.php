<?php

use Payment\TransactionInterface;

class TransactionModel extends Model
{
  public static function transactionExists(TransactionInterface $tr)
  {
    $table = static::table();
    $sql = "SELECT COUNT(1) FROM `$table` WHERE `payment_system` = :payment_system AND `status` = :status AND `txn_id` = :txn_id";
    $args = [
      'payment_system' => $tr->getPaymentSystem(),
      'status' => $tr->getPaymentStatus(),
      'txn_id' => $tr->getTxnId(),
    ];
    $count = self::db()->fetchColumn($sql, $args);
    if(empty($count))
    {
      return false;
    }
    return true;
  }

  public static function insert(TransactionInterface $tr)
  {
    $data = [
      'payment_system' => $tr->getPaymentSystem(),
      'price' => $tr->getPrice(),
      'status' => $tr->getPaymentStatus(),
      'txn_id' => $tr->getTxnId(),
      'txn_type' => $tr->getTxnType(),
      'currency' => $tr->getCurrency(),
      'date' => $tr->getPaymentDate(),
      'receiver' => $tr->getReceiverEmail(),
      'payer' => $tr->getPayerEmail(),
      'user_id' => $tr->getUserId(),
      'device_id' => $tr->getDeviceId(),
    ];

    return self::db()->insert(static::table(), $data);
  }
}

 ?>
