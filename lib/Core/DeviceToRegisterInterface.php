<?php

namespace Core;

interface DeviceToRegisterInterface
{
  public function getStalkerPortalUserId();
  public function generateHash($userId);
  public function getDeviceTypeId();
}


 ?>
