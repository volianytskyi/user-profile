<?php

namespace Mail;

use \UserInput;

class MailBox implements EmailCreditsInterface
{
  private $login;
  private $password;
  private $name;
  private $address;

  public function __construct($login, $password, $name = '')
  {
    $this->setLogin($login);
    $this->setPassword($password);
    $this->setName($name);
  }

  public function setLogin($login)
  {
    $this->setAddress($login);
    $this->login = $this->address;
  }

  public function setAddress($email)
  {
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $this->address = $email;
    }
  }

  public function setPassword($password)
  {
    $this->password = UserInput::filterString($password);
  }

  public function setName($name)
  {
    $this->name = UserInput::filterString($name);
  }

  public function getLogin()
  {
    return $this->login;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getAddress()
  {
    return $this->address;
  }

  public function getName()
  {
    return $this->name;
  }

}

 ?>
