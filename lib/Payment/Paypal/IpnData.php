<?php

namespace Payment\Paypal;

class IpnData
{
  private $post;

  public function __construct()
  {
    $this->post = array();

    $raw_post_array = $this->getRawPostArray();

    $this->buildPostArray($raw_post_array);
  }

  private function getRawPostArray()
  {
    if ( ! count($_POST)) {
        throw new PaypalException("Missing POST Data");
    }
    $raw_post_data = file_get_contents('php://input');
    return explode('&', $raw_post_data);
  }

  private function buildPostArray(&$rawPostArray)
  {
    foreach ($rawPostArray as $keyval)
    {
        $keyval = explode('=', $keyval);
        if (count($keyval) == 2)
        {
            // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
            if ($keyval[0] === 'payment_date')
            {
                if (substr_count($keyval[1], '+') === 1)
                {
                    $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                }
            }
            $this->post[$keyval[0]] = urldecode($keyval[1]);
        }
    }
  }

  public function getPostArray()
  {
    return $this->post;
  }
}


 ?>
