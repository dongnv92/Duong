<?php
require_once '../core.php';
header('Content-type: application/javascript');

switch ($act){
    case 'authencation':
        ?>
        //<script>
        $(document).ready(function () {
            $('#login').click(function () {
                var user        = $('#user').val();
                var pass        = $('#pass').val();
                var remember    = $('#remember:checkbox:checked').length > 0 ? 1 : 0;

                if(!user || !pass){
                    swal("Đăng nhập!", "Bạn cần điền tên đăng nhập và mật khẩu để đăng nhập", "error");
                    return false;
                }

                $.ajax({
                    url         : '<?=_CONFIG_URL_API?>',
                    dataType    : 'json',
                    method      : 'GET',
                    data        : {
                        act         : 'authencation',
                        type        : 'check_login',
                        token       : '<?=$function_duong->createToken()?>',
                        login_user  : user,
                        login_pass  : pass
                        login_reme  : remember
                    },
                    beforeSend  : function () {
                        $('#login').val('Đang kiểm tra đang nhập ...');
                    },
                    success     : function (data) {
                        $('#login').val('Đăng nhập');
                        if(data.response == 200){
                            swal("Đăng nhập!", data.message, "error");
                            return false;
                        }else{
                            swal("Đăng nhập!", data.message, "error");
                            return false;
                        }
                    }
                });

            });
        });
        //</script>
        <?php
        break;
}