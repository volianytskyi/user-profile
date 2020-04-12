<?php

use Exceptions\ViewException;

class View
{
  private $views;
  private $master;

  public function __construct()
  {
      $this->views = __DIR__ . '/views/';
      $this->master = $this->views.'master.template.php';
  }

  public function generate($content, $data = [])
  {
    if(!file_exists($this->master))
    {
      throw new ViewException("Unable to render the page: $this->master does not exist");
    }

    $content = $this->views . "view.$content.php";

    if(!file_exists($content))
    {
      throw new ViewException("Unable to render the page: $content view does not exist");
    }

    if(!empty($data))
    {
        extract($data);
    }

    include $this->master;
  }

  public function generateJson($data, $error = null)
  {
    $response = [
      'status' => '',
      'results' => '',
      'error' => ''
    ];

    if($error !== null)
    {
      $response['status'] = 'ERROR';
      $response['error'] = $error;
    }
    else
    {
      $response['status'] = 'OK';
      $response['results'] = $data;
    }
    
    echo json_encode($response);
    exit;
  }
}

 ?>
