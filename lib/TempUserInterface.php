<?php

interface TempUserInterface
{
  public function getName();
  public function getLogin();
  public function getPassword();
  public function getToken();
  public function getExpireDate();
  public function getEmail();
}

 ?>
