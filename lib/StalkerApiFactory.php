<?php

use Http\HttpClient as Http;
use StalkerPortal\ApiV1\Resources\Accounts;
use StalkerPortal\ApiV1\Resources\Itv;
use StalkerPortal\ApiV1\Resources\ItvSubscription;
use StalkerPortal\ApiV1\Resources\SendEvent;
use StalkerPortal\ApiV1\Resources\ServicesPackage;
use StalkerPortal\ApiV1\Resources\Stb;
use StalkerPortal\ApiV1\Resources\StbMsg;
use StalkerPortal\ApiV1\Resources\Tariffs;
use StalkerPortal\ApiV1\Resources\Users;
use StalkerPortal\ApiV1\Exceptions\StalkerPortalException;

class StalkerApiFactory
{
  private $http;
  public function __construct(Http $http)
  {
    if(empty($http))
    {
      throw new StalkerPortalException("Unable to construct Stalker Portal resource object", 1);
    }
    $this->http = $http;
  }

  public static function createByPortalId($id)
  {
    $portal = PortalModel::getById($id);
    return new StalkerApiFactory(new Http($portal['api_url'], $portal['api_login'], $portal['api_pass']));
  }

  public static function createByDeviceTypeId($id)
  {
    $deviceType = \DeviceTypeModel::getById($id);
    return self::createByPortalId($deviceType['portal_id']);
  }

  public function getAccounts()
  {
    return new Accounts($this->http);
  }

  public function getItv()
  {
    return new Itv($this->http);
  }

  public function getItvSubscription()
  {
    return new ItvSubscription($this->http);
  }

  public function getSendEvent()
  {
    return new SendEvent($this->http);
  }

  public function getServicesPackage()
  {
    return new ServicesPackage($this->http);
  }

  public function getStb()
  {
    return new Stb($this->http);
  }

  public function getStbMsg()
  {
    return new StbMsg($this->http);
  }

  public function getUsers()
  {
    return new Users($this->http);
  }

  public function getTariffs()
  {
    return new Tariffs($this->http);
  }
}

 ?>
