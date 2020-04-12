<?php

use Core\CurrentUser;

class TransactionsController extends Controller
{
  public function actionList()
  {
    $currentUser = CurrentUser::getInstance();
    $data = $currentUser->getCommonData();
    $this->view->generate('transactions', $data);
  }
}


 ?>
