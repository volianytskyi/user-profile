<?php

namespace Mail;

interface MailBoxFactoryInterface
{
  /**
  *
  * @return EmailCreditsInterface
  */
  public function getCredits();

  /**
  *
  * @return SmtpInterface
  */
  public function getSmtpSettings();
}

 ?>
