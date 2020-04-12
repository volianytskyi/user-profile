<?php

class PermissionModel extends Model
{
  public static function getUserPermissionsByRole($id)
  {
    $args = [
      'id' => UserInput::filterInt($id)
    ];
    $table = static::table();
    return self::db()->fetch("SELECT * FROM `$table` WHERE `role_id` = :id", $args);
  }
}

 ?>
