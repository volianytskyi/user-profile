<?php

use Core\CurrentUser;
use Exceptions\UserInputException;

class PortalsController extends Controller
{
  private $model;
  public function __construct()
  {
    parent::__construct();
    $this->model = new PortalModel();
    $userPermissions = CurrentUser::getInstance()->getPermissions();
    if($userPermissions['can_manage_settings'] == false || $userPermissions['can_manage_portals'] == false)
    {
      Route::redirect('/logout');
    }
  }

  public function actionNew()
  {
    $data = CurrentUser::getInstance()->getCommonData();
    $this->view->generate('portal.new', $data);
  }

  public function actionAdd()
  {
    if(!isset($_POST['name'], $_POST['api_url'], $_POST['api_login'], $_POST['api_pass']))
    {
      throw new UserInputException(UserInputException::message('empty_value'), UserInputException::EMPTY_INPUT);
    }
    CSRF::checkToken();
    $this->model->setName($_POST['name'])
                      ->setApiUrl($_POST['api_url'])
                      ->setApiLogin($_POST['api_login'])
                      ->setApiPassword($_POST['api_pass']);
    PortalModel::save($this->model);

    Route::redirect("/portals");
  }

  public function actionEdit($id)
  {
    if(isset($_POST['name'], $_POST['api_url'], $_POST['api_login'], $_POST['api_pass']))
    {
      CSRF::checkToken();
      $this->model->setId($id)
                  ->setName($_POST['name'])
                  ->setApiUrl($_POST['api_url'])
                  ->setApiLogin($_POST['api_login'])
                  ->setApiPassword($_POST['api_pass']);
      PortalModel::save($this->model);
      Route::redirect("/portals");
    }

    $data = array_merge(CurrentUser::getInstance()->getCommonData(), PortalModel::getById($id));
    $this->view->generate('portal.edit', $data);
  }

  public function actionDelete($id)
  {
    PortalModel::deleteById($id);
    Route::redirect("/portals");
  }

  public function actionList()
  {
    $data = CurrentUser::getInstance()->getCommonData();
    $data['portals'] = PortalModel::getAll();
    $this->view->generate('portals', $data);
  }
}

 ?>
