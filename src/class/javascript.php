<?php
require_once '../core.php';
header('Content-type: application/javascript');

switch ($act){
    case 'handbag':
        ?>
        //<script>
            $(document).ready(function () {
                $('#handbag_add').click(function () {
                    var handbagname = $('input[name=handbag_name]').val();
                    if(!handbagname){
                        swal("Lỗi!", "Bạn cần nhập tên loại túi", "error");
                        return false;
                    }

                    $.ajax({
                        url         : '<?=_CONFIG_URL_API?>',
                        method      : 'POST',
                        dataType    : 'json',
                        data        : {
                            'token'         : '<?=$function_duong->createToken()?>',
                            'act'           : 'metadata',
                            'type'          : 'handbag_add',
                            'handbagname'   : handbagname
                        },
                        beforeSend  : function () {
                            $('#handbag_add').html('Đang thêm dữ liệu');
                        },
                        success     : function (data) {
                            if(data.response == 200){
                                $(location).attr('href', '<?=_CONFIG_URL_HOME.'/metadata.php?act=handbag'?>');
                            }else{
                                swal('Lỗi', data.message, 'error');
                                return false;
                            }
                        }
                    });

                });

                $('a[data-text=handbag_delete]').click(function () {
                    var handbagid = $(this).attr('data-content');
                    swal({
                        title: "Xóa kiểu túi",
                        text: "Bạn có chắc chắn muốn xóa loại túi này. Sau khi xóa sẽ không khôi phục được!",
                        icon: "warning",
                        buttons: {
                            cancel: {
                                text: "Quay Lại",
                                value: null,
                                visible: true,
                                className: "",
                                closeModal: true,
                            },
                            confirm: {
                                text: "Xóa Ngay",
                                value: true,
                                visible: true,
                                className: "",
                                closeModal: false
                            }
                        }
                    }).then((isConfirm) => {
                        if (isConfirm) {
                            $.ajax({
                                url         : '<?=_CONFIG_URL_API?>',
                                method      : 'POST',
                                dataType    : 'json',
                                data        : {
                                    'token' : '<?=$function_duong->createToken()?>',
                                    'act'   : 'metadata',
                                    'type'  : 'handbag_delete',
                                    'id'    : handbagid
                                },
                                success     : function (data) {
                                    if(data.response == 200){
                                        $('#handbagData_'+handbagid).remove();
                                        swal('Xóa kiểu túi', data.message, 'success');
                                        return false;
                                    }else{
                                        swal('Lỗi', data.message, 'error');
                                        return false;
                                    }
                                }
                            });
                        }
                    });
                });
            });
        //</script>
        <?php
        break;
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
                        'act'         : 'authencation',
                        'type'        : 'check_login',
                        'token'       : '<?=$function_duong->createToken()?>',
                        'login_user'  : user,
                        'login_pass'  : pass,
						'login_reme'  : remember
                    },
                    beforeSend  : function () {
                        $('#login').val('Đang kiểm tra đang nhập ...');
                    },
                    success     : function (data) {
                        $('#login').val('Đăng nhập');
                        if(data.response == 200){
                            $(location).attr('href', '<?=_CONFIG_URL_HOME?>');
                        }else{
                            swal("Đăng nhập!", data.message, "error");
                        }
                    }
                });
				return false;
            });
        });
        //</script>
        <?php
        break;
}