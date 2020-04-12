<?php

use PHPMailer\PHPMailer\PHPMailer;
use Mail\MailBoxFactoryInterface;

class PHPMailerFactory
{
  public static function create(MailBoxFactoryInterface $mailFactory)
  {
    $credits = $mailFactory->getCredits();
    $smtp = $mailFactory->getSmtpSettings();

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host = $smtp->getHost();
    $mail->SMTPAuth = $smtp->getAuth();
    $mail->Username = $credits->getLogin();
    $mail->Password = $credits->getPassword();
    $mail->SMTPSecure = $smtp->getSecurityOption();
    $mail->Port = $smtp->getPort();
    $mail->setFrom($credits->getAddress(), $credits->getName());
    return $mail;
  }
}

 ?>
