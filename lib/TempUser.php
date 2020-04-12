<?php

class TempUser implements TempUserInterface
{
  private $model;

  public function __construct(TempUserModel $tempUserModel)
  {
    $this->model = $tempUserModel;
  }

  public function getName()
  {
    return $this->model->getName();
  }

  public function getLogin()
  {
    return $this->model->getEmail();
  }

  public function getPassword()
  {
    return $this->model->getCleanPassword();
  }

  public function getToken()
  {
    return $this->model->getToken();
  }

  public function getExpireDate()
  {
    return $this->model->getExpireDate();
  }

  public function getEmail()
  {
    return $this->model->getEmail();
  }
}

 ?>
