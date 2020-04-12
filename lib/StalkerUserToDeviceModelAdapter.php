<?php

use Core\StalkerUser;
use StalkerPortal\ApiV1\Interfaces\Account;

class StalkerUserToDeviceModelAdapter
{
  private $stalkerUser;

  public function __construct(Account $stalkerUser)
  {
    $this->stalkerUser = $stalkerUser;
  }

  public function getDeviceModel()
  {
    $deviceModel = new DeviceModel();

    $deviceModel->setLogin($this->stalkerUser->getLogin())
                ->setName($this->stalkerUser->getFullName())
                ->setStatus($this->stalkerUser->getStatus())
                ->setExpireDate($this->stalkerUser->getExpireDate())
                ->setHardwareId($this->stalkerUser->getMac(), 'mac');

    foreach(unserialize(STREAMERS) as $streamer)
    {
      if(strrpos($this->stalkerUser->getComment(), $streamer) === 0)
      {
        $deviceModel->setStreamingServer($streamer);
        break;
      }
    }

    return $deviceModel;

  }
}

 ?>
