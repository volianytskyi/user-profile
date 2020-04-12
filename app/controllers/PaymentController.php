<?php

use Core\CurrentUser;
use Tariffs\SimpleTariff as TariffPlan;
use Tariffs\PaymentTariffs;
use Payment\Paypal\Ipn;
use Payment\Paypal\IpnSandbox as IpnVerifier;
use Payment\Paypal\IpnData;
use Payment\Paypal\Transaction;
use Payment\TransactionVerifier;
use Exceptions\ModelException;

class PaymentController extends Controller
{
  public function actionGetPaymentInfo($deviceId, $duration)
  {
    if(!RequestType::isAjax() || !CurrentUser::getInstance()->canManageDeviceById($deviceId))
    {
      Route::redirect('/logout');
    }

    $paymentTariffs = new PaymentTariffs(new TariffPlan());
    $device = DeviceModel::getById($deviceId);
    $device['expired'] == '0000-00-00 00:00:00' ? $currentExpired = time() : $currentExpired = strtotime($device['expired']);
    $newExpired = date("Y-m-d H:i:s", strtotime("+$duration month", $currentExpired));



    $data = [
      'new_expired_date' => $newExpired,
      'currency' => $paymentTariffs->getCurrency(),
      'price' => $paymentTariffs->getPrice($duration),
      'tariff' => $paymentTariffs->getCalculatorAlias(),
    ];

    $this->view->generateJson($data);
  }

  public function actionPaypalIpn()
  {
    $ipnData = new IpnData();
    $ipn = new Ipn(new IpnVerifier(), $ipnData);
    if($ipn->verify())
    {
      $transaction = new Transaction($ipnData);
      $verifier = new TransactionVerifier($transaction);
      if($verifier->verify())
      {
        TransactionModel::insert($transaction);
        $device = DeviceModel::getById($transaction->getDeviceId());
        $stalkerPortal = StalkerApiFactory::createByDeviceTypeId($device['device_type_id'])->getUsers();
        if(!empty($device['hardware_id']) && filter_var($device['hardware_id'], FILTER_VALIDATE_MAC) != false)
        {
          $id = $device['hardware_id'];
        }
        elseif(!empty($device['login']))
        {
          $id = $device['login'];
        }
        else throw new ModelException(print_r($device, true), ModelException::DATA_NOT_ENOUGH);

        $duration = $transaction->getDuration();
        $device['expired'] == '0000-00-00 00:00:00' ? $currentExpired = time() : $currentExpired = strtotime($device['expired']);
        $newExpired = date("Y-m-d H:i:s", strtotime("+$duration month", $currentExpired));
        $stalkerPortal->setExpireDate($id, $newExpired);
      }
      else
      {
        error_log($transaction->getTxnId() ." transaction not confirmed");
      }
    }

    header("HTTP/1.1 200 OK");
    exit;
  }

  public function actionPaypalProcessing()
  {
    $this->view->generate('paypal.processing');
  }
}

 ?>
