<?php

namespace Payment\Paypal;

use Exceptions\PaypalException;

class Ipn
{
    private $data;
    private $verifyUri;
    private $cert;

    /** @var bool Indicates if the local certificates are used. */
    private $use_local_certs = true;

    /** Response from PayPal indicating validation was successful */
    const VALID = 'VERIFIED';
    /** Response from PayPal indicating validation failed */
    const INVALID = 'INVALID';

    public function __construct(IpnVerifierInterface $verifier, IpnData $data, $cert = true)
    {
      $this->verifyUri = $verifier;
      $this->data = $data;
      if(!$cert)
      {
        $this->usePHPCerts();
      }
      else
      {
        $certs = __DIR__ . "/cert/cacert.pem";
        if(!file_exists($certs))
        {
          throw new PaypalException("$certs file missing", PaypalException::CERTS);
        }
        $this->cert = $certs;
      }
    }

    /**
     * Sets curl to use php curl's built in certs (may be required in some
     * environments).
     * @return void
     */
    public function usePHPCerts()
    {
        $this->use_local_certs = false;
    }

    /**
     * Verification Function
     * Sends the incoming post data back to PayPal using the cURL library.
     *
     * @return bool
     * @throws Exception
     */
    public function verify()
    {
        $req = $this->buildVerificationPostBody();

        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init($this->verifyUri->getVerifyUri());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        if ($this->use_local_certs)
        {
            curl_setopt($ch, CURLOPT_CAINFO, $this->cert);
        }
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: PHP-IPN-Verification-Script',
            'Connection: Close',
        ));

        $res = curl_exec($ch);

        if ( ! ($res))
        {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new PaypalException("cURL error: [$errno] $errstr");
        }

        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];

        if ($http_code != 200)
        {
            throw new PaypalException("PayPal responded with http code $http_code");
        }

        curl_close($ch);

        // Check if PayPal verifies the IPN data, and if so, return true.
        return ($res == self::VALID);
    }

    // Build the body of the verification post request, adding the _notify-validate command.
    private function buildVerificationPostBody()
    {
      $postData = $this->data->getPostArray();

      $req = 'cmd=_notify-validate';
      $get_magic_quotes_exists = false;
      if (function_exists('get_magic_quotes_gpc'))
      {
          $get_magic_quotes_exists = true;
      }

      foreach ($postData as $key => $value)
      {
          ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1)
            ? $value = urlencode(stripslashes($value))
            : $value = urlencode($value);

          $req .= "&$key=$value";
      }

      return $req;
    }
}
