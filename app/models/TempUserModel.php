<?php

class TempUserModel extends Model
{
  use AuthTrait {
    AuthTrait::check as private;
  }

  private $password;

  public function __construct()
  {
    $this->password = new UserPassword();
  }

  public static function init($name, $email)
  {
    $tempUser = new TempUserModel();
    return $tempUser->setName($name)
                    ->setEmail($email)
                    ->setPassword()
                    ->setToken()
                    ->setExpireDate();
  }

  public function setEmail($email)
  {
    $this->data['email'] = UserInput::validateEmail($email);
    return $this;
  }

  public function getEmail()
  {
    if(isset($this->data['email']))
    {
      return $this->data['email'];
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

  public function setToken()
  {
    do {
      $token = sha1(REGISTRATION_TOKEN_SALT.time());
    } while (!empty(self::getByToken($token)));

    $this->data['token'] = $token;
    return $this;
  }

  public function getToken()
  {
    if(isset($this->data['token']))
    {
      return $this->data['token'];
    }
    return null;
  }

  public function setPassword()
  {
    $this->password->generate();
    $this->data['password'] = $this->password->getHash();
    return $this;
  }

  public function getCleanPassword()
  {
    return $this->password->getCleanPassword();
  }

  public function getPassword()
  {
    if(isset($this->data['password']))
    {
      return $this->data['password'];
    }
    return null;
  }

  private function setExpireDate()
  {
    $this->data['expire_date'] = date("Y-m-d H:i:s", strtotime("+".REGISTRATION_TOKEN_TTL." seconds"));
    return $this;
  }

  public function getExpireDate()
  {
    if(isset($this->data['expire_date']))
    {
      return $this->data['expire_date'];
    }
    return null;
  }

  public static function getByToken($token)
  {
    $args = [
      'token' => UserInput::filterString($token)
    ];
    $table = static::table();
    return self::db()->fetch("SELECT * FROM `$table` WHERE `token` = :token", $args);
  }

  public static function firstSignIn($email, $pass)
  {
    $user = self::check($email, $pass);

    $tempUser = new TempUserModel();

    $userModel = new UserModel();
    $id = UserModel::save(
      $userModel->setTempUser($tempUser->setTrustedData($user))
                ->setRoleId(RoleModel::getCustomerId())
    );

    if(is_int(intval($id)) == true)
    {
      $_SESSION[SESSION_ID_KEY] = $id;
      TempUserModel::deleteById($user['id']);
      return true;
    }
    return false;
  }
}

 ?>
