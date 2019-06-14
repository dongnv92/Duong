<?php
require_once('src/core.php');
session_destroy();
setcookie('user', '');
setcookie('pass', '');
$user = false;
header("location:"._CONFIG_URL_HOME);