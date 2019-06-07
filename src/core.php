<?php

/*
 *  200 : Success
    400 : Bad request — dữ liệu gửi lên không hợp lệ
    401 : Unauthorized — user chưa được xác thực và truy cập vào resource yêu cầu phải xác thực
    403: Forbidden — user không có quyền truy cập vào resource
    404: Not found — không tồn tại resource
500: Internal Server Error — có lỗi xẩy ra trong hệ thống
 * */

session_start();
error_reporting(0);
set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once 'class/function.php';
require_once 'class/class.mysqli.db.php';

define('_CONFIG_TIME', time());
define('_CONFIG_DATETIME', date('Y-m-d H:i:s', _CONFIG_TIME));
define('_CONFIG_TIMETOKEN', 600);
define('_CONFIG_TOKEN_KEYSTART', 'DONG');
define('_CONFIG_TOKEN_KEYSEND', 'CHINH');
define('_CONFIG_URL_HOME', 'http://localhost/dong/duong');
define('_CONFIG_URL_API', _CONFIG_URL_HOME.'/api/');

define('_DB_HOST', 'localhost');
define('_DB_USERNAME', 'root');
define('_DB_PASSWORD', '');
define('_DB_DATABASE', 'duong');

define('_DB_TABLE_USERS', 'dong_users');

$function_duong = new functionDuong();
$db_duong       = new Database(_DB_HOST, _DB_USERNAME, _DB_PASSWORD, _DB_DATABASE);


/** Kiểm tra cookie */
if ($_COOKIE['user'] && $_COOKIE['pass']) {
    $_SESSION['user'] = $_COOKIE['user'];
    $_SESSION['pass'] = $_COOKIE['pass'];
}

/** Kiểm tra tồn tại của tên đăng nhập và mật khẩu  */
if ($_SESSION['user'] && $_SESSION['pass']) {
    $user = $db->from(_DB_TABLE_USERS)->where(['user_id' => $_SESSION['user'], 'user_password' => $_SESSION['pass']])->fetch_first();
    if(!$user){
        unset ($_SESSION['user']);
        unset ($_SESSION['pass']);
        setcookie('user', '');
        setcookie('pass', '');
    }
}

$submit = (isset($_POST['submit'])      && !empty($_POST['submit']))    ? trim($_POST['submit'])    : false;
$id     = (isset($_REQUEST['id'])       && !empty($_REQUEST['id']))     ? (int) $_REQUEST['id']     : false;
$act    = (isset($_REQUEST['act'])      && !empty($_REQUEST['act']))    ? $_REQUEST['act']          : false;
$type   = (isset($_REQUEST['type'])     && !empty($_REQUEST['type']))   ? $_REQUEST['type']         : false;
$url    = (isset($_REQUEST['url'])      && !empty($_REQUEST['url']))    ? trim($_REQUEST['url'])    : false;
$token  = (isset($_REQUEST['token'])    && !empty($_REQUEST['token']))  ? trim($_REQUEST['token'])  : false;