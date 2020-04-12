<?php

namespace Mail;

interface EmailCreditsInterface
{
  public function getLogin();
  public function getPassword();
  public function getAddress();
  public function getName();
}

 ?>
