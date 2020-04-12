<?php
namespace Core;

use \Locale;
use \DeviceModel;

class CurrentUser
{

  private static $instance = null;
  private $model;
  private $data;
  private $permissions;

  private function __construct($id)
  {
    $this->model = new \UserModel();
    $this->data = \UserModel::getById($id);
    $this->setPermissions();
  }

  private function setPermissions()
  {
    //static permissions based on the user role:
    $this->permissions = \PermissionModel::getUserPermissionsByRole($this->data['role_id']);
    unset($this->permissions['role_id']);
  }

  private function __clone() {}

  public static function getInstance()
  {
    if(!isset($_SESSION[SESSION_ID_KEY]))
    {
      \Route::redirect('/login');
    }

    if(self::$instance === null)
    {
      return new self($_SESSION[SESSION_ID_KEY]);
    }
    return self::$instance;
  }

  public function getCommonData()
  {
    $data = [
      'secure_token' => \CSRF::createToken(),
      'current_user_name' => $this->data['name'],
      'project_name' => PROJECT_NAME,
      'current_locale' => Locale::getCurrent(),
      'locales' => Locale::getAllowed(),
      'username' => $this->getName()
    ];

    foreach ($this->permissions as $key => $value)
    {
      $data[$key] = $value;
    }

    return $data;
  }

  public function getPermissions()
  {
    return $this->permissions;
  }

  public function getId()
  {
    return $this->data['id'];
  }

  public function getEmail()
  {
    return $this->data['email'];
  }

  public function getName()
  {
    return $this->data['name'];
  }

  public function canManageDeviceById($id)
  {
    $device = DeviceModel::getById($id);
    if(empty($device))
    {
      return false;
    }

    return $this->getid() == $device['user_id'] || $this->getId() == $device['reseller_id'];
  }

}

 ?>
