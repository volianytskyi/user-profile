<?php

use Core\CurrentUser;
abstract class Controller
{
  protected $view;
  protected $commonData;

  public function __construct()
  {
    $this->view = new View();
  }

}

 ?>
