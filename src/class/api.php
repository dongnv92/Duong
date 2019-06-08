<?php
require_once '../core.php';
header('Content-Type: text/html; charset=utf-8');

if(!$token){
    $response = [
        'response'  => 404,
        'message'   => 'Missing Token'
    ];
    echo json_encode($response);
    exit();
}

if(!$function_duong->checkToken($token)){
    $response = [
        'response'  => 401,
        'message'   => 'Invalid token code'
    ];
    echo json_encode($response);
    exit();
}

switch ($act){
    case 'metadata':
        switch ($type){
            case 'handbag_add':
                $handbagname = isset($_POST['handbagname']) ? trim($_POST['handbagname']) : '';
                if(!$handbagname){
                    $response = ['response'  => 404,'message'   => 'Missing Hangbag Name.'];
                    echo json_encode($response);
                    break;
                }
                $data = [
                    'metadata_type' => 'handbag',
                    'metadata_name' => $handbagname,
                    'metadata_des'  => '',
                    'metadata_sub'  => 0,
                    'metadata_rule' => '',
                    'metadata_time' => _CONFIG_DATETIME
                ];
                if(!$db_duong->insert(_DB_TABLE_METADATA, $data)){
                    $response = ['response'  => 500,'message'   => 'Error add Hand Bag SQL.'];
                    echo json_encode($response);
                    break;
                }
                $response = ['response'  => 200,'message'   => 'Add Handbag Success.'];
                echo json_encode($response);
                break;
            case 'handbag_delete':
                $check = $db_duong->select()->from(_DB_TABLE_METADATA)->where(['metadata_type' => 'handbag', 'metadata_id' => $id])->fetch_first();
                if(!$check){
                    $response = ['response'  => 404,'message'   => 'Hand Bag not Available.'];
                    echo json_encode($response);
                    break;
                }
                if(!$db_duong->delete(_DB_TABLE_METADATA)->where(['metadata_type' => 'handbag', 'metadata_id' => $id])->execute()){
                    $response = ['response'  => 500,'message'   => 'Delete Hand Bag Error SQL.'];
                    echo json_encode($response);
                    break;
                }
                $response = ['response'  => 200,'message'   => 'Delete Hand Bag Success'];
                echo json_encode($response);
                break;
            default:
                $response = [
                    'response'  => 404,
                    'message'   => 'Type Metadata does not exist.'
                ];
                echo json_encode($response);
                break;
        }
        break;
    case 'authencation':
        switch ($type){
            case 'check_login':
                $login_user = isset($_GET['login_user']) ? trim($_GET['login_user']) : '';
                $login_pass = isset($_GET['login_pass']) ? trim($_GET['login_pass']) : '';
                $login_reme = isset($_GET['login_reme']) ? trim($_GET['login_reme']) : '';
                // Kiểm tra xem nhập đủ các trường chưa
                if(!$login_pass || !$login_user){
                    $response = [
                        'response'  => 404,
                        'message'   => 'Missing User Or Password.'
                    ];
                    echo json_encode($response);
                    break;
                }
                $check = $db_duong->select('user_id, user_password')->from(_DB_TABLE_USERS)->where(['user_name' => $login_user, 'user_password' => md5($login_pass)])->fetch_first();
                // Kiểm tra xem tên đăng nhập đúng hay sai
                if(!$check){
                    $response = [
                        'response'  => 401,
                        'message'   => 'Username or password is wrong. Please try again.'
                    ];
                    echo json_encode($response);
                    break;
                }
                if($login_reme == 1){
                    setcookie("user", $check['user_id'], time() + 30*24*60*60);
                    setcookie('pass', $check['user_password'],time() + 30*24*60*60);
                    $_SESSION['user'] = $check['user_id'];
                    $_SESSION['pass'] = $check['user_password'];
                }else{
                    $_SESSION['user'] = $check['user_id'];
                    $_SESSION['pass'] = $check['user_password'];
                }
                $response = [
                    'response'  => 200,
                    'message'   => 'Login Successfull ...'
                ];
                echo json_encode($response);
                break;
            default:
                $response = [
                    'response'  => 404,
                    'message'   => 'Type Authencation does not exist.'
                ];
                echo json_encode($response);
                break;
        }
        break;
    default:
        $response = [
            'response'  => 404,
            'message'   => 'Action does not exist.'
        ];
        echo json_encode($response);
        break;
}