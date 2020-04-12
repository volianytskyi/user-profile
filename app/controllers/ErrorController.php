<?php

class ErrorController extends Controller
{
  private $message;
  public function __construct($message)
  {
    parent::__construct();
    $this->message = filter_var($message, FILTER_SANITIZE_SPECIAL_CHARS);
  }

  public function actionDisplay()
  {
    $this->view->generate('error', ['message' => $this->message, 'locale' => Locale::getCurrent()]);
  }

  public function actionDisplay404()
  {
    $data = [
      'error_number' => 404,
      'message' => $this->message,
      'locale' => Locale::getCurrent()
    ];
    $this->view->generate('error', $data);
  }
}

 ?>
