<?php

namespace Core;

use StalkerPortal\ApiV1\Resources\BaseUsers as Stalker;
use Exceptions\TestAccountException;
use \DeviceModel;

class TestAccount
{
  private $resource;
  private $stalkerUser;
  private $deviceModel;

  public function __construct(Stalker $resource)
  {
    $this->resource = $resource;
    $this->stalkerUser = new StalkerUser();
    $this->deviceModel = new DeviceModel();
    $this->setUserId(CurrentUser::getInstance()->getId());
  }

  public function initData()
  {
    $this->setLogin();
    $this->setPassword();
    $this->setExpireDate();
    $this->setStatus();
    $this->setName();
  }

  public function add()
  {
    $existingCount = $this->deviceModel->getTestAccountsCount(CurrentUser::getInstance()->getId());
    if($existingCount < TEST_ACCOUNTS_MAX_NUMBER)
    {
      $this->resource->add($this->stalkerUser);
      return DeviceModel::save($this->deviceModel);
    }
    else
    {
      throw new TestAccountException(TestAccountException::message('limit_reached'), TestAccountException::LIMIT_REACHED);
    }
  }

  public function setMac($mac)
  {
    if(preg_match('~^([0-9A-Fa-f]{2}:){5}([0-9A-Fa-f]{2})$~', $mac) == true)
    {
      $this->stalkerUser->setMac($mac);
      $this->deviceModel->setHardwareId($mac, 'mac');
    }
  }

  public function setDeviceTypeId($id)
  {
    $this->deviceModel->setDeviceTypeId(\UserInput::filterInt($id));
  }

  public function setUserId($id)
  {
    $this->deviceModel->setUserId(\UserInput::filterInt($id));
  }

  private function setExpireDate()
  {
    $date = date('Y-m-d H:i:s', strtotime("+".DAYS_TEST." days"));
    $this->deviceModel->setExpireDate($date);
    $this->stalkerUser->setExpireDate($date);
  }

  private function setStatus()
  {
    $this->deviceModel->setStatus(true);
    $this->stalkerUser->setStatus(true);
  }

  private function setPassword()
  {
    $pass = mt_rand('00000001', '99999999');
    $this->deviceModel->setPassword($pass);
    $this->stalkerUser->setPassword($pass);
  }

  private function setLogin()
  {
    $i = 1;
    $basicLogin = explode('@', CurrentUser::getInstance()->getEmail())[0];
    $login = $basicLogin;
    while ($this->deviceModel->isLoginUnique($login) == false || $this->resource->isLoginUnique($login) == false) {
      $login = $basicLogin."_".$i;
      $i++;
    }

    $this->deviceModel->setLogin($login);
    $this->stalkerUser->setLogin($login);
  }

  private function setName()
  {
    $this->deviceModel->setName(TEST_ACCOUNT_NAME);
    $this->stalkerUser->setFullName(TEST_ACCOUNT_NAME);
  }
}

 ?>
