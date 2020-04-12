<?php

namespace Tariffs;

use Exceptions\ConfigException;
use \Config;

class PaymentTariffs
{
  private $tariffs;
  private $calculator;

  public function __construct(PriceCalculatorInterface $calculator)
  {
    $this->tariffs = Config::getSection('tariffs');
    $this->calculator = $calculator;
  }

  private function getConfigValue($param)
  {
    if(isset($this->tariffs[$param]))
    {
      return $this->tariffs[$param];
    }
    return Config::get($param);
  }

  public function getCurrency()
  {
    return $this->getConfigValue('currency');
  }

  public function getPossibleDurations()
  {
    return $this->getConfigValue('possible_durations');
  }

  public function getPrice($duration)
  {
    return $this->calculator->calcPrice($this->getConfigValue('single_month_price'), $duration);
  }

  public function getCalculatorAlias()
  {
    return $this->calculator->getAlias();
  }

  public static function createByAlias($alias)
  {
    $tariff = null;
    switch($alias)
    {
      case 'simple':
        $tariff = new SimpleTariff();
        break;
      default:
        $tariff = new SimpleTariff();
        break;
    }
    return new PaymentTariffs($tariff);
  }
}

 ?>
