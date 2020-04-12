<?php

namespace Tariffs;

class SimpleTariff implements PriceCalculatorInterface
{
  public function calcPrice($singleMonthPrice, $duration)
  {
    return floatval($singleMonthPrice) * intval($duration);
  }

  public function getAlias()
  {
    return 'simple';
  }
}


 ?>
