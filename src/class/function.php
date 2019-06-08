<?php

class functionDuong{

    public function redirectUrl($url){
        return header('location:'.$url);
    }

    // Tạo Mã Token
    public function createToken(){
        return md5(md5(_CONFIG_TOKEN_KEYSTART._CONFIG_TIME._CONFIG_TOKEN_KEYSEND));
    }

    // Kiểm tra mã token
    public function checkToken($token){
        $arr_token = array();
        for ($i = 0; $i <= _CONFIG_TIMETOKEN; $i++){
            $time_c         = _CONFIG_TIME - $i;
            $arr_token[]    = md5(md5(_CONFIG_TOKEN_KEYSTART.$time_c._CONFIG_TOKEN_KEYSEND));
        }
        if(in_array($token, $arr_token)){
            return true;
        }else{
            return false;
        }
    }
}


