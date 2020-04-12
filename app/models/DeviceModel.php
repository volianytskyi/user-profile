<?php

  class DeviceModel extends Model
  {
    protected $data;

    public function setStreamingServer($code)
    {
      $code = UserInput::filterString($code);
      if(in_array($code, unserialize(STREAMERS)))
      {
        $this->data['streaming_server'] = $code;
      }
    }

    public function getStreamingServer()
    {
      if(isset($this->data['streaming_server']))
      {
        return $this->data['streaming_server'];
      }
      return null;
    }

    public function setName($name)
    {
      $this->data['name'] = UserInput::filterString($name);
      return $this;
    }

    public function getName()
    {
      if(isset($this->data['name']))
      {
        return $this->data['name'];
      }
      return null;
    }

    public function setLogin($login)
    {
      $this->data['login'] = UserInput::filterString($login);
      return $this;
    }

    public function getLogin()
    {
      if(isset($this->data['login']))
      {
        return $this->data['login'];
      }
      return null;
    }

    public function setPassword($pass)
    {
      $this->data['pass'] = UserInput::filterString($pass);
      return $this;
    }

    public function getPassword()
    {
      if(isset($this->data['pass']))
      {
        return $this->data['pass'];
      }
      return null;
    }

    public function setStatus($status)
    {
      $this->data['status'] = boolval($status);
      return $this;
    }

    public function getStatus()
    {
      if(isset($this->data['status']))
      {
        return $this->data['status'];
      }
      return false;
    }

    public function setExpireDate($date)
    {
      $this->data['expired'] = UserInput::filterString($date);
      return $this;
    }

    public function getExpireDate()
    {
      if(isset($this->data['expired']))
      {
        return $this->data['expired'];
      }
      return null;
    }

    public function setId($id)
    {
      $this->data['id'] = UserInput::filterInt($id);
      return $this;
    }

    public function getId()
    {
      if(isset($this->data['id']))
      {
        return $this->data['id'];
      }
      return null;
    }

    public function setDeviceTypeId($id)
    {
      $this->data['device_type_id'] = UserInput::filterInt($id);
      return $this;
    }

    public function getDeviceTypeId()
    {
      if(isset($this->data['device_type_id']))
      {
        return $this->data['device_type_id'];
      }
      return null;
    }

    public function setResellerId($id)
    {
      $this->data['reseller_id'] = UserInput::filterInt($id);
      return $this;
    }

    public function getResellerId()
    {
      if(isset($this->data['reseller_id']))
      {
        return $this->data['reseller_id'];
      }
      return null;
    }

    public function setUserId($id)
    {
      $this->data['user_id'] = UserInput::filterInt($id);
      return $this;
    }

    public function getUserId()
    {
      if(isset($this->data['user_id']))
      {
        return $this->data['user_id'];
      }
      return null;
    }

    public function setHardwareId($hardwareId, $type)
    {
      switch($type)
      {

        case 'mac':
          if(preg_match('~^([0-9A-Fa-f]{2}:){5}([0-9A-Fa-f]{2})$~', $hardwareId) == true)
          {
            $this->data['hardware_id'] = $hardwareId;
          }
          break;

        default:
          $this->data['hardware_id'] = UserInput::filterString($hardwareId);
          break;

      }
      return $this;
    }

    public function getHardwareId()
    {
      if(isset($this->data['hardware_id']))
      {
        return $this->data['hardware_id'];
      }
      return null;
    }

    public static function isLoginUnique($login)
    {
      $table = static::table();
      $sql = "SELECT COUNT(1) FROM `$table` WHERE `login` = :login";
      $args = [
        'login' => UserInput::filterString($login)
      ];
      $count = self::db()->fetchColumn($sql, $args);
      if($count > 0)
      {
        return false;
      }
      return true;
    }

    public static function getAllByUserId($id)
    {
      $table = static::table();
      $sql = "SELECT * FROM `$table` WHERE `user_id` = :user_id";
      $args = [
        'user_id' => UserInput::filterInt($id)
      ];
      return self::db()->fetchAll($sql, $args);
    }


    public static function getTestAccountsCount($userId)
    {
      $table = static::table();
      $sql = 'SELECT COUNT(1) FROM `'.$table.'` WHERE `user_id` = :user_id AND `name` LIKE "%'.TEST_ACCOUNT_NAME_MASK.'"';
      $args = [
        'user_id' => UserInput::filterInt($userId)
      ];
      return self::db()->fetchColumn($sql, $args);
    }
  }

 ?>
