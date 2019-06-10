<?php
require_once '../core.php';
header('Content-Type: text/html; charset=utf-8');

if(!$token){
    $response = ['response'  => 404,'message'   => 'Missing Token'];
    echo json_encode($response);
    exit();
}

if(!$function_duong->checkToken($token)){
    $response = ['response'  => 401,'message'   => 'Invalid token code'];
    echo json_encode($response);
    exit();
}

switch ($act){
    case 'bill':
        switch ($type){
            case 'add':
                $bill_handbag   = isset($_POST['bill_handbag'])     && !empty($_POST['bill_handbag'])   ? $_POST['bill_handbag']    : '';
                $bill_sizedbag  = isset($_POST['bill_sizedbag'])    && !empty($_POST['bill_sizedbag'])  ? $_POST['bill_sizedbag']   : '';
                $bill_amount    = isset($_POST['bill_amount'])      && !empty($_POST['bill_amount'])    ? $_POST['bill_amount']     : '';
                $bill_price     = isset($_POST['bill_price'])       && !empty($_POST['bill_price'])     ? $_POST['bill_price']      : '';
                $bill_note      = isset($_POST['bill_note'])        && !empty($_POST['bill_note'])      ? $_POST['bill_note']       : '';
                $bill_type      = isset($_POST['bill_type'])        && !empty($_POST['bill_type'])      ? $_POST['bill_type']       : '';
                $bill_customer  = isset($_POST['bill_customer'])    && !empty($_POST['bill_customer'])  ? $_POST['bill_customer']   : '';
                $bill_user      = isset($_POST['bill_user'])        && !empty($_POST['bill_user'])      ? $_POST['bill_user']       : '';

                if(!$bill_handbag){
                    echo json_encode(['response' => 404, 'message' => 'Bạn chưa nhập loại túi']);
                    break;
                }
                if(!$db_duong->select('metadata_id')->from(_DB_TABLE_METADATA)->where(['metadata_id' => $bill_handbag, 'metadata_type' => 'handbag'])->fetch_first()){
                    echo json_encode(['response' => 404, 'message' => 'Loại túi không tồn tại']);
                    break;
                }
                if(!$bill_sizedbag){
                    echo json_encode(['response' => 404, 'message' => 'Bạn chưa nhập kích thước túi']);
                    break;
                }
                if(!$db_duong->select('metadata_id')->from(_DB_TABLE_METADATA)->where(['metadata_id' => $bill_handbag, 'metadata_type' => 'sizebag'])->fetch_first()){
                    echo json_encode(['response' => 404, 'message' => 'Kích thước túi không tồn tại']);
                    break;
                }
                if(!$bill_amount){
                    echo json_encode(['response' => 404, 'message' => 'Bạn chưa nhập số lượng']);
                    break;
                }
                if(!$bill_price){
                    echo json_encode(['response' => 404, 'message' => 'Bạn chưa nhập giá']);
                    break;
                }
                if(!in_array($bill_type, ['buy', 'sell'])){
                    echo json_encode(['response' => 404, 'message' => 'Kiểu Bill không đúng định dạng']);
                    break;
                }
                if(!$db_duong->select('user_id')->from(_DB_TABLE_USERS)->where('user_id', $bill_user)->fetch_first()){
                    echo json_encode(['response' => 404, 'message' => 'Người lập hóa đơn không tổn tại']);
                    break;
                }
                if($bill_customer && !$db_duong->select('customer_id')->from(_DB_TABLE_CUSTOMER)->where('customer_id', $bill_customer)->fetch_first()){
                    echo json_encode(['response' => 404, 'message' => 'Người lập hóa đơn không tổn tại']);
                    break;
                }
                $data = [
                    'bill_type'         => $bill_type,
                    'bill_customer'     => $bill_customer,
                    'bill_handbag'      => $bill_handbag,
                    'bill_sizebag'      => $bill_sizedbag,
                    'bill_amount'       => $bill_amount,
                    'bill_price'        => $bill_price,
                    'bill_total_price'  => (($bill_amount*$bill_price)/1000),
                    'bill_user'         => $bill_user,
                    'bill_note'         => $bill_note,
                    'bill_time'         => _CONFIG_DATETIME
                ];
                if(!$db_duong->insert(_DB_TABLE_BILL, $data)){
                    echo json_encode(['response' => 404, 'message' => 'Lỗi SQL khi thêm hóa đơn']);
                    break;
                }
                echo json_encode(['response' => 404, 'message' => 'Người lập hóa đơn không tổn tại']);
                break;
            default:
                echo json_encode(['response' => 404, 'message' => 'Action Bill không được hỗ trợ']);
                break;
        }
        break;
    case 'customer':
        switch ($type){
            case 'add':
                $customer_name      = isset($_POST['customer_name'])    && !empty($_POST['customer_name'])      ? trim($_POST['customer_name'])     : '';
                $customer_address   = isset($_POST['customer_address']) && !empty($_POST['customer_address'])   ? trim($_POST['customer_address'])  : '';
                $customer_phone     = isset($_POST['customer_phone'])   && !empty($_POST['customer_phone'])     ? trim($_POST['customer_phone'])    : '';
                $customer_handbag   = isset($_POST['customer_handbag']) && !empty($_POST['customer_handbag'])   ? trim($_POST['customer_handbag'])  : 0;
                $customer_sizedbag  = isset($_POST['customer_sizedbag'])&& !empty($_POST['customer_sizedbag'])  ? trim($_POST['customer_sizedbag']) : 0;
                if(!$customer_name){
                    $response = ['response' => 404, 'Thiếu trường tên khách hàng'];
                    echo  json_encode($response);
                    break;
                }
                $data = [
                    'customer_name'     => $customer_name,
                    'customer_address'  => $customer_address,
                    'customer_phone'    => $customer_phone,
                    'customer_handbag'  => $customer_handbag,
                    'customer_sizebag'  => $customer_sizedbag,
                    'customer_time'     => _CONFIG_DATETIME
                ];
                if(!$db_duong->insert(_DB_TABLE_CUSTOMER, $data)){
                    $response = ['response' => 500, 'Lỗi SQL khi thêm khách hàng'];
                    echo  json_encode($response);
                    break;
                }
                $response = ['response' => 200, 'Thêm khách hàng thành công'];
                echo  json_encode($response);
                break;
            case 'delete':
                if(!$id){
                    $response = ['response' => 404, 'message' => 'Không tồn tại mã ID khách hàng này.'];
                    echo json_encode($response);
                    break;
                }
                $check = $db_duong->select('customer_id')->from(_DB_TABLE_CUSTOMER)->where('customer_id', $id)->fetch_first();
                if(!$check){
                    $response = ['response' => 404, 'message' => 'Khách hàng này không tồn tại.'];
                    echo json_encode($response);
                    break;
                }
                if(!$db_duong->delete(_DB_TABLE_CUSTOMER)->where('customer_id', $id)->execute()){
                    $response = ['response' => 500, 'message' => 'Lỗi SQL khi xóa khách hàng này.'];
                    echo json_encode($response);
                    break;
                }
                $response = ['response' => 200, 'message' => 'Xóa khách hàng thành công.'];
                echo json_encode($response);
                break;
            case 'update':
                $customer_name      = isset($_POST['customer_name'])    && !empty($_POST['customer_name'])      ? trim($_POST['customer_name'])     : '';
                $customer_address   = isset($_POST['customer_address']) && !empty($_POST['customer_address'])   ? trim($_POST['customer_address'])  : '';
                $customer_phone     = isset($_POST['customer_phone'])   && !empty($_POST['customer_phone'])     ? trim($_POST['customer_phone'])    : '';
                $customer_handbag   = isset($_POST['customer_handbag']) && !empty($_POST['customer_handbag'])   ? trim($_POST['customer_handbag'])  : 0;
                $customer_sizedbag  = isset($_POST['customer_sizedbag'])&& !empty($_POST['customer_sizedbag'])  ? trim($_POST['customer_sizedbag']) : 0;

                if(!$customer_name){
                    echo json_encode(['response' => 404, 'message' => 'Tên khách hàng không được để trống']);
                    break;
                }
                $check = $db_duong->select()->from(_DB_TABLE_CUSTOMER)->where('customer_id', $id)->fetch_first();
                if(!$check){
                    echo json_encode(['response' => 404, 'message' => 'Khách hàng không tồn tại.']);
                    break;
                }
                $data = [
                    'customer_name'     => $customer_name,
                    'customer_address'  => $customer_address,
                    'customer_phone'    => $customer_phone,
                    'customer_handbag'  => $customer_handbag,
                    'customer_sizebag'  => $customer_sizedbag
                ];
                if(!$db_duong->where('customer_id', $id)->update(_DB_TABLE_CUSTOMER, $data)){
                    echo json_encode(['response' => 500, 'message' => 'Lỗi SQL khi sửa khách hàng.']);
                    break;
                }
                echo json_encode(['response' => 200, 'message' => 'Sửa khách hàng thành công.']);
                break;
            default:
                $response = ['response' => 404, 'Type Customer không được hỗ trợ'];
                echo  json_encode($response);
                break;
        }
        break;
    case 'metadata':
        switch ($type){
            case 'getalldata':
                $metadataType   = isset($_GET['metadata_type']) ? trim($_GET['metadata_type']) : '';
                $data           = $db_duong->from(_DB_TABLE_METADATA)->where('metadata_type',$metadataType)->fetch();
                $response       = [
                    'response'  => 200,
                    'data'      => $data
                ];
                echo json_encode($response);
                break;
            case 'add':
                $metadataType  = isset($_POST['metadata_type'])    ? trim($_POST['metadata_type']) : '';
                $metadata_name = isset($_POST['metadata_name'])    ? trim($_POST['metadata_name']) : '';
                switch ($metadataType){
                    case in_array($metadataType, ['handbag', 'sizebag']):
                        if(!$metadata_name){
                            $response = ['response'  => 404,'message'   => 'Thiếu trường Metadata Name. Vui lòng thử lại'];
                            echo json_encode($response);
                            break;
                        }
                        $data = [
                            'metadata_type' => $metadataType,
                            'metadata_name' => $metadata_name,
                            'metadata_des'  => '',
                            'metadata_sub'  => 0,
                            'metadata_rule' => '',
                            'metadata_time' => _CONFIG_DATETIME
                        ];
                        if(!$db_duong->insert(_DB_TABLE_METADATA, $data)){
                            $response = ['response'  => 500,'message'   => 'Lỗi SQL trong khi thêm dữ liệu.'];
                            echo json_encode($response);
                            break;
                        }
                        $response = [
                            'response'  => 200,
                            'message'   => 'Thêm dữ liệu thành công.',
                            'url'       => _CONFIG_URL_HOME.'/metadata.php?act='.$metadataType
                        ];
                        echo json_encode($response);
                        break;
                    default:
                        $response = ['response' => 404, 'message' => 'Metadata Type không được hỗ trợ'];
                        echo json_encode($response);
                        break;
                }
                break;
            case 'delete':
                $metadataType   = isset($_POST['metadata_type']) ? trim($_POST['metadata_type']) : '';
                if(!$id || !$metadataType){
                    $response = ['response' => 404, 'message' => 'Thiếu trường ID hoặc Metadata Type'];
                    echo json_encode($response);
                    break;
                }
                $check          = $db_duong->select()->from(_DB_TABLE_METADATA)->where(['metadata_type' => $metadataType, 'metadata_id' => $id])->fetch_first();
                if(!$check){
                    $response = ['response'  => 404,'message'   => 'Hand Bag not Available.'];
                    echo json_encode($response);
                    break;
                }
                if(!$db_duong->delete(_DB_TABLE_METADATA)->where(['metadata_type' => $metadataType, 'metadata_id' => $id])->execute()){
                    $response = ['response'  => 500,'message'   => 'Lỗi SQL xóa Metadata '];
                    echo json_encode($response);
                    break;
                }
                $response = ['response'  => 200,'message'   => 'Xóa dữ liệu thành công'];
                echo json_encode($response);
                break;
            case 'update':
                $metadataType   = isset($_POST['metadata_type'])    ? trim($_POST['metadata_type']) : '';
                $metadataName   = isset($_POST['metadata_name'])    ? trim($_POST['metadata_name']) : '';
                if(!$id || !$metadataType || !$metadataName){
                    $text = '';
                    if(!$id){
                        $text = ' ID ';
                    }
                    if(!$metadataType){
                        $text = ' TYPE : '.$metadataType;
                    }
                    if(!$metadataName){
                        $text = ' NAME ';
                    }
                    $response = ['response' => 404, 'message' => 'Thiếu trường ID hoặc Metadata Name hoặc Metadata Type: '.$text];
                    echo json_encode($response);
                    break;
                }
                $check          = $db_duong->from(_DB_TABLE_METADATA)->where(['metadata_id' => $id, 'metadata_type' => $metadataType])->fetch_first();
                if(!$check){
                    $response = ['response' => 404,'message'=> 'Không có dữ liệu. Vui lòng thử lại'];
                    echo json_encode($response);
                    break;
                }
                $data = ['metadata_name' => $metadataName];
                if(!$db_duong->where(['metadata_id' => $id, 'metadata_type' => $metadataType])->update(_DB_TABLE_METADATA, $data)){
                    $response = ['response'  => 500,'message'   => 'Error Update Hand Bag SQL.'];
                    echo json_encode($response);
                    break;
                }
                $response = ['response'  => 200,'message'   => 'Cập nhật dữ liệu thành công.'];
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