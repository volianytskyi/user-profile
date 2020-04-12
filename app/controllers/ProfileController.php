<?php

use Core\CurrentUser;
use Exceptions\UserInputException;

class ProfileController extends Controller
{
  public function actionIndex()
  {
    $data = CurrentUser::getInstance()->getCommonData();
    $this->view->generate('profile', $data);
  }

  public function actionSave()
  {
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      CSRF::checkToken();

      if(!isset($_POST['username']))
      {
        throw new UserInputException(UserInputException::message('username_required'), UserInputException::EMPTY_INPUT);
      }
      if(isset($_POST['password']) || isset($_POST['password2']))
      {
        if(!isset($_POST['password']) || !isset($_POST['password2']) || $_POST['password'] !== $_POST['password2'])
        {
          throw new UserInputException(UserInputException::message('password_twice'), UserInputException::PASSWORD_MISMATCH);
        }
        $userData = UserModel::getById(CurrentUser::getInstance()->getId());
        $user = new UserModel();
        $user->setTrustedData($userData)
             ->setPassword($_POST['password'])
             ->setName($_POST['username']);
        UserModel::save($user);
      }
    }

    Route::redirect('/profile');
  }

}


 ?>
