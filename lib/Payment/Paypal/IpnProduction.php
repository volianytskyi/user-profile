<?php

namespace Payment\Paypal;

class IpnProduction implements IpnVerifierInterface
{
  public function getVerifyUri()
  {
    return 'https://ipnpb.paypal.com/cgi-bin/webscr';
  }
}

 ?>
