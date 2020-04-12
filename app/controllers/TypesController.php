<?php

use Core\CurrentUser;
use Exceptions\UserInputException;

class TypesController extends Controller
{
  private $model;

  public function __construct()
  {
    parent::__construct();
    $this->model = new DeviceTypeModel();
    $userPermissions = CurrentUser::getInstance()->getPermissions();

    if($userPermissions['can_manage_settings'] == false || $userPermissions['can_manage_device_types'] == false)
    {
      Route::redirect('/logout');
    }

  }

  public function actionNew()
  {
    $commonData = CurrentUser::getInstance()->getCommonData();
    $portals = PortalModel::getFieldsAll(['id', 'name']);
    $hwIdTypes = DeviceTypeModel::getPossibleHardwareIdTypes();
    array_unshift($hwIdTypes, 'not_specified');

    $data = array_merge($commonData, ['portals' => $portals], ['hw_id_types' => $hwIdTypes]);
    $this->view->generate('device_type.new', $data);
  }

  public function actionAdd()
  {
    if(!isset($_POST['name'], $_POST['portal_id'], $_POST['hardware_id']))
    {
      throw new UserInputException(UserInputException::message('empty_value'), UserInputException::EMPTY_INPUT);
    }
    CSRF::checkToken();
    $this->model->setName($_POST['name'])
                      ->setPortalId($_POST['portal_id'])
                      ->setHardwareId($_POST['hardware_id']);
    DeviceTypeModel::save($this->model);

    Route::redirect("/types");
  }

  public function actionList()
  {
    $data = CurrentUser::getInstance()->getCommonData();
    $data['device_types'] = DeviceTypeModel::getAll();
    foreach ($data['device_types'] as &$type)
    {
      $portal = PortalModel::getById($type['portal_id']);
      unset($type['portal_id']);
      $type['portal_name'] = $portal['name'];
    }
    $this->view->generate('types', $data);
  }

  public function actionDelete($id)
  {
    DeviceTypeModel::deleteById($id);
    Route::redirect("/types");
  }

  public function actionEdit($id)
  {
    if(isset($_POST['name'], $_POST['portal_id'], $_POST['hardware_id']))
    {
      CSRF::checkToken();
      $this->model->setId($id)
                  ->setName($_POST['name'])
                  ->setPortalId($_POST['portal_id'])
                  ->setHardwareId($_POST['hardware_id']);
      DeviceTypeModel::save($this->model);
      Route::redirect("/types");
    }

    $portalsData = PortalModel::getFieldsAll(['id', 'name']);
    $common = CurrentUser::getInstance()->getCommonData();
    $type = DeviceTypeModel::getById(UserInput::filterInt($id));
    $hwIdTypes = DeviceTypeModel::getPossibleHardwareIdTypes();
    array_unshift($hwIdTypes, 'not_specified');
    $data = array_merge($common, ['portals' => $portalsData], $type, ['hw_id_types' => $hwIdTypes]);
    $this->view->generate('device_type.edit', $data);
  }
}

 ?>
