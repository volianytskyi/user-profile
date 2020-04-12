<?php

class UserInput
{
  public static function filterString($str)
  {
    return htmlspecialchars(strip_tags($str));
  }

  public static function filterInt($number)
  {
    return intval($number);
  }

  public static function validateUrl($url)
  {
    return filter_var($url, FILTER_VALIDATE_URL);
  }

  public static function validateEmail($email)
  {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
}

 ?>
