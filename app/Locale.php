<?php

class Locale
{
  public static function getCurrent()
  {
    return (isset($_SESSION['locale']) ? $_SESSION['locale'] : self::getDefault());
  }

  public static function setCurrent($lang)
  {
    //error_log(__METHOD__.": $lang");
    in_array($lang, self::getAllowed())
      ? $_SESSION['locale'] = $lang
      : $_SESSION['locale'] = self::getDefault();
  }

  public static function getDefault()
  {
    return DEFAULT_LOCALE;
  }

  public static function getAllowed()
  {
    return array_keys(unserialize(ALLOWED_LOCALES));
  }

  public static function setLocale($lang)
  {
    //error_log(__METHOD__.": $lang");
    $locale = null;
    $allowed = unserialize(ALLOWED_LOCALES);

    isset($allowed[$lang]) ? $locale = $allowed[$lang] : $locale = $allowed[self::getCurrent()];

    Locale::setCurrent($lang);

    putenv("LC_ALL=$locale");
    putenv("LANGUAGE=$locale");
    setlocale(LC_ALL, $locale);
    $domain = 'messages';
    bindtextdomain ($domain, LOCALES);
    textdomain ($domain);
    bind_textdomain_codeset($domain, 'UTF-8');
  }
}

 ?>
