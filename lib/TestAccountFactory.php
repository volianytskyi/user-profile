<?php

use StalkerPortal\ApiV1\Resources\Users;
use Http\HttpClient;
use Core\TestAccount;
use Exceptions\UserInputException;
use Exceptions\NotFoundException;

class TestAccountFactory
{
  public static function create($deviceTypeId, $mac = null)
  {
    $deviceType = DeviceTypeModel::getById($deviceTypeId);
    if(empty($deviceType))
    {
      throw new NotFoundException(
        "Device type " . UserInput::filterString($_POST['device_type']) . " not found",
        NotFoundException::NOT_FOUND_IN_DATABASE
      );
    }

    if($deviceType['hardware_id'] == 'mac' && empty($mac))
    {
        throw new UserInputException(UserInputException::message('empty_value'), UserInputException::EMPTY_INPUT);
    }

    $factory = StalkerApiFactory::createByDeviceTypeId($deviceType['id']);
    $testAccount = new TestAccount($factory->getUsers());
    $testAccount->setMac($mac);
    $testAccount->setDeviceTypeId($deviceType['id']);

    return $testAccount;
  }

}

 ?>
