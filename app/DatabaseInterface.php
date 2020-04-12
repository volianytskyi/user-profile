<?php

interface DatabaseInterface
{
  public function delete($table, $key, $value);
  public function insert($table, array $data);
  public function update($table, array $data, $key = 'id');
  public function insertOrUpdate($table, array $data, array $keys = ['id']);
  public function fetch($query, $args = []);
  public function fetchAll($query, $args = []);
  public function fetchColumn($query, $args = []);
  public function execute($query, $args = []);
}


 ?>
