<?php

$languages = implode('|', array_keys(unserialize(ALLOWED_LOCALES)));

return [
  '^('.$languages.')?/?authorize$' => '$1/login/authorize',
  '^('.$languages.')?/?restore$' => '$1/login/restore',
  '^('.$languages.')?/?$'          => '$1/login/index',
  '^('.$languages.')?/?login$'     => '$1/login/login',
  '^('.$languages.')?/?profile/(save)$'     => '$1/profile/$2',
  '^('.$languages.')?/?profile$'     => '$1/profile/index',
  '^('.$languages.')?/?login/([a-z0-9]{40})$'     => '$1/registration/login/$2',
  '^('.$languages.')?/?registration$'     => '$1/registration/index',
  '^('.$languages.')?/?register$'     => '$1/registration/register',
  '^('.$languages.')?/?sign-in$'     => '$1/registration/signIn',
  '^('.$languages.')?/?logout$'    => '$1/login/logout',
  '^('.$languages.')?/?dashboard$'    => '$1/dashboard/index',
  '^('.$languages.')?/?error$'     => '$1/error/display',

  '^('.$languages.')?/?(types|devices|portals)$'                  => '$1/$2/list',
  '^('.$languages.')?/?(types|devices|portals)/(add|new)$'        => '$1/$2/$3',
  '^('.$languages.')?/?(types|devices|portals)/delete/([0-9]+)$'  => '$1/$2/delete/$3',
  '^('.$languages.')?/?(types|devices|portals)/([0-9]+)$'         => '$1/$2/edit/$3',
  '^('.$languages.')?/?devices/(test|register)$'                  => '$1/devices/$2',

  // payment/info/device_id/duration/
  '^('.$languages.')?/?payment/info/([0-9]+)/([0-9]+)$'    => '$1/payment/getPaymentInfo/$2/$3',
  '^payment/paypal/ipn$'    => 'payment/paypalIpn',
  '^payment/paypal/processing$'    => 'payment/paypalProcessing',
  '^datatables/(transactions|payments)' => 'datatables/$1',
  '^('.$languages.')?/?transactions' => 'transactions/list',

];



 ?>
