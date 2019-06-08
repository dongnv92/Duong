<?php
/**
 * Created by PhpStorm.
 * User: nguye
 * Date: 19/09/2018
 * Time: 20:34
 */
require_once 'src/core.php';

if(!$user){
    $function_duong->redirectUrl(_CONFIG_URL_LOGIN);
}

$header['title'] = 'Trang quản trị';
require_once 'header.php';

require_once 'footer.php';