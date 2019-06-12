<?php
require_once 'src/core.php';
if(!$user){
    $function_duong->redirectUrl(_CONFIG_URL_LOGIN);
}
$header['module'] = 'customer';
switch ($act){
    case 'add':
        $header['title']    = 'Thêm khách hàng';
        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css', 'assets/css/plugins/animate/animate.min.css'];
        $js_plus            = ['custom.js?act=customer', 'assets/vendors/js/extensions/sweetalert.min.js'];
        require_once 'header.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card border-left-blue border-right-blue">
                    <div class="card-header"><h4 class="card-title">Thêm khách hàng</h4> </div>
                    <div class="card-body">
                        <fieldset class="form-group floating-label-form-group">
                            <label>Tên khách hàng</label>
                            <input type="text" class="form-control round" name="customer_name" placeholder="Nhập tên khách hàng">
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="title">Địa chỉ khách hàng</label>
                            <input type="text" class="form-control round" name="customer_address" placeholder="Nhập địa chỉ khách hàng">
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="title">Số điện thoại khách hàng</label>
                            <input type="text" class="form-control round" name="customer_phone" placeholder="Nhập số điện thoại khách hàng">
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="title">Kiểu túi khách hàng hay sử dụng</label>
                            <select name="customer_handbag" class="form-control round">
                                <option value="0">-- Chọn 1 loại kiểu túi --</option>
                                <?php
                                foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'handbag')->fetch() AS $handbag){
                                    echo '<option value="'. $handbag['metadata_id'] .'">'. $handbag['metadata_name'] .'</option>';
                                }
                                ?>
                            </select>
                        </fieldset>
                        <fieldset class="form-group floating-label-form-group">
                            <label for="title">Kích thước túi khách hàng hay sử dụng</label>
                            <select name="customer_sizedbag" class="form-control round">
                                <option value="0">-- Chọn 1 loại kích thước --</option>
                                <?php
                                foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'sizebag')->fetch() AS $sizebag){
                                    echo '<option value="'. $sizebag['metadata_id'] .'">'. $sizebag['metadata_name'] .'</option>';
                                }
                                ?>
                            </select>
                        </fieldset>
                    </div>
                    <div class="card-footer text-right"><button class="btn btn-outline-blue round" id="submit_addcustomer">Thêm khách hàng</button></div>
                </div>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
    default:
        $data_where = [];
        // Tính tổng số lượng product
        $db_duong->select('customer_id')->from(_DB_TABLE_CUSTOMER)->where($data_where)->execute();
        $pagination['count']        = $db_duong->affected_rows;
        $pagination['page_row']     = _CONFIG_PAGINATION;
        $pagination['page_num']     = ceil($pagination['count']/$pagination['page_row']);
        $pagination['url']          = _CONFIG_URL_HOME.'/customer.php?page={page}';
        $pagination['page_start']   = ($page-1) * $pagination['page_row'];

        // Hiển thị dữ liệu
        $db_duong->from(_DB_TABLE_CUSTOMER)->where($data_where);
        $db_duong->limit(_CONFIG_PAGINATION, $pagination['page_start']);
        $db_duong->order_by('customer_id', 'desc');
        $data = $db_duong->fetch();

        $header['title']    = 'Danh sách khách hàng';
        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css', 'assets/css/plugins/animate/animate.min.css'];
        $js_plus            = ['custom.js?act=customer', 'assets/vendors/js/extensions/sweetalert.min.js'];
        require_once 'header.php';
        ?>
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Danh sách khách hàng</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-toggle="modal" data-target="#modal_addcustomer" class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right" href="" target="_blank">Thêm khách hàng</a></li>
                            </ul>
                            <!-- Modal -->
                            <div class="modal animated rollIn text-left" id="modal_addcustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title"> Thêm khách hàng</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <fieldset class="form-group floating-label-form-group">
                                                <label>Tên khách hàng</label>
                                                <input type="text" class="form-control round" name="customer_name" placeholder="Nhập tên khách hàng">
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="title">Địa chỉ khách hàng</label>
                                                <input type="text" class="form-control round" name="customer_address" placeholder="Nhập địa chỉ khách hàng">
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="title">Số điện thoại khách hàng</label>
                                                <input type="text" class="form-control round" name="customer_phone" placeholder="Nhập số điện thoại khách hàng">
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="title">Kiểu túi khách hàng hay sử dụng</label>
                                                <select name="customer_handbag" class="form-control round">
                                                    <option value="0">-- Chọn 1 loại kiểu túi --</option>
                                                    <?php
                                                    foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'handbag')->fetch() AS $handbag){
                                                        echo '<option value="'. $handbag['metadata_id'] .'">'. $handbag['metadata_name'] .'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </fieldset>
                                            <fieldset class="form-group floating-label-form-group">
                                                <label for="title">Kích thước túi khách hàng hay sử dụng</label>
                                                <select name="customer_sizedbag" class="form-control round">
                                                    <option value="0">-- Chọn 1 loại kích thước --</option>
                                                    <?php
                                                    foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'sizebag')->fetch() AS $sizebag){
                                                        echo '<option value="'. $sizebag['metadata_id'] .'">'. $sizebag['metadata_name'] .'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="reset" class="btn btn-outline-secondary round" data-dismiss="modal" value="Đóng">
                                            <button class="btn btn-outline-blue round" id="submit_addcustomer">Thêm khách hàng</button>
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
                                        <th class="border-top-0" width="20%">Tên</th>
                                        <th class="border-top-0" width="20%">Địa chỉ</th>
                                        <th class="border-top-0" width="20%">Điện thoại</th>
                                        <th class="border-top-0" width="10%">Loại túi</th>
                                        <th class="border-top-0" width="5%">Kích thước túi</th>
                                        <th class="border-top-0" width="15%">Thời gian đăng ký</th>
                                        <th class="border-top-0" width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    echo count($data) == 0 ? '<tr><td class="text-center text-danger" colspan="6">Chưa có dữ liệu khách hàng</td></tr>' : '';
                                    foreach ($data as $customer){
                                        $handbag = $db_duong->select('metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_id', $customer['customer_handbag'])->fetch_first();
                                        $sizebag = $db_duong->select('metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_id', $customer['customer_sizebag'])->fetch_first();
                                        echo '<tr id="tr_'. $customer['customer_id'] .'">';
                                            echo '<td>';
                                                echo '<a href="javascript:;" data-toggle="modal" data-target="#customer_update_modal_'. $customer['customer_id'] .'">'. $customer['customer_name'] .'</a>';
                                                ?>
                                                <!-- Modal -->
                                                <div class="modal animated zoomIn text-left" id="customer_update_modal_<?=$customer['customer_id']?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title">Cập nhập khách hàng</h3>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <fieldset class="form-group floating-label-form-group">
                                                                    <label>Tên khách hàng</label>
                                                                    <input type="text" class="form-control round" value="<?=$customer['customer_name']?>" id="customer_name_<?=$customer['customer_id']?>" placeholder="Nhập tên khách hàng">
                                                                </fieldset>
                                                                <fieldset class="form-group floating-label-form-group">
                                                                    <label for="title">Địa chỉ khách hàng</label>
                                                                    <input type="text" class="form-control round" value="<?=$customer['customer_address']?>" id="customer_address_<?=$customer['customer_id']?>" placeholder="Nhập địa chỉ khách hàng">
                                                                </fieldset>
                                                                <fieldset class="form-group floating-label-form-group">
                                                                    <label for="title">Số điện thoại khách hàng</label>
                                                                    <input type="text" class="form-control round" value="<?=$customer['customer_phone']?>" id="customer_phone_<?=$customer['customer_id']?>" placeholder="Nhập số điện thoại khách hàng">
                                                                </fieldset>
                                                                <fieldset class="form-group floating-label-form-group">
                                                                    <label for="title">Kiểu túi khách hàng hay sử dụng</label>
                                                                    <select id="customer_handbag_<?=$customer['customer_id']?>" class="form-control round">
                                                                        <option value="0">-- Chọn 1 loại kiểu túi --</option>
                                                                        <?php
                                                                        foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'handbag')->fetch() AS $handbag_modal){
                                                                            echo '<option value="'. $handbag_modal['metadata_id'] .'" '. ($customer['customer_handbag'] == $handbag_modal['metadata_id'] ? 'selected' : '') .'>'. $handbag_modal['metadata_name'] .'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </fieldset>
                                                                <fieldset class="form-group floating-label-form-group">
                                                                    <label for="title">Kích thước túi khách hàng hay sử dụng</label>
                                                                    <select id="customer_sizedbag_<?=$customer['customer_id']?>" class="form-control round">
                                                                        <option value="0">-- Chọn 1 loại kích thước --</option>
                                                                        <?php
                                                                        foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'sizebag')->fetch() AS $sizebag_modal){
                                                                            echo '<option value="'. $sizebag_modal['metadata_id'] .'" '. ($customer['customer_sizebag'] == $sizebag_modal['metadata_id'] ? 'selected' : '') .'>'. $sizebag_modal['metadata_name'] .'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </fieldset>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="reset" class="btn btn-outline-secondary round" data-dismiss="modal" value="Đóng">
                                                                <button class="btn btn-outline-blue round" data-text="submit_updatecustomer" data-content="<?=$customer['customer_id']?>">Cập nhật khách hàng</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Modal -->
                                                <?php
                                            echo '</td>';
                                            echo '<td>'. $customer['customer_address'] .'</td>';
                                            echo '<td>'. $customer['customer_phone'] .'</td>';
                                            echo '<td>'. ($handbag ? $handbag['metadata_name'] : 'Không có') .'</td>';
                                            echo '<td>'. ($sizebag ? $sizebag['metadata_name'] : 'Không có') .'</td>';
                                            echo '<td>'. date('H:i:d d-m-Y', strtotime($customer['customer_time'])) .'</td>';
                                            echo '<td><a data-text="customer_delete" data-content="'. $customer['customer_id'] .'" href="javascript:;" class="text-danger"><small><i class="ft-trash-2"></i> Xóa</small></a></td>';
                                        echo '</tr>';
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
}