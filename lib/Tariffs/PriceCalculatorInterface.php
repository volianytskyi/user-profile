<?php

namespace Tariffs;

interface PriceCalculatorInterface
{
  public function calcPrice($singleMonthPrice, $duration);
  public function getAlias();
}

 ?>
