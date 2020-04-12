<?php

namespace Core;

use Exceptions\DeviceRegistrationException as RegException;
use \DeviceTypeModel;
use Exceptions\NotFoundException;

class StbMag implements DeviceToRegisterInterface
{
  private $mac;
  private $hash;

  public function __construct($mac, $hash)
  {
    if($this->generateHash($mac) !== $hash)
    {
      throw new RegException("mac $mac mismathes hash $hash", RegException::MAC_HASH_MISMATCH);
    }
    $this->mac = $mac;
  }

  public function generateHash($mac)
  {
    $salt = STB_MAC_HASH_SALT . strtoupper($mac);
    $hash_parts = str_split(hash('sha256', $salt), 4);
    return strtoupper(implode('-', [$hash_parts[1], $hash_parts[3], $hash_parts[5], $hash_parts[2]]));
  }

  public function getStalkerPortalUserId()
  {
    return $this->mac;
  }

  public function getDeviceTypeId()
  {
    $deviceType = DeviceTypeModel::getByHardwareId('mac');
    if(!isset($deviceType['id']))
    {
      throw new NotFoundException("Device type with mac hardware ID not found", NotFoundException::NOT_FOUND_IN_DATABASE);
    }
    return $deviceType['id'];
  }
}

 ?>
