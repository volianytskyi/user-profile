<?php

namespace Exceptions;
class UserInputException extends \Exception implements \MyExceptionInterface
{

  public static function message($key)
  {
    switch ($key)
    {
      case 'device_type_required':
        return _("Device type is required");
      case 'all_required':
        return _("All fields are required");
      case 'device_necessary':
        return _("Necessary to input password, streaming server and device type values");
      case 'both_login_password':
        return _("Please, fill both login and password");
      case 'empty_value':
        return _("Empty value is not allowed");
      case 'username_required':
        return _("Username must be entered");
      case 'password_twice':
        return _("The same password must be entered twice");
      case 'both_name_email':
        return _("Both name and email must be entered");
      default:
        return _("Incorrect user input data");
    }
  }

  const EMPTY_INPUT = 100;
  const EMPTY_PROPERTY = 101;
  const PASSWORD_MISMATCH = 102;

  public function getPublicMessage()
  {
    return $this->getMessage();
  }
}

 ?>
