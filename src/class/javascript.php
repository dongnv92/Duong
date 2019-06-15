<?php
require_once '../core.php';
header('Content-type: application/javascript');

switch ($act){
    case 'pickdate':
        ?>
        //<script>
        $(".pickadate").pickadate({
            monthPrev   : "&larr;",
            monthNext   : "&larr;",
            format      : "dd-mm-yyyy",
            formatSubmit: "mm/dd/yyyy",
            hiddenPrefix: "prefix__",
            hiddenSuffix: "__suffix"
        });
        //</script>
        <?php
        break;
    case 'user':
        ?>
        //<script>
        $(document).ready(function () {
            // Update User
            $('#submit_update_user').click(function () {
                var user_id             = $(this).attr('data-content');
                var user_user           = $(this).attr('data-user');
                var user_name           = $('input[name=user_name]').val();
                var user_fullname       = $('input[name=user_fullname]').val();
                var user_pass           = $('input[name=user_pass]').val();
                var user_repass         = $('input[name=user_repass]').val();
                var user_phone          = $('input[name=user_phone]').val();
                var user_address        = $('input[name=user_address]').val();
                var user_id_facebook    = $('input[name=user_id_facebook]').val();
                var title               = 'Cập nhật thành viên';

                $.ajax({
                    url         : '<?=_CONFIG_URL_API?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {
                        'token'             : '<?=$function_duong->createToken()?>',
                        'act'               : 'user',
                        'type'              : 'update',
                        'user_id'           : user_id,
                        'user_user'         : user_user,
                        'user_name'         : user_name,
                        'user_fullname'     : user_fullname,
                        'user_pass'         : user_pass,
                        'user_repass'       : user_repass,
                        'user_phone'        : user_phone,
                        'user_address'      : user_address,
                        'user_id_facebook'  : user_id_facebook
                    },
                    beforeSend  : function () {
                        $(this).html('Đang sửa thành viên');
                    },
                    success     : function (data) {
                        swal(title, data.message, data.response == 200 ? 'success' : 'error');
                    }
                });
            });
            // Add User
            $('#submit_add_user').click(function () {
                var user_name           = $('input[name=user_name]').val();
                var user_fullname       = $('input[name=user_fullname]').val();
                var user_pass           = $('input[name=user_pass]').val();
                var user_repass         = $('input[name=user_repass]').val();
                var user_phone          = $('input[name=user_phone]').val();
                var user_address        = $('input[name=user_address]').val();
                var user_id_facebook    = $('input[name=user_id_facebook]').val();
                var title               = 'Thêm thành viên';

                $.ajax({
                    url         : '<?=_CONFIG_URL_API?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {
                        'token'             : '<?=$function_duong->createToken()?>',
                        'act'               : 'user',
                        'type'              : 'add',
                        'user_name'         : user_name,
                        'user_fullname'     : user_fullname,
                        'user_pass'         : user_pass,
                        'user_repass'       : user_repass,
                        'user_phone'        : user_phone,
                        'user_address'      : user_address,
                        'user_id_facebook'  : user_id_facebook
                    },
                    beforeSend  : function () {
                        $(this).html('Đang thêm thành viên');
                    },
                    success     : function (data) {
                        if(data.response == 200){
                            $(location).attr('href', '<?=_CONFIG_URL_HOME.'/user.php'?>');
                        }else{
                            swal(title, data.message, 'warning');
                        }
                    }
                });

                return false;
            });

            // Delete User
            $('a[data-text=user_delete]').click(function () {
                var userId = $(this).attr('data-content');
                swal({
                    title: 'Xóa thành viên',
                    text: 'Bạn có chắc chắc muốn xóa thành viên này? Sau khi xóa, dữ liệu sẽ không khôi phục được!',
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
                                'token' : '<?=$function_duong->createToken()?>',
                                'act'   : 'user',
                                'type'  : 'delete',
                                'id'    : userId
                            },
                            success     : function (data) {
                                if(data.response == 200){
                                    $('#tr_'+userId).remove();
                                    swal('Xóa thành viên', data.message, 'success');
                                    return false;
                                }else{
                                    swal('Xóa thành viên', data.message, 'error');
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
    case 'bill':
        ?>
        //<script>
        $(document).ready(function () {

            // Search
            $('#bill_search').click(function () {
                var type            = $(this).attr('data-type');
                var date_start      = $('input[name=date_start]').val();
                var date_end        = $('input[name=date_end]').val();
                var bill_handbag    = $('select[name=bill_handbag]').val();
                var bill_sizebag    = $('select[name=bill_sizebag]').val();
                var bill_user       = $('select[name=bill_user]').val();

                $(location).attr('href', '<?=_CONFIG_URL_HOME?>/bill.php?type='+type+
                    (date_start     ? '&date_start='+date_start : '')+
                    (date_end       ? '&date_end='+date_end: '')+
                    (bill_handbag   ? '&bill_handbag='+bill_handbag : '')+
                    (bill_sizebag   ? '&bill_sizebag='+bill_sizebag : '')+
                    (bill_user      ? '&bill_user='+bill_user : '')
                );

                return false;
            });

            // Add Bill
            $('#bill_add').click(function () {
                var bill_type       = $(this).attr('data-content');
                var bill_user       = $(this).attr('data-user');
                var text            = $(this).html();
                var bill_handbag    = $('select[name=bill_handbag]').val();
                var bill_sizebag    = $('select[name=bill_sizebag]').val();
                var bill_amount     = $('input[name=bill_amount]').val();
                var bill_price      = $('input[name=bill_price]').val();
                var bill_note       = $('textarea[name=bill_note]').val();
                var bill_customer   = (bill_type == 'buy' ? '' : $('select[name=bill_customer]').val())

                $.ajax({
                    url         : '<?=_CONFIG_URL_API?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {
                        'act'           : 'bill',
                        'type'          : 'add',
                        'token'         : '<?=$function_duong->createToken()?>',
                        'bill_handbag'  : bill_handbag,
                        'bill_sizedbag' : bill_sizebag,
                        'bill_amount'   : bill_amount,
                        'bill_price'    : bill_price,
                        'bill_note'     : bill_note,
                        'bill_type'     : bill_type,
                        'bill_customer' : bill_customer,
                        'bill_user'     : bill_user
                    },
                    beforeSend  : function () {
                        $('#bill_add').html('Đang thêm dữ liệu ...');
                    },
                    success     : function (data) {
                        $('#bill_add').html(text);

                        if(data.response == 200){
                            $(location).attr('href', '<?=_CONFIG_URL_HOME?>/bill.php?type='+bill_type);
                        }else{
                            swal('Thêm dữ liệu', data.message, 'warning');
                            return false;
                        }
                    }
                });

                return false;
            });

            // Delete Bill
            $('a[data-text=bill_delete]').click(function () {
                var bill_id     = $(this).attr('data-content');
                var bill_type   = $(this).attr('data-type');
                var title       = bill_type == 'buy' ? 'Xóa hàng nhập về' : 'Xóa hàng xuất đi';

                swal({
                    title: title,
                    text: 'Bạn có chắc chắc muốn xóa dữ liệu? Sau khi xóa, dữ liệu sẽ không khôi phục được!',
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
                                'act'           : 'bill',
                                'type'          : 'delete',
                                'bill_type'     : bill_type,
                                'bill_id'       : bill_id
                            },
                            success     : function (data) {
                                if(data.response == 200){
                                    $('#tr_'+bill_id).remove();
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

            // Update Bill
            $('#bill_update').click(function () {
                var bill_type       = $(this).attr('data-type');
                var bill_id         = $(this).attr('data-id');
                var buttonText      = $(this).html();
                var bill_handbag    = $('select[name=bill_handbag]').val();
                var bill_sizebag    = $('select[name=bill_sizebag]').val();
                var bill_amount     = $('input[name=bill_amount]').val();
                var bill_price      = $('input[name=bill_price]').val();
                var bill_note       = $('textarea[name=bill_note]').val();
                var bill_customer   = (bill_type == 'buy' ? '' : $('select[name=bill_customer]').val());

                $.ajax({
                    url         : '<?=_CONFIG_URL_API?>',
                    method      : 'POST',
                    dataType    : 'json',
                    data        : {
                        'act'           : 'bill',
                        'type'          : 'update',
                        'token'         : '<?=$function_duong->createToken()?>',
                        'bill_id'       : bill_id,
                        'bill_handbag'  : bill_handbag,
                        'bill_sizedbag' : bill_sizebag,
                        'bill_amount'   : bill_amount,
                        'bill_price'    : bill_price,
                        'bill_note'     : bill_note,
                        'bill_type'     : bill_type,
                        'bill_customer' : bill_customer
                    },
                    beforeSend  : function () {
                        $('#bill_update').html(buttonText);
                    },
                    success     : function (data) {
                        $('#bill_update').html('Đang cập nhật dữ liệu ...');
                        if(data.response == 200){
                            swal('Cập nhật dữ liệu', data.message, 'success');
                            return false;
                        }else{
                            swal('Cập nhật dữ liệu', data.message, 'warning');
                            return false;
                        }
                    }
                });

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