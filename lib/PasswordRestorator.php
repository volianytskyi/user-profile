<?php

use Exceptions\NotFoundException;
use Exceptions\RegistrationException;
use PHPMailer\PHPMailer\PHPMailer as Mailer;

class PasswordRestorator
{
  private $userModel;
  private $password;
  private $mailer;
  private $inited;

  public function __construct(Mailer $mailer, $recipientEmail)
  {
    $this->mailer = $mailer;
    $userData = UserModel::getByEmail($recipientEmail);
    if(empty($userData))
    {
      throw new NotFoundException(UserInput::validateEmail($recipientEmail) . " not found", NotFoundException::USER_NOT_EXIST);
    }
    $this->userModel = new UserModel();
    $this->userModel->setTrustedData($userData);

    $this->password = new UserPassword();

    $this->inited = false;
  }

  private function generateNewPassword()
  {
    $this->userModel->setPassword($this->password->generate());
  }

  public function send()
  {
    if($this->inited == false)
    {
      throw new RegistrationException(print_r($this, true), RegistrationException::MAIL_SENDER_NOT_INITED);
    }
    $this->mailer->send();
  }

  private function getMessage()
  {
    $user = $this->userModel->getData();
    $template = _("Dear %s!\n\n" .
      "Please, enter the next credits to authorize in %s \n" .
      "\tlogin: %s\n" .
      "\tpassword: %s\n\n" .
      'Please, do not reply on this message.'
    );
    return sprintf($template, $user['name'], PROJECT_URL.Locale::getCurrent().'/login/', $user['email'], $this->password->getCleanPassword());
  }

  private function getSubject()
  {
    return sprintf(_("%s Password Restoration"), PROJECT_NAME);
  }

  public function init()
  {
    $this->generateNewPassword();
    $user = $this->userModel->getData();
    $this->mailer->addAddress($user['email'], $user['name']);
    $this->mailer->Subject = $this->getSubject();
    $this->mailer->Body = $this->getMessage();
    UserModel::save($this->userModel);
    $this->inited = true;
  }
}

 ?>
