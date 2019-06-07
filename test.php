<?php
require_once 'src/core.php';

$check = $db_duong->select('user_id')->from(_DB_TABLE_USERS)->where(['user_name' => 'xdongnv', 'user_password' => md5('123456')])->fetch_first();

print_r($check);