<?php

namespace Core;

use StalkerPortal\ApiV1\Interfaces\Account;
use \DateTime;

class StalkerUser implements Account
{
    private $mac;
    private $login;
    private $password;
    private $accountNumber;
    private $status;
    private $tariff;
    private $comment;
    private $expDate;
    private $balance;
    private $name;

    public function setMac($mac)
    {
      if(preg_match('~^([0-9A-Fa-f]{2}:){5}([0-9A-Fa-f]{2})$~', $mac) == true)
      {
        $this->mac = $mac;
      }
    }

    public function getMac()
    {
        return $this->mac;
    }

    public function setLogin($login)
    {
      $this->login = \UserInput::filterString($login);
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setPassword($pass)
    {
      $this->password = \UserInput::filterString($pass);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setAccountNumber($accountNumber)
    {
      $this->accountNumber = \UserInput::filterString($accountNumber);
    }

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    public function setStatus($status)
    {
      $this->status = boolval($status);
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setTariffPlanExternalId($tariffId)
    {
      $this->tariff = \UserInput::filterString($tariffId);
    }

    public function getTariffPlanExternalId()
    {
        return $this->tariff;
    }

    public function setComment($comment)
    {
      $this->comment = \UserInput::filterString($comment);
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setExpireDate($date)
    {
      if(DateTime::createFromFormat("Y-m-d H:i:s", $date) !== false)
      {
        $this->expDate = $date;
      }
    }

    public function getExpireDate()
    {
        return $this->expDate;
    }

    public function setAccountBalance($balance)
    {
      $this->balance = floatval($balance);
    }

    public function getAccountBalance()
    {
        return $this->balance;
    }

    public function setFullName($name)
    {
      $this->name = \UserInput::filterString($name);
    }

    public function getFullName()
    {
        return $this->name;
    }

    public function setStalkerPortalRawData(array $data)
    {
      $this->setLogin($data['login']);
      $this->setFullName($data['full_name']);
      $this->setAccountNumber($data['account_number']);
      $this->setTariffPlanExternalId($data['tariff_plan']);
      $this->setMac($data['stb_mac']);
      $this->setStatus($data['status']);
      $this->setComment($data['comment']);
      $this->setExpireDate($data['end_date']);
      $this->setAccountBalance($data['account_balance']);
    }

    public function setDeviceModelData(\DeviceModel $deviceModel)
    {
      $this->setLogin($deviceModel->getLogin());
      $this->setPassword($deviceModel->getPassword());
      $this->setFullName($deviceModel->getName());
      $this->setMac($deviceModel->getHardwareId());
      $this->setStatus($deviceModel->getStatus());
      $this->setExpireDate($deviceModel->getExpireDate());

      if(strpos($this->getComment(), $deviceModel->getStreamingServer()) !== 0)
      {
        $this->setComment($deviceModel->getStreamingServer()."\n".$this->getComment());
      }
    }
}

 ?>
