<?php

use Core\CurrentUser;

class DatatablesController extends Controller
{
  private $db;

  public function __construct()
  {
    parent::__construct();
    $creds = Config::getSection('database');
    $this->db['user'] = $creds['user'];
    $this->db['pass'] = $creds['pass'];
    $this->db['db'] = $creds['name'];
    $this->db['host'] = $creds['host'];
  }

  public function actionPayments()
  {
    $userId = CurrentUser::getInstance()->getId();
    $table = 'transactions';
    $primaryKey = 'id';
    $columns = [
      [
        'db' => "$table.id",
        'dt' => 0,
        'field' => 'id',
      ],
      [
        'db' => "$table.payment_system",
        'dt' => 1,
        'field' => 'payment_system',
      ],
      [
        'db' => "$table.status",
        'dt' => 2,
        'field' => 'status',
      ],
      [
        'db' => "$table.txn_type",
        'dt' => 3,
        'field' => 'txn_type',
      ],
      [
        'db' => "$table.price",
        'dt' => 4,
        'field' => 'price',
      ],
      [
        'db' => "$table.currency",
        'dt' => 5,
        'field' => 'currency',
      ],
      [
        'db' => "$table.date",
        'dt' => 6,
        'field' => 'date',
      ],
      [
        'db' => "users.name",
        'dt' => 7,
        'as' => 'user',
        'field' => 'user',
      ],
      [
        'db' => 'IF(devices.hardware_id != "", devices.hardware_id, devices.login)',
        'dt' => 8,
        'as' => 'device',
        'field' => 'device'
      ],
      [
        'db' => "$table.device_id",
        'dt' => 9,
        'field' => 'device_id',
      ],
    ];
    $join = "FROM `$table` JOIN `devices` ON `$table`.`device_id` = `devices`.`id` JOIN `users` ON `$table`.`user_id` = `users`.`id`";
    $permissions = CurrentUser::getInstance()->getPermissions();
    ($permissions['payment_history'] == true) ? $where = '' : $where = "($table.`user_id` = $userId)";
    echo json_encode(SSP::simple($_GET, $this->db, $table, $primaryKey, $columns, $join, $where));
  }

  public function actionTransactions()
  {
    $userId = CurrentUser::getInstance()->getId();
    $table = 'transactions';
    $primaryKey = 'id';
    $columns = [
      [
        'db' => "$table.id",
        'dt' => 0,
        'field' => 'id',
      ],
      [
        'db' => "$table.payment_system",
        'dt' => 1,
        'field' => 'payment_system',
      ],
      [
        'db' => "$table.status",
        'dt' => 2,
        'field' => 'status',
      ],
      [
        'db' => "$table.txn_type",
        'dt' => 3,
        'field' => 'txn_type',
      ],
      [
        'db' => "$table.price",
        'dt' => 4,
        'field' => 'price',
      ],
      [
        'db' => "$table.currency",
        'dt' => 5,
        'field' => 'currency',
      ],
      [
        'db' => "$table.date",
        'dt' => 6,
        'field' => 'date',
      ],
      [
        'db' => "users.name",
        'dt' => 7,
        'as' => 'user',
        'field' => 'user',
      ],
      [
        'db' => 'IF(devices.hardware_id != "", devices.hardware_id, devices.login)',
        'dt' => 8,
        'as' => 'device',
        'field' => 'device'
      ],
      [
        'db' => "$table.device_id",
        'dt' => 9,
        'field' => 'device_id',
      ],
    ];
    $join = "FROM `$table` JOIN `devices` ON `$table`.`device_id` = `devices`.`id` JOIN `users` ON `$table`.`user_id` = `users`.`id`";
    $where = "($table.`user_id` = $userId)";
    echo json_encode(SSP::simple($_GET, $this->db, $table, $primaryKey, $columns, $join, $where));
  }

}

 ?>
