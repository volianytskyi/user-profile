<?php

namespace Payment\Paypal;

use Exceptions\PaypalException;
use Payment\TransactionInterface;

class Transaction implements TransactionInterface
{
  private $data;

  public function __construct(IpnData $data)
  {
    $this->setIpnData($data);
  }

  private function setIpnData(IpnData $data)
  {
    foreach($data->getPostArray() as $key => $value)
    {
      switch($key)
      {
        case 'mc_gross':
          $this->data[$key] = floatval($value);
          break;
        case 'payment_date':
          $this->data[$key] = strftime("%Y-%m-%d %H:%M:%S", strtotime($value));
          break;
        case 'payment_status':
          $this->data[$key] = htmlspecialchars(strip_tags($value));
          break;
        case 'custom':
          $this->setCustomField($value);
          break;
        case (preg_match('~(business|payer_email)~', $key) ? true : false):
          $this->data[$key] = filter_var($value, FILTER_VALIDATE_EMAIL);
          break;
        case 'txn_id':
          $this->data[$key] = $value;
          break;
        case 'txn_type':
          $this->setTxnType($value);
          break;
        case 'mc_currency':
          $this->data[$key] = strtoupper($value);
          break;
        case 'test_ipn':
          $this->data[$key] = boolval($value);
          break;
      }
    }
  }

  private function setTxnType($type)
  {
    if(!preg_match('~(web_accept)~', $type))
    {
      throw new PaypalException("Unsupported txn type: $type");
    }
    $this->data['txn_type'] = $type;
  }

  private function setCustomField($value)
  {
    $custom = json_decode(urldecode($value), true);
    if(!isset($custom['user_id'], $custom['device_id'], $custom['duration'], $custom['tariff']))
    {
      throw new PaypalException("Corrupted custom post field");
    }
    $this->data['user_id'] = intval($custom['user_id']);
    $this->data['device_id'] = intval($custom['device_id']);
    $this->data['duration'] = intval($custom['duration']);
    $this->data['tariff'] = htmlspecialchars(strip_tags($custom['tariff']));
  }

  public function getPaymentSystem()
  {
    return 'paypal';
  }

  public function getUserId()
  {
    return $this->data['user_id'];
  }

  public function getDeviceId()
  {
    return $this->data['device_id'];
  }

  public function getDuration()
  {
    return $this->data['duration'];
  }

  public function getPrice()
  {
    return $this->data['mc_gross'];
  }

  public function getPaymentDate()
  {
    return $this->data['payment_date'];
  }

  public function getPaymentStatus()
  {
    return $this->data['payment_status'];
  }

  public function getReceiverEmail()
  {
    return $this->data['business'];
  }

  public function getPayerEmail()
  {
    return $this->data['payer_email'];
  }

  public function getTxnId()
  {
    return $this->data['txn_id'];
  }

  public function getTxnType()
  {
    return $this->data['txn_type'];
  }

  public function getCurrency()
  {
    return $this->data['mc_currency'];
  }

  public function isSandbox()
  {
    return $this->data['test_ipn'];
  }

  public function getTariff()
  {
    return $this->data['tariff'];
  }
}

 ?>
