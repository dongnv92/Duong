<?php
require_once('src/core.php');
session_destroy();
setcookie('user', '');
setcookie('pass', '');
header("location:"._CONFIG_URL_HOME);