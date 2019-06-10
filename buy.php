<?php
require_once 'src/core.php';
if (!$user) {
    $function_duong->redirectUrl(_CONFIG_URL_LOGIN);
}
$header['module'] = 'buy';
switch ($act){
    case 'add':
        if($submit){
            $bill_handbag   = isset($_POST['bill_handbag'])     && !empty($_POST['bill_handbag'])   ? $_POST['bill_handbag']    : '';
            $bill_sizedbag  = isset($_POST['bill_sizedbag'])    && !empty($_POST['bill_sizedbag'])  ? $_POST['bill_sizedbag']   : '';
            $bill_amount    = isset($_POST['bill_amount'])      && !empty($_POST['bill_amount'])    ? $_POST['bill_amount']     : '';
            $bill_price     = isset($_POST['bill_price'])       && !empty($_POST['bill_price'])     ? $_POST['bill_price']      : '';
            $bill_note      = isset($_POST['bill_note'])        && !empty($_POST['bill_note'])      ? $_POST['bill_note']       : '';
            $error          = [];
            if(!$bill_handbag){
                $error['bill_handbag']  = '<small class="text-danger">Bạn chưa nhập kiểu túi</small>';
            }
            if(!$bill_sizedbag){
                $error['bill_sizedbag'] = '<small class="text-danger">Bạn chưa nhập kích thước túi</small>';
            }
            if(!$bill_amount){
                $error['bill_amount']   = '<small class="text-danger">Bạn chưa nhập số lượng</small>';
            }
            if(!$bill_price){
                $error['bill_price']    = '<small class="text-danger">Bạn chưa nhập đơn giá</small>';
            }
            if(!$error){
                $data = [
                    'bill_type'         => 'buy',
                    'bill_customer'     => '',
                    'bill_handbag'      => $bill_handbag,
                    'bill_sizebag'      => $bill_sizedbag,
                    'bill_amount'       => $bill_amount,
                    'bill_price'        => $bill_price,
                    'bill_total_price'  => (($bill_amount*$bill_price)/1000),
                    'bill_user'         => $user['user_id'],
                    'bill_note'         => $bill_note,
                    'bill_time'         => _CONFIG_DATETIME
                ];
            }
        }
        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css', 'assets/css/plugins/animate/animate.min.css'];
        $js_plus            = ['custom.js?act=bill', 'assets/vendors/js/extensions/sweetalert.min.js'];
        $header['title'] = 'Thêm hàng nhập';
        require_once 'header.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post">
                    <div class="card border-left-blue border-right-blue">
                        <div class="card-header"><h4 class="card-title">Thêm hàng nhập về</h4> </div>
                        <div class="card-body">
                            <fieldset class="form-group floating-label-form-group">
                                <label>Kiểu túi <?=$error['bill_handbag']?$error['bill_handbag']:''?></label>
                                <select name="bill_handbag" class="form-control round border-blue">
                                    <option value="0">-- Chọn 1 loại kiểu túi --</option>
                                    <?php
                                    foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'handbag')->fetch() AS $handbag){
                                        echo '<option value="'. $handbag['metadata_id'] .'">'. $handbag['metadata_name'] .'</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="title">Kích thước túi <?=$error['bill_sizedbag']?$error['bill_sizedbag']:''?></label>
                                <select name="bill_sizedbag" class="form-control round border-blue">
                                    <option value="0">-- Chọn 1 loại kích thước --</option>
                                    <?php
                                    foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'sizebag')->fetch() AS $sizebag){
                                        echo '<option value="'. $sizebag['metadata_id'] .'">'. $sizebag['metadata_name'] .'</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label>Số lượng (Đơn vị Gam. 1000Gam = 1Kg) <?=$error['bill_amount']?$error['bill_amount']:''?></label>
                                <input type="text" value="<?=$bill_amount?>" class="form-control round border-blue" name="bill_amount" placeholder="Nhập số lượng">
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="title">Đơn giá / 1Kg <?=$error['bill_price']?$error['bill_price']:''?></label>
                                <input type="text" value="<?=$bill_price?>" class="form-control round border-blue" name="bill_price" placeholder="Nhập đơn giá">
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="title">Ghi chú</label>
                                <textarea name="bill_note" rows="5" class="form-control round border-blue" placeholder="Ghi chú đơn hàng"><?=$bill_note?></textarea>
                            </fieldset>
                        </div>
                        <div class="card-footer text-right"><input type="submit" name="submit" id="billbuy_add" class="btn btn-outline-blue round" value="Thêm khách hàng" /></div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
    default:
        $data_where = [
            'bill_type' => 'buy'
        ];
        // Tính tổng số lượng product
        $db_duong->select('bill_id')->from(_DB_TABLE_BILL)->where($data_where)->execute();
        $pagination['count']        = $db_duong->affected_rows;
        $pagination['page_row']     = _CONFIG_PAGINATION;
        $pagination['page_num']     = ceil($pagination['count']/$pagination['page_row']);
        $pagination['url']          = _CONFIG_URL_HOME.'/buy.php?page={page}';
        $pagination['page_start']   = ($page-1) * $pagination['page_row'];

        // Hiển thị dữ liệu
        $db_duong->from(_DB_TABLE_BILL)->where($data_where);
        $db_duong->limit(_CONFIG_PAGINATION, $pagination['page_start']);
        $db_duong->order_by('bill_id', 'desc');
        $datas              = $db_duong->fetch();
        $header['title']    = 'Danh sách hàng nhập';
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
                        </div>
                    </div>
                    <div class="card-content mt-1">
                        <div class="table-responsive">
                            <table id="recent-orders" class="table table-hover table-xl mb-0">
                                <thead>
                                <tr>
                                    <th class="border-top-0" width="20%">Kiểu túi</th>
                                    <th class="border-top-0" width="20%">Kích thước</th>
                                    <th class="border-top-0" width="20%">Số lượng (g)</th>
                                    <th class="border-top-0" width="10%">Đơn giá</th>
                                    <th class="border-top-0" width="5%">Thành tiền</th>
                                    <th class="border-top-0" width="15%">Người lập phiếu</th>
                                    <th class="border-top-0" width="10%">Ghi chú</th>
                                    <th class="border-top-0" width="10%">Thời gian</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($datas AS $bill){
                                    ?>
                                    <tr>
                                        <td><?=$bill['bill_handbag']?></td>
                                        <td><?=$bill['bill_sizebag']?></td>
                                        <td><?=$bill['bill_amount']?></td>
                                        <td><?=$bill['bill_price']?></td>
                                        <td><?=$bill['bill_total_price']?></td>
                                        <td><?=$bill['bill_user']?></td>
                                        <td><?=$bill['bill_note']?></td>
                                        <td><?=date('H:i:s d/m/Y', strtotime($bill['bill_time']))?></td>
                                    </tr>
                                    <?php
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