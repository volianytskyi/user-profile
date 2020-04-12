<?php

  use Exceptions\PortalException;

  class PortalModel extends Model
  {
    protected $data;

    public function setApiUrl($url)
    {
      if(filter_var($url, FILTER_VALIDATE_URL))
      {
        ($url[strlen($url) - 1] == '/')
          ? $this->data['api_url'] = $url
          : $this->data['api_url'] = "$url/";

        return $this;
      }
      throw new PortalException("API URL incorrect value", PortalException::INCORRECT_PROPERTY_VALUE);
    }

    public function setApiLogin($login)
    {
      $this->data['api_login'] = UserInput::filterString($login);
      return $this;
    }

    public function setApiPassword($pass)
    {
      $this->data['api_pass'] = UserInput::filterString($pass);
      return $this;
    }

    public function setName($name)
    {
      $this->data['name'] = UserInput::filterString($name);
      return $this;
    }

    public function setId($id)
    {
      $this->data['id'] = UserInput::filterInt($id);
      return $this;
    }

  }

 ?>
