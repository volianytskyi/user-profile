<?php

  use Exceptions\PortalException;

  class DeviceTypeModel extends Model
  {
    protected $data;

    public function setName($name)
    {
      $this->data['name'] = UserInput::filterString($name);
      return $this;
    }

    public function setId($id)
    {
      $this->data['id'] = UserInput::filterInt($id);
      return $this;
    }

    public function setHardwareId($type)
    {
      $type = UserInput::filterString($type);

      (in_array($type, $this->getPossibleHardwareIdTypes()))
        ? $this->data['hardware_id'] = $type
        : $this->data['hardware_id'] = null;
      return $this;
    }

    public static function getPossibleHardwareIdTypes()
    {
      $table = static::table();
      $enum = self::db()->fetch('SHOW COLUMNS FROM `'.$table.'` LIKE "hardware_id"')['Type'];
      preg_match('~enum\((.*)\)$~', $enum, $matches);
      return explode(',', str_replace('\'', '', $matches[1]));
    }

    public static function getByHardwareId($hardwareId)
    {
      $table = static::table();
      $args = ['hardware_id' => UserInput::filterString($hardwareId)];
      return self::db()->fetch("SELECT * FROM `$table` WHERE `hardware_id` = :hardware_id", $args);
    }

    public function setPortalId($id)
    {
      $this->data['portal_id'] = UserInput::filterInt($id);
      return $this;
    }

  }

 ?>
