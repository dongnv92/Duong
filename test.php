<?php
require_once 'src/core.php';

if($db_duong->select('user_id')->from(_DB_TABLE_USERS)->where('user_id', 1)->fetch_first()){
    echo "Có";
}else{
    echo "Không";
}