<?php

use Core\CurrentUser;
use Exceptions\UserInputException;
use Exceptions\RegistrationException as RegException;
use Mail\C200PlusTvFactory as MailBoxFactory;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class RegistrationController extends Controller
{
  public function actionIndex()
  {
    $data = [
      'secure_token' => CSRF::createToken(),
      'locales' => Locale::getAllowed(),
      'current_locale' => Locale::getCurrent()
    ];
    $this->view->generate('registration', $data);
  }

  public function actionRegister()
  {
    CSRF::checkToken();
    if(!isset($_POST['name'], $_POST['email']))
    {
      throw new UserInputException(UserInputException::message('both_name_email'), UserInputException::EMPTY_INPUT);
    }

    if(!empty(UserModel::getByEmail($_POST['email'])))
    {
      throw new RegException($_POST['email'], RegException::ALREADY_REGISTERED);
    }

    $tempUser = TempUserModel::init($_POST['name'], $_POST['email']);
    TempUserModel::save($tempUser);

    $sender = new AuthMailSender(PHPMailerFactory::create(new MailBoxFactory()), new TempUser($tempUser));

    $data = [
      'locales' => Locale::getAllowed(),
      'current_locale' => Locale::getCurrent()
    ];

    try {
      $sender->send();
    } catch (PHPMailerException $e) {
      error_log($e->getMessage());
      $data['message'] = _("Unfortunately, confirmation e-mail was not sent. Please, try again later");
      $this->view->generate('registration.info', $data);
    }

    $data['message'] = sprintf(_("Confirmation letter has been sent to %s <br/>Please follow the instructions to complete the registration"), $tempUser->getEmail());
    $this->view->generate('registration.info', $data);

  }

  public function actionLogin($token)
  {
    $tempUser = TempUserModel::getByToken($token);
    if(empty($tempUser) || time() > strtotime($tempUser['expire_date']))
    {
      throw new RegException("$token expired", RegException::TOKEN_EXPIRED);
    }

    $data = [
      'secure_token' => CSRF::createToken(),
      'locales' => Locale::getAllowed(),
      'current_locale' => Locale::getCurrent()
    ];
    $this->view->generate('sign_in', $data);
  }

  public function actionSignIn()
  {
    CSRF::checkToken();
    if(!isset($_POST['login'], $_POST['password']))
    {
      throw new UserInputException(UserInputException::message('both_login_password'), UserInputException::EMPTY_INPUT);
    }
    if(TempUserModel::firstSignIn($_POST['login'], $_POST['password']) == false)
    {
      Route::redirect('/logout');
    }
    Route::redirect('/profile');
  }
}


 ?>
