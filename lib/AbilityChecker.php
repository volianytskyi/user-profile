<?php

class AbilityChecker
{
  public static function canUserManageDevice($userId, $deviceId)
  {
    $device = DeviceModel::getById($deviceId);
    return $userId == $device['user_id'] || $userId == $device['reseller_id'];
  }
}

 ?>
