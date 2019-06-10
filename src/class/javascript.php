<?php
require_once '../core.php';
header('Content-type: application/javascript');

switch ($act){
    case 'bill':
        ?>
        //<script>
        $(document).ready(function () {
            $('#billbuy_add').click(function () {

                return false;
            });
        });
        //</script>
        <?php
        break;
    case 'customer':
        ?>
        //<script>
        $(document).ready(function () {
            // Add Customer
            $('#submit_addcustomer').click(function () {
                var customer_name       = $('input[name=customer_name]').val();
                var customer_address    = $('input[name=customer_address]').val();
                var customer_phone      = $('input[name=customer_phone]').val();
                var customer_handbag    = $('select[name=customer_handbag]').val();
                var customer_sizedbag   = $('select[name=customer_sizedbag]').val();

                if(!customer_name){
                    swal('Thêm khách hàng', 'Bạn chưa nhập tên khách hàng', 'error');
                    return false;
                }

                $.ajax({
                    url         : '<?=_CONFIG_URL_API?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {
                        'token'             : '<?=$function_duong->createToken()?>',
                        'act'               : 'customer',
                        'type'              : 'add',
                        'customer_name'     : customer_name,
                        'customer_address'  : customer_address,
                        'customer_phone'    : customer_phone,
                        'customer_handbag'  : customer_handbag,
                        'customer_sizedbag' : customer_sizedbag
                    },
                    beforeSend  : function () {
                        $('#submit_addcustomer').html('Đang thêm khách hàng ...');
                    },
                    success     : function (data) {
                        $('#submit_addcustomer').html('Thêm khách hàng');
                        if(data.response == 200){
                            $(location).attr('href', '<?=_CONFIG_URL_HOME?>/customer.php');
                        }else{
                            swal('Thêm khách hàng', data.message, 'error');
                            return false;
                        }
                    }
                });
            });

            // Delete Customer
            $('a[data-text=customer_delete]').click(function () {
                var customer_id = $(this).attr('data-content');
                var title       = 'Xóa khách hàng';
                swal({
                    title: title,
                    text: 'Bạn có chắc chắc muốn xóa khách hàng này! Sau khi xóa, dữ liệu sẽ không khôi phục được',
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
                            method      : 'GET',
                            dataType    : 'json',
                            data        : {
                                'token'         : '<?=$function_duong->createToken()?>',
                                'act'           : 'customer',
                                'type'          : 'delete',
                                'id'            : customer_id
                            },
                            success     : function (data) {
                                if(data.response == 200){
                                    $('#tr_'+customer_id).remove();
                                    swal(title, data.message, 'success');
                                    return false;
                                }else{
                                    swal(title, data.message, 'error');
                                    return false;
                                }
                            }
                        });
                    }
                });
            });

            // Update Customer
            $('button[data-text=submit_updatecustomer]').click(function () {
                var customer_id         = $(this).attr('data-content');
                var customer_name       = $('#customer_name_'+ customer_id).val();
                var customer_address    = $('#customer_address_'+ customer_id).val();
                var customer_phone      = $('#customer_phone_'+ customer_id).val();
                var customer_handbag    = $('#customer_handbag_'+ customer_id).val();
                var customer_sizedbag   = $('#customer_sizedbag_'+ customer_id).val();
                var title               = 'Cập nhật khách hàng';

                if(!customer_name){
                    swal(title,'Tên khách hàng không được để trống', 'error');
                    return false;
                }

                $.ajax({
                    url         : '<?=_CONFIG_URL_API?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {
                        'token'             : '<?=$function_duong->createToken()?>',
                        'act'               : 'customer',
                        'type'              : 'update',
                        'id'                : customer_id,
                        'customer_name'     : customer_name,
                        'customer_address'  : customer_address,
                        'customer_phone'    : customer_phone,
                        'customer_handbag'  : customer_handbag,
                        'customer_sizedbag' : customer_sizedbag
                    },
                    beforeSend  : function () {
                        $('button[data-text=submit_updatecustomer]').html('Đang cập nhật ...');
                    },
                    success     : function (data) {
                        $('button[data-text=submit_updatecustomer]').html('Cập nhật');
                        if(data.response == 200){
                            $(location).attr('href', '<?=_CONFIG_URL_HOME?>/customer.php');
                        }else{
                            swal(title, data.message, 'error');
                        }
                    }
                });

            });
        });
        //</script>
        <?php
        break;
    case 'handbag':
        ?>
        //<script>
            $(document).ready(function () {
                // Add handbag
                $('#metadata_add').click(function () {
                    var metadata_name   = $('input[name=metadata_name]').val();
                    var metadata_type   = $(this).attr('data-act');
                    if(!metadata_name){
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
                            'type'          : 'add',
                            'metadata_type' : metadata_type,
                            'metadata_name' : metadata_name
                        },
                        beforeSend  : function () {
                            $('#metadata_add').html('Đang thêm dữ liệu');
                        },
                        success     : function (data) {
                            if(data.response == 200){
                                $(location).attr('href', data.url);
                            }else{
                                swal('Lỗi', data.message, 'error');
                                return false;
                            }
                        }
                    });

                });

                // Delete handbag
                $('a[data-text=metadata_delete]').click(function () {
                    var metadataId      = $(this).attr('data-content');
                    var metadata_type   = $(this).attr('data-act');
                    var text            = (metadata_type == 'handbag') ? 'Bạn có chắc chắn muốn xóa loại túi này. Sau khi xóa sẽ không khôi phục được!' : 'Bạn có chắc chắn muốn xóa kích thước túi này. Sau khi xóa sẽ không khôi phục được!';
                    var title           = (metadata_type == 'handbag') ? 'Xóa kiểu túi' : 'Xóa kích thước túi';
                    swal({
                        title: title,
                        text: text,
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
                                    'token'         : '<?=$function_duong->createToken()?>',
                                    'act'           : 'metadata',
                                    'type'          : 'delete',
                                    'metadata_type' : metadata_type,
                                    'id'            : metadataId
                                },
                                success     : function (data) {
                                    if(data.response == 200){
                                        $('#trMetaData_'+metadataId).remove();
                                        swal(title, data.message, 'success');
                                        return false;
                                    }else{
                                        swal(title, data.message, 'error');
                                        return false;
                                    }
                                }
                            });
                        }
                    });
                });

                // Update handbag
                $('button[data-text=metadata_update]').click(function () {
                    var metadataId      = $(this).attr('data-content');
                    var metadataContent = $('#metadata_update_text_'+metadataId).val();
                    var metadataType    = $(this).attr('data-src');
                    var title           = (metadataType == 'handdbag') ? 'Cập nhật loại túi' : 'Cập nhật kích thước túi';

                    if(!metadataContent){
                        swal(title, 'Bạn cần nhập nội dung', 'error');
                        return false;
                    }

                    $.ajax({
                        url         : '<?=_CONFIG_URL_API?>',
                        method      : 'POST',
                        dataType    : 'json',
                        data        : {
                            'token'         : '<?=$function_duong->createToken()?>',
                            'act'           : 'metadata',
                            'type'          : 'update',
                            'metadata_type' : metadataType,
                            'metadata_name' : metadataContent,
                            'id'            : metadataId
                        },
                        beforeSend  : function () {
                            $('button[data-text=metadata_update]').html('Đang cập nhật');
                        },
                        success     : function (data) {
                            if(data.response == 200){
                                swal(title, data.message, 'success');
                                $('#metadata_update_modal_'+metadataId).modal('hide');
                                $('#result_metadata_update_'+metadataId).html('<i class="la la-long-arrow-right"></i> '+ metadataContent);
                            }else{
                                swal(title, data.message, 'error');
                            }
                            $('button[data-text=metadata_update]').html('Cập nhật');
                        }
                    });
                    return false;
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