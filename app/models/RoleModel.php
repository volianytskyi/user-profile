<?php

use Exceptions\NotFoundException;

class RoleModel extends Model
{
  public static function getRootId()
  {
    return self::getIdByAlias(ROOT_ALIAS);
  }

  public static function getCustomerId()
  {
    return self::getIdByAlias(CUSTOMER_ALIAS);
  }

  private static function getIdByAlias($alias)
  {
    $args = [
      'alias' => UserInput::filterString($alias)
    ];
    $table = static::table();
    $role = self::db()->fetch("SELECT * FROM `$table` WHERE alias = :alias", $args);
    if(empty($role))
    {
      throw new NotFoundException("role alias $alias not found", NotFoundException::NOT_FOUND_IN_DATABASE);
    }
    return $role['id'];
  }
}


 ?>
