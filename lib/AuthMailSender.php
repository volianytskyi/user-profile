<?php

use PHPMailer\PHPMailer\PHPMailer as Mailer;

class AuthMailSender
{
  private $mailer;
  private $user;
  private $subject;
  private $message;

  public function __construct(Mailer $mailer, TempUserInterface $user)
  {
    $this->mailer = $mailer;
    $this->user = $user;
    $this->subject = sprintf(_("%s Registration Confirmation"), PROJECT_NAME);
    $this->setMessage();
    $this->setMailer();
  }

  private function setMessage()
  {
    $template = _("Dear %s!\n\n" .
    "Please, follow the link to complete the registration or just do nothing if you did not have to receive this message: \n\n" .
    "%s\n\n" .
    "Your login credits: \n" .
    "\tlogin: %s\n" .
    "\tpassword: %s\n\n" .
    "Note, the link is valid until %s\n\n" .
    'Please, do not reply on this message.');

    $this->message = sprintf(
      $template,
      $this->user->getName(),
      PROJECT_URL.Locale::getCurrent().'/login/'.$this->user->getToken(),
      $this->user->getLogin(),
      $this->user->getPassword(),
      $this->user->getExpireDate()
    );
  }

  private function setMailer()
  {
    $this->mailer->addAddress($this->user->getEmail(), $this->user->getName());
    $this->mailer->Subject = $this->subject;
    $this->mailer->Body = $this->message;
  }

  public function send()
  {
    $this->mailer->send();
  }

}

 ?>
