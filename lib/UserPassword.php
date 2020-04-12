<?php

class UserPassword
{
  private $password;
  private $salt;

  public function __construct($password = null)
  {
    if(!empty($password))
    {
      $this->setPassword($password);
    }
    $this->salt = PASSWORD_SALT;
  }

  public function setPassword($password)
  {
    $this->password = UserInput::filterString($password);
  }

  public function getHash($password = null)
  {
    if(!empty($password))
    {
      $this->setPassword($password);
    }
    return password_hash($this->salt.$this->password, PASSWORD_DEFAULT);
  }

  public function getCleanPassword()
  {
    if(empty($this->password))
    {
      $this->generate();
    }
    return $this->password;
  }

  public function generate()
  {
    $this->setPassword(hash('adler32', mt_rand()));
    return $this->getCleanPassword();
  }

  public function verify($hash, $password = null)
  {
    if(!empty($password))
    {
      $this->setPassword($password);
    }

    return password_verify($this->salt.$this->password, $hash);
  }
}


 ?>
