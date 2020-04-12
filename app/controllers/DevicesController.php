<?php

use Core\CurrentUser;
use Core\Device;
use Core\StbMag;
use Core\ProstoTvApp;
use Core\DeviceRegistrator;
use Exceptions\UserInputException;
use Exceptions\NotFoundException;
use Exceptions\PermissionException;
use Exceptions\DeviceRegistrationException;
use Payment\Paypal\PayNow;

class DevicesController extends Controller
{
  private $model;

  public function __construct()
  {
    parent::__construct();
    $this->model = new DeviceModel();
  }

  public function actionNew()
  {
    $commonData = CurrentUser::getInstance()->getCommonData();
    $deviceTypes = DeviceTypeModel::getAll();
    $data = array_merge($commonData, ['device_types' => $deviceTypes]);
    $this->view->generate('device.new', $data);
  }

  //add test account
  public function actionTest()
  {
    CSRF::checkToken();

    (isset($_POST['mac'])) ? $mac = $_POST['mac'] : $mac = null;
    $testAccount = TestAccountFactory::create($_POST['device_type'], $mac);
    $testAccount->initData();
    $deviceId = $testAccount->add();
    $tr = new TestAccountTransaction(CurrentUser::getInstance()->getId(), $deviceId);
    TransactionModel::insert($tr);

    Route::redirect("/devices");
  }

  public function actionList()
  {
    $data = CurrentUser::getInstance()->getCommonData();
    $devices = DeviceModel::getAllByUserId(CurrentUser::getInstance()->getId());
    if(DEVICES_LIST_ALWAYS_ACTUAL)
    {
      foreach ($devices as $device)
      {
        $dev = new Device($device['id']);
        $dev->updateDeviceModel($dev->loadStalkerUser());
        $data['devices'][] = $dev->saveDeviceModel();
      }
    }
    else
    {
      $data['devices'] = $devices;
    }

    foreach($data['devices'] as &$device)
    {
      $deviceType = DeviceTypeModel::getById($device['device_type_id']);
      unset($device['device_type_id']);
      $device['device_type'] = $deviceType['name'];
      if($deviceType['hardware_id'] != 'mac')
      {
        $device['hardware_id'] = '';
      }
      ($device['expired'] === '0000-00-00 00:00:00')
        ? $device['expired'] = 'unlimited'
        : $device['expired'] = DateTime::createFromFormat('Y-m-d H:i:s', $device['expired'])->format("d M Y H:i");
    }
    $this->view->generate('devices', $data);
  }

  public function actionRegister()
  {
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      CSRF::checkToken();
      if(!isset($_POST['device_type']))
      {
        throw new UserInputException(UserInputException::message('device_type_required'), UserInputException::EMPTY_INPUT);
      }
      $deviceType = DeviceTypeModel::getById($_POST['device_type']);
      if(empty($deviceType))
      {
        throw new NotFoundException(sprintf(_("Device type %s not found"), $deviceType), NotFoundException::NOT_FOUND_IN_DATABASE);
      }
      switch ($deviceType['hardware_id'])
      {
        case 'mac':
          if(!isset($_POST['mac'], $_POST['mac_hash']))
          {
            throw new UserInputException(UserInputException::message('all_required'), UserInputException::EMPTY_INPUT);
          }
          $device = new StbMag($_POST['mac'], $_POST['mac_hash']);
          break;

        case 'custom_hash':
          if(!isset($_POST['login'], $_POST['custom_hash']))
          {
            throw new UserInputException(UserInputException::message('all_required'), UserInputException::EMPTY_INPUT);
          }
          $device = new ProstoTvApp($_POST['login'], $_POST['custom_hash']);
          break;

        default:
          throw new DeviceRegistrationException($deviceType['hardware_id'] . ' device type can\'t be registered', 1);
      }
      $id = Device::register($device);
      Route::redirect("/devices/$id");
    }

    $commonData = CurrentUser::getInstance()->getCommonData();
    $deviceTypes = array_filter(
      DeviceTypeModel::getAll(),
      function($deviceType) {
        return ($deviceType['hardware_id']);
      }
    );

    $data = array_merge($commonData, ['device_types' => $deviceTypes]);
    $this->view->generate('device.register', $data);
  }

  public function actionEdit($id)
  {
    $devices = DeviceModel::getAllByUserId(CurrentUser::getInstance()->getId());
    if(!in_array($id, array_column($devices, 'id')))
    {
      throw new PermissionException(
        "User ". CurrentUser::getInstance()->getId() . " tried to access device $id",
        PermissionException::FOREIGN_DEVICE
      );
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      CSRF::checkToken();
      if(!isset($_POST['pass'], $_POST['device_type_id']))
      {
        throw new UserInputException(
          UserInputException::message('device_necessary'),
          UserInputException::EMPTY_INPUT
        );
      }

      $device = new Device($id);
      $device->setPassword($_POST['pass']);
      //$device->setStreamingServer($_POST['streamer']);
      $device->setDeviceType($_POST['device_type_id']);
      $device->update();
      Route::redirect("/devices/$id");
    }

    $commonData = CurrentUser::getInstance()->getCommonData();
    $device = new Device($id);
    $stalkerUser = $device->loadStalkerUser(); //error_log(print_r($stalkerUser, true));
    $device->updateDeviceModel($stalkerUser);
    $deviceData = $device->saveDeviceModel();
    ($deviceData['expired'] === '0000-00-00 00:00:00')
      ? $deviceData['expired'] = 'unlimited'
      : $deviceData['expired'] = DateTime::createFromFormat('Y-m-d H:i:s', $deviceData['expired'])->format("d M Y H:i");
    $miscData = [
      'device_types' => DeviceTypeModel::getAll()
    ];

    $payNow = new PayNow(true); //sandbox
    $paypal = $payNow->getForm();

    $paypalCustomData = [
      'user_id' => CurrentUser::getInstance()->getId(),
      'device_id' => $id
    ];

    $paymentData = [
      'durations' => Config::get('possible_durations', [1, 6, 12]),
      'paypal_action' => $paypal->getActionUrl(),
      'cmd' => $paypal->getCmd(),
      'receiver' => $paypal->getReceiverEmail(),
      'item_name' => PROJECT_NAME . ' ' . _("Subscription"),
      'return_url' => $paypal->getReturnUrl(),
      'custom' => urlencode(json_encode($paypalCustomData)),
      'lc' => strtoupper(Locale::getCurrent()),
    ];
    $data = array_merge($commonData, $deviceData, $miscData, $paymentData);
    $this->view->generate('device.edit', $data);
  }
}

 ?>
