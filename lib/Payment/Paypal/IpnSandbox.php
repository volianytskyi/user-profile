<?php

namespace Payment\Paypal;

class IpnSandbox implements IpnVerifierInterface
{
  public function getVerifyUri()
  {
    return 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
  }
}

 ?>
