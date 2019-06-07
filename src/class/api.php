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
                $check = $db_duong->select('user_id')->from(_DB_TABLE_USERS)->where(['user_name' => $login_user, 'user_password' => md5($login_pass)])->fetch_first();
                // Kiểm tra xem tên đăng nhập đúng hay sai
                if(!$check){
                    $response = [
                        'response'  => 401,
                        'message'   => 'Tên đăng nhập hoặc mật khẩu sai.'
                    ];
                    echo json_encode($response);
                    break;
                }
                $response = [
                    'response'  => 200,
                    'message'   => 'Đăng nhập thành công'
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