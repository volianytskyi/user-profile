<?php

class UserModel extends Model
{
  use AuthTrait {
    AuthTrait::check as private;
  }

  private $password;

  public function __construct()
  {
    $this->password = new UserPassword();
  }

  public static function authorize($email, $pass)
  {
    $user = self::check($email, $pass);
    $_SESSION[SESSION_ID_KEY] = $user['id'];
  }

  public function setTempUser(TempUserModel $user)
  {
    $this->data['name'] = $user->getName();
    $this->data['email'] = $user->getEmail();
    $this->data['password'] = $user->getPassword();
    return $this;
  }

  public function setRoleId($id)
  {
    $this->data['role_id'] = UserInput::filterInt($id);
    return $this;
  }

  public function setPassword($password)
  {
    $this->data['password'] = $this->password->getHash($password);
    return $this;
  }

  public function setName($name)
  {
    $this->data['name'] = UserInput::filterString($name);
    return $this;
  }

}

 ?>
