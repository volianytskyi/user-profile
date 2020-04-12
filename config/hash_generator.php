<?php

  if(php_sapi_name() !== 'cli')
  {
    exit('The script must be launched in terminal console'.PHP_EOL);
  }

  if(!is_writeable('common.php'))
  {
    exit('Cannot edit common.php');
  }

  $salts = ['CSRF_SALT', 'PASSWORD_SALT', 'STB_MAC_HASH_SALT', 'REGISTRATION_TOKEN_SALT'];

  foreach($salts as $salt)
  {
    sleep(mt_rand(1, 5));
    $hash = hash('sha1', time());
    $data = 'define("'.$salt.'", "'.$hash.'");';
    file_put_contents('common.php', $data . PHP_EOL, FILE_APPEND|LOCK_EX);
    echo "$salt = $hash\n";
  }

  echo 'common.php updated'.PHP_EOL;

 ?>
