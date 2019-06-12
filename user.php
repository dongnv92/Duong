<?php
require_once 'src/core.php';
if (!$user) {
    $function_duong->redirectUrl(_CONFIG_URL_LOGIN);
}
$header['module'] = 'user';

switch ($act){
    case 'update':
        $data_user          = $db_duong->from(_DB_TABLE_USERS)->where('user_id', $id)->fetch_first();
        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css', 'assets/css/plugins/animate/animate.min.css'];
        $js_plus            = ['custom.js?act=user', 'assets/vendors/js/extensions/sweetalert.min.js'];
        $header['title']    = 'Cập nhật thành viên';
        require_once 'header.php';
        ?>
        <div class="card border-left-blue border-right-blue">
            <div class="card-header"><h4 class="card-title"></h4> </div>
            <div class="card-body">
                <fieldset class="form-group floating-label-form-group">
                    <label>Tên đăng nhập</label>
                    <input type="text" class="form-control round" value="<?=$data_user['user_name']?>" name="user_name" placeholder="Nhập tên thành viên">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">Mật khẩu</label>
                    <input type="password" class="form-control round" name="user_pass" placeholder="Mật khẩu">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control round" name="user_repass" placeholder="Mật khẩu">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">Tên hiển thị</label>
                    <input type="text" class="form-control round" value="<?=$data_user['user_fullname']?>" name="user_fullname" placeholder="Nhập tên hiển thị">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">Điện thoại</label>
                    <input type="text" class="form-control round" name="user_phone" value="<?=$data_user['user_phone']?>" placeholder="Nhập số điện thoại">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">Địa chỉ</label>
                    <input type="text" class="form-control round" name="user_address" value="<?=$data_user['user_address']?>" placeholder="Nhập số điện thoại">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">ID Facebook</label>
                    <input type="text" class="form-control round" name="user_id_facebook" value="<?=$data_user['user_id_facebook']?>" placeholder="Nhập số điện thoại">
                </fieldset>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-outline-blue round" id="submit_update_user">Cập nhật thành viên</button>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
    case 'add':
        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css', 'assets/css/plugins/animate/animate.min.css'];
        $js_plus            = ['custom.js?act=user', 'assets/vendors/js/extensions/sweetalert.min.js'];
        $header['title']    = 'Thêm thành viên';
        require_once 'header.php';
        ?>
        <div class="card border-left-blue border-right-blue">
            <div class="card-header"><h4 class="card-title"></h4> </div>
            <div class="card-body">
                <fieldset class="form-group floating-label-form-group">
                    <label>Tên đăng nhập</label>
                    <input type="text" class="form-control round" name="user_name" placeholder="Nhập tên thành viên">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">Mật khẩu</label>
                    <input type="password" class="form-control round" name="user_pass" placeholder="Mật khẩu">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">Nhập lại mật khẩu</label>
                    <input type="password" class="form-control round" name="user_repass" placeholder="Mật khẩu">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">Tên hiển thị</label>
                    <input type="text" class="form-control round" name="user_fullname" placeholder="Nhập tên hiển thị">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">Điện thoại</label>
                    <input type="text" class="form-control round" name="user_phone" placeholder="Nhập số điện thoại">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">Địa chỉ</label>
                    <input type="text" class="form-control round" name="user_address" placeholder="Nhập số điện thoại">
                </fieldset>
                <fieldset class="form-group floating-label-form-group">
                    <label for="title">ID Facebook</label>
                    <input type="text" class="form-control round" name="user_id_facebook" placeholder="Nhập số điện thoại">
                </fieldset>
            </div>
            <div class="card-footer text-right"><button class="btn btn-outline-blue round" id="submit_add_user">Thêm thành viên</button></div>
        </div>
        <?php
        require_once 'footer.php';
        break;
    default:
        $data_where                 = [];
        // Tính tổng data
        $db_duong->select('user_id')->from(_DB_TABLE_USERS)->where($data_where);
        $db_duong->execute();
        $pagination['count']        = $db_duong->affected_rows;
        $pagination['page_row']     = _CONFIG_PAGINATION;
        $pagination['page_num']     = ceil($pagination['count']/$pagination['page_row']);
        $pagination['url']          = _CONFIG_URL_HOME.'/user.php?page={page}';
        $pagination['page_start']   = ($page-1) * $pagination['page_row'];

        // Hiển thị dữ liệu
        $db_duong->from(_DB_TABLE_USERS)->where($data_where);
        $db_duong->limit(_CONFIG_PAGINATION, $pagination['page_start']);
        $db_duong->order_by('user_id', 'desc');
        $datas              = $db_duong->fetch();

        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css', 'assets/css/plugins/animate/animate.min.css'];
        $js_plus            = ['custom.js?act=user', 'assets/vendors/js/extensions/sweetalert.min.js'];
        $header['title']    = 'Danh sách thành viên';
        require_once 'header.php';
        ?>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Danh sách thành viên</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-toggle="modal" data-target="#modal_add_user" class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right" href="#">Thêm thành viên</a></li>
                            </ul>
                            <!-- Modal -->
                            <div class="modal animated rollIn text-left" id="modal_add_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title"> Thêm thành viên</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <fieldset class="form-group floating-label-form-group">
                                                <label>Tên đăng nhập</label>
                                                <input type="text" class="form-control round" name="user_name" placeholder="Nhập tên thành viên">
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="title">Mật khẩu</label>
                                                <input type="password" class="form-control round" name="user_pass" placeholder="Mật khẩu">
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="title">Nhập lại mật khẩu</label>
                                                <input type="password" class="form-control round" name="user_repass" placeholder="Mật khẩu">
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="title">Tên hiển thị</label>
                                                <input type="text" class="form-control round" name="user_fullname" placeholder="Nhập tên hiển thị">
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="title">Điện thoại</label>
                                                <input type="text" class="form-control round" name="user_phone" placeholder="Nhập số điện thoại">
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="title">Địa chỉ</label>
                                                <input type="text" class="form-control round" name="user_address" placeholder="Nhập số điện thoại">
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="title">ID Facebook</label>
                                                <input type="text" class="form-control round" name="user_id_facebook" placeholder="Nhập số điện thoại">
                                            </fieldset>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="reset" class="btn btn-outline-secondary round" data-dismiss="modal" value="Đóng">
                                            <button class="btn btn-outline-blue round" id="submit_add_user">Thêm thành viên</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                    </div>
                    <div class="card-content mt-1">
                        <div class="table-responsive">
                            <table id="recent-orders" class="table table-hover table-xl mb-0">
                                <thead>
                                <tr>
                                    <th class="border-top-0 text-center" width="">Tên đăng nhập</th>
                                    <th class="border-top-0 text-center" width="">Tên hiển thị</th>
                                    <th class="border-top-0 text-center" width="">Địa chỉ</th>
                                    <th class="border-top-0 text-center" width="">Điện thoại</th>
                                    <th class="border-top-0 text-center" width="">ID Facebook</th>
                                    <th class="border-top-0 text-center" width="">Ngày đăng ký</th>
                                    <th class="border-top-0 text-center" width="">Quản lý</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($datas AS $data){
                                ?>
                                    <tr id="tr_<?=$data['user_id']?>">
                                        <td class="text-center"><?=$data['user_name']?></td>
                                        <td class="text-center"><?=$data['user_fullname']?></td>
                                        <td class="text-center"><?=$data['user_address']?></td>
                                        <td class="text-center"><?=$data['user_phone']?></td>
                                        <td class="text-center"><?=$data['user_id_facebook']?></td>
                                        <td class="text-center"><?=date('H:i:s d-m-Y')?></td>
                                        <td class="text-center">
                                            <a href="bill.php?act=update&type=" class="text-info"><i class="la la-pencil-square-o"></i> Sửa</a>
                                            <a href="javascript:;" class="text-danger" data-text="user_delete" data-content="<?=$data['user_id']?>"><i class="la la-trash-o"></i> Xóa</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <?=$function_duong->pagination($pagination)?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
}