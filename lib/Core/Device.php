<?php

namespace Core;

use Http\HttpClient as Http;
use Exceptions\ModelException;
use \DeviceModel;
use \UserInput;
use \StalkerApiFactory;
use \StalkerUserToDeviceModelAdapter as Adapter;
use Exceptions\DeviceRegistrationException as RegException;

class Device
{
  private $deviceModel;
  private $stalkerUser;

  public function __construct($id)
  {
    $this->deviceModel = new DeviceModel();
    $this->stalkerUser = new StalkerUser();

    $data = DeviceModel::getById($id);
    if(!isset($data['login'], $data['device_type_id']))
    {
      throw new ModelException("Device model data is not enough", ModelException::DATA_NOT_ENOUGH);
    }
    $this->deviceModel->setTrustedData($data);
  }

  public function loadStalkerUser()
  {
    $stalker = $this->getStalkerPortalUsersByCurrentDeviceType();
    if(!empty($this->deviceModel->getHardwareId()))
    {
      $id = $this->deviceModel->getHardwareId();
    }
    elseif(!empty($this->deviceModel->getLogin()))
    {
      $id = $this->deviceModel->getLogin();
    }
    else
    {
      throw new ModelException("Device model data is not enough", ModelException::DATA_NOT_ENOUGH);
    }

    $stalkerUserData = $stalker->select($id);
    $this->stalkerUser->setStalkerPortalRawData($stalkerUserData);
    return $this->stalkerUser;
  }

  public function updateDeviceModel(StalkerUser $stalkerUser)
  {
    $this->deviceModel->setName($stalkerUser->getFullName());
    //$this->deviceModel->setHardwareId($stalkerUser->getMac(), 'mac');
    $this->deviceModel->setStatus($stalkerUser->getStatus());
    $this->deviceModel->setExpireDate($stalkerUser->getExpireDate());
    if(empty($this->deviceModel->getLogin()) && !empty($stalkerUser->getLogin()) && DeviceModel::isLoginUnique($stalkerUser->getLogin()))
    {
      $this->deviceModel->setLogin($stalkerUser->getLogin());
    }
  }

  public function saveDeviceModel()
  {
    DeviceModel::save($this->deviceModel);
    return DeviceModel::getById($this->deviceModel->getId());
  }

  public function setPassword($pass)
  {
    $this->deviceModel->setPassword($pass);
  }

  public function setStreamingServer($code)
  {
    $this->deviceModel->setStreamingServer($code);
  }

  public function setDeviceType($id)
  {
    //do nothing if device type was not changed:
    if($this->deviceModel->getDeviceTypeId() === $id)
    {
      return;
    }

    //move device to another portal according to the new device type:
    //1. load current portal user data:
    $this->loadStalkerUser(); //it updates $this->stalkerUser
    $this->updateDeviceModel($this->stalkerUser);

    //2. switch off user in current portal:
    $stalkerPortal = $this->getStalkerPortalUsersByCurrentDeviceType();
    $stalkerPortal->switchStatus($this->deviceModel->getLogin(), false);

    //3. set new device type id
    $this->deviceModel->setDeviceTypeId($id);
    $stalkerPortal = $this->getStalkerPortalUsersByCurrentDeviceType();

    //4. add/update user in new portal:
    $this->stalkerUser->setDeviceModelData($this->deviceModel);
    if($stalkerPortal->isLoginUnique($this->deviceModel->getLogin()))
    {
      $stalkerPortal->add($this->stalkerUser);
    }
    else
    {
      $stalkerPortal->updateUserByLogin($this->stalkerUser);
    }
  }

  public function update()
  {
    $this->saveDeviceModel();
    $this->stalkerUser->setDeviceModelData($this->deviceModel);
    $stalkerPortal = $this->getStalkerPortalUsersByCurrentDeviceType();
    $stalkerPortal->updateUserByLogin($this->stalkerUser);
  }

  private function getStalkerPortalUsersByCurrentDeviceType()
  {
    $resourceFactory = StalkerApiFactory::createByDeviceTypeId($this->deviceModel->getDeviceTypeId());
    return $resourceFactory->getUsers();
  }

  public static function register(DeviceToRegisterInterface $device)
  {
    $stalkerPortal = StalkerApiFactory::createByDeviceTypeId($device->getDeviceTypeId());
    $users = $stalkerPortal->getUsers();
    $stalkerUserData = $users->select($device->getStalkerPortalUserId());
    $stalkerUser = new StalkerUser();
    $stalkerUser->setStalkerPortalRawData($stalkerUserData);

    $adapter = new Adapter($stalkerUser);
    $deviceModel = $adapter->getDeviceModel();
    $deviceModel->setUserId(CurrentUser::getInstance()->getId())
                ->setDeviceTypeId($device->getDeviceTypeId());

    return DeviceModel::save($deviceModel);
  }

}

 ?>
