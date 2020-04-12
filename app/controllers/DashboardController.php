<?php
use Core\CurrentUser;
class DashboardController extends Controller
{
  public function actionIndex()
  {
    $currentUser = CurrentUser::getInstance();
    $data = $currentUser->getCommonData();

    $this->view->generate('dashboard', $data);
  }
}

 ?>
