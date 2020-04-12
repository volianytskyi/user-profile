<?php

use Core\CurrentUser;
use Exceptions\UserInputException;
use Exceptions\AuthException;
use Mail\C200PlusTvFactory as MailBoxFactory;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class LoginController extends Controller
{
  public function actionIndex()
  {
    $currentUser = CurrentUser::getInstance();
    Route::redirect('/'.Locale::getCurrent().'/dashboard');
  }

  public function actionLogin()
  {
    $data = [
      'secure_token' => CSRF::createToken(),
      'locales' => Locale::getAllowed(),
      'current_locale' => Locale::getCurrent()
    ];
    $this->view->generate('login', $data);
  }

  public function actionAuthorize()
  {
    if(!isset($_POST['login'], $_POST['password']))
    {
      throw new UserInputException(UserInputException::message('both_login_password'), UserInputException::EMPTY_INPUT);
    }

    CSRF::checkToken();

    UserModel::authorize($_POST['login'], $_POST['password']);
    Route::redirect('/'.Locale::getCurrent());
  }

  public function actionLogout()
  {
    $keys = [
      SESSION_ID_KEY,
      CSRF_TOKEN_KEY
    ];

    $locale = Locale::getCurrent();

    foreach ($keys as $key)
    {
      unset($_SESSION[$key]);
    }

    Route::redirect("/$locale/login");
  }

  public function actionRestore()
  {
    if(isset($_POST['email']))
    {
      $restorator = new PasswordRestorator(PHPMailerFactory::create(new MailBoxFactory()), $_POST['email']);
      $restorator->init();

      try {
        $restorator->send();
      } catch (PHPMailerException $e) {
        error_log($e->getMessage());
        $data['message'] = _("Unfortunately, confirmation e-mail was not sent. Please, try again later");
        $this->view->generate('registration.info', $data);
      }

      $data['message'] = sprintf(_("New password has been sent to %s"), $_POST['email']);
      $this->view->generate('registration.info', $data);
    }
    else
    {
      $data = [
        'secure_token' => CSRF::createToken(),
        'locales' => Locale::getAllowed(),
        'current_locale' => Locale::getCurrent()
      ];

      $this->view->generate('restore', $data);
    }

  }

}


 ?>
