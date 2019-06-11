<?php
require_once 'src/core.php';
if (!$user) {
    $function_duong->redirectUrl(_CONFIG_URL_LOGIN);
}
$header['module'] = 'bill';
switch ($act){
    case 'update':
        if(!in_array($type, ['buy', 'sell'])){
            echo 'Error';
            break;
        }
        $bill = $db_duong->from(_DB_TABLE_BILL)->where('bill_id', $id)->fetch_first();
        if(!$bill){
            echo "Error ...";
            break;
        }
        switch ($type){
            case 'buy':
                $lang['title'] = 'Cập nhật hàng nhập về';
                break;
            case 'sell':
                $lang['title'] = 'Cập nhật hàng xuất đi';

                break;
        }

        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css', 'assets/css/plugins/animate/animate.min.css'];
        $js_plus            = ['custom.js?act=bill', 'assets/vendors/js/extensions/sweetalert.min.js'];
        $header['title']    = $lang['title'];
        require_once 'header.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post">
                    <div class="card border-left-blue border-right-blue">
                        <div class="card-header"><h4 class="card-title"><?=$lang['title']?></h4> </div>
                        <div class="card-body">
                            <?php if($type=='sell'){?>
                                <fieldset class="form-group floating-label-form-group">
                                    <label>Chọn khách hàng mua</label>
                                    <select name="bill_customer" class="form-control round border-blue">
                                        <?php
                                        foreach ($db_duong->select('customer_id, customer_name')->from(_DB_TABLE_CUSTOMER)->fetch() AS $customer){
                                            echo '<option value="'. $customer['customer_id'] .'" '. ($customer['customer_id'] == $bill['bill_customer'] ? 'selected' : '') .'>'. $customer['customer_name'] .'</option>';
                                        }
                                        ?>
                                    </select>
                                </fieldset>
                            <?php }?>
                            <fieldset class="form-group floating-label-form-group">
                                <label>Kiểu túi</label>
                                <select name="bill_handbag" class="form-control round border-blue">
                                    <option value="0">-- Chọn 1 loại kiểu túi --</option>
                                    <?php
                                    foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'handbag')->fetch() AS $handbag){
                                        echo '<option value="'. $handbag['metadata_id'] .'" '. ($handbag['metadata_id'] == $bill['bill_handbag'] ? 'selected' : '') .'>'. $handbag['metadata_name'] .'</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="title">Kích thước túi</label>
                                <select name="bill_sizebag" class="form-control round border-blue">
                                    <option value="0">-- Chọn 1 loại kích thước --</option>
                                    <?php
                                    foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'sizebag')->fetch() AS $sizebag){
                                        echo '<option value="'. $sizebag['metadata_id'] .'" '. ($sizebag['metadata_id'] == $bill['bill_sizebag'] ? 'selected' : '') .'>'. $sizebag['metadata_name'] .'</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label>Số lượng (Đơn vị Gam. 1000Gam = 1Kg)</label>
                                <input type="text" class="form-control round border-blue" value="<?=$bill['bill_amount']?>" name="bill_amount" placeholder="Nhập số lượng">
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="title">Đơn giá / 1Kg</label>
                                <input type="text" class="form-control round border-blue" value="<?=$bill['bill_price']?>" name="bill_price" placeholder="Nhập đơn giá">
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="title">Ghi chú</label>
                                <textarea name="bill_note" rows="5" class="form-control round border-blue" placeholder="Ghi chú đơn hàng"><?=$bill['bill_note']?></textarea>
                            </fieldset>
                        </div>
                        <div class="card-footer text-right">
                            <button id="bill_update" data-id="<?=$id?>" data-type="<?=$type?>" class="btn btn-outline-blue round"><?=$lang['title']?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
    case 'add':
        if(!in_array($type, ['buy', 'sell'])){
            echo 'Error';
            break;
        }
        switch ($type){
            case 'buy':
                $lang['title'] = 'Thêm hàng nhập về';
                break;
            case 'sell':
                $lang['title'] = 'Thêm hàng xuất đi';

                break;
        }

        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css', 'assets/css/plugins/animate/animate.min.css'];
        $js_plus            = ['custom.js?act=bill', 'assets/vendors/js/extensions/sweetalert.min.js'];
        $header['title'] = $lang['title'];
        require_once 'header.php';
        ?>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post">
                    <div class="card border-left-blue border-right-blue">
                        <div class="card-header"><h4 class="card-title"><?=$lang['title']?></h4> </div>
                        <div class="card-body">
                            <?php if($type=='sell'){?>
                            <fieldset class="form-group floating-label-form-group">
                                <label>Chọn khách hàng mua</label>
                                <select name="bill_customer" class="form-control round border-blue">
                                    <?php
                                    foreach ($db_duong->select('customer_id, customer_name')->from(_DB_TABLE_CUSTOMER)->fetch() AS $customer){
                                        echo '<option value="'. $customer['customer_id'] .'">'. $customer['customer_name'] .'</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                            <?php }?>
                            <fieldset class="form-group floating-label-form-group">
                                <label>Kiểu túi</label>
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
                                <label for="title">Kích thước túi</label>
                                <select name="bill_sizebag" class="form-control round border-blue">
                                    <option value="0">-- Chọn 1 loại kích thước --</option>
                                    <?php
                                    foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'sizebag')->fetch() AS $sizebag){
                                        echo '<option value="'. $sizebag['metadata_id'] .'">'. $sizebag['metadata_name'] .'</option>';
                                    }
                                    ?>
                                </select>
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label>Số lượng (Đơn vị Gam. 1000Gam = 1Kg)</label>
                                <input type="text" class="form-control round border-blue" name="bill_amount" placeholder="Nhập số lượng">
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="title">Đơn giá / 1Kg</label>
                                <input type="text" class="form-control round border-blue" name="bill_price" placeholder="Nhập đơn giá">
                            </fieldset>
                            <fieldset class="form-group floating-label-form-group">
                                <label for="title">Ghi chú</label>
                                <textarea name="bill_note" rows="5" class="form-control round border-blue" placeholder="Ghi chú đơn hàng"></textarea>
                            </fieldset>
                        </div>
                        <div class="card-footer text-right">
                            <button id="bill_add" data-user="<?=$user['user_id']?>" data-content="<?=$type?>" class="btn btn-outline-blue round"><?=$lang['title']?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        require_once 'footer.php';
        break;
    default:
        if(!in_array($type, ['buy', 'sell'])){
            echo "Error";
            break;
        }

        switch ($type){
            case 'buy':
                $lang['title']  = 'Danh sách hàng nhập về';
                $lang['add']    = 'Thêm hàng nhập về';
                break;
            case 'sell':
                $lang['title']  = 'Danh sách hàng xuất đi';
                $lang['add']    = 'Thêm hàng xuất đi';
                break;
        }

        $date_start     = isset($_GET['date_start'])    && !empty($_GET['date_start'])      ? trim($_GET['date_start'])     : '';
        $date_end       = isset($_GET['date_end'])      && !empty($_GET['date_end'])        ? trim($_GET['date_end'])       : '';
        $bill_handbag   = isset($_GET['bill_handbag'])  && !empty($_GET['bill_handbag'])    ? trim($_GET['bill_handbag'])   : '';
        $bill_sizebag   = isset($_GET['bill_sizebag'])  && !empty($_GET['bill_sizebag'])    ? trim($_GET['bill_sizebag'])   : '';
        $bill_user      = isset($_GET['bill_user'])     && !empty($_GET['bill_user'])       ? trim($_GET['bill_user'])      : '';
        $bill_customer  = isset($_GET['bill_customer']) && !empty($_GET['bill_customer'])   ? trim($_GET['bill_customer'])  : '';

        $data_where                         = [];
        $data_where['bill_type']            = $type;
        if($bill_handbag){
            $data_where['bill_handbag']     = $bill_handbag;
        }
        if($bill_sizebag){
            $data_where['bill_sizebag']     = $bill_sizebag;
        }
        if($bill_user){
            $data_where['bill_user']        = $bill_user;
        }
        if($bill_customer){
            $data_where['bill_customer']    = $bill_customer;
        }

        // Tính tổng số lượng product
        $db_duong->select('bill_id')->from(_DB_TABLE_BILL)->where($data_where);
        if($date_start && $date_end){
            $date_start = date('Y-m-d 00:00:00', strtotime($date_start));
            $date_end   = date('Y-m-d 23:59:59', strtotime($date_end));
            $db_duong->between('bill_time', $date_start, $date_end);
        }
        $db_duong->execute();
        $pagination['count']        = $db_duong->affected_rows;
        $pagination['page_row']     = _CONFIG_PAGINATION;
        $pagination['page_num']     = ceil($pagination['count']/$pagination['page_row']);
        $pagination['url']          = _CONFIG_URL_HOME.'/bill.php?type='. $type .'&page={page}';
        $pagination['page_start']   = ($page-1) * $pagination['page_row'];

        // Hiển thị dữ liệu
        $db_duong->from(_DB_TABLE_BILL)->where($data_where);
        if($date_start && $date_end){
            $db_duong->between('bill_time', $date_start, $date_end);
        }
        $db_duong->limit(_CONFIG_PAGINATION, $pagination['page_start']);
        $db_duong->order_by('bill_id', 'desc');
        $datas              = $db_duong->fetch();
        $header['title']    = $lang['title'];
        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css','assets/vendors/css/pickers/pickadate/pickadate.css'];
        $js_plus            = [
            'assets/vendors/js/extensions/sweetalert.min.js',
            'assets/vendors/js/pickers/pickadate/picker.js',
            'assets/vendors/js/pickers/pickadate/picker.date.js',
            'assets/vendors/js/pickers/pickadate/picker.time.js',
            'assets/vendors/js/pickers/pickadate/legacy.js',
            'custom.js?act=bill'
        ];
        require_once 'header.php';
        ?>
        <div class="row">
            <?php
            switch ($type){
                case 'buy':
                    ?>
                    <div class="col-md-2 text-center">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><span class="la la-calendar-o"></span></span></div>
                            <input type='text' name="date_start" value="<?=$_GET['date_start']?$_GET['date_start']: ''?>" class="form-control pickadate datepicker round" placeholder="Từ ngày" />
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><span class="la la-calendar-o"></span></span></div>
                            <input type='text' name="date_end" value="<?=$_GET['date_end']?$_GET['date_end']: ''?>" class="form-control pickadate datepicker round" placeholder="Đến ngày" />
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <select name="bill_handbag" class="form-control round border-blue">
                            <option value="">-- Chọn kiểu túi --</option>
                            <?php
                            foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'handbag')->fetch() AS $handbag){
                                echo '<option value="'. $handbag['metadata_id'] .'" '. ($_GET['bill_handbag'] == $handbag['metadata_id'] ? 'selected' : '') .'>'. $handbag['metadata_name'] .'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 text-center">
                        <select name="bill_sizebag" class="form-control round border-blue">
                            <option value="">-- Chọn kích thước túi --</option>
                            <?php
                            foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'sizebag')->fetch() AS $sizebag){
                                echo '<option value="'. $sizebag['metadata_id'] .'" '. ($_GET['bill_sizebag'] == $sizebag['metadata_id'] ? 'selected' : '') .'>'. $sizebag['metadata_name'] .'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 text-center">
                        <select name="bill_user" class="form-control round border-blue">
                            <option value="">-- Chọn người nhập liệu --</option>
                            <?php
                            foreach ($db_duong->select('user_id, user_fullname')->from(_DB_TABLE_USERS)->fetch() AS $select_user){
                                echo '<option value="'. $select_user['user_id'] .'"   '. ($_GET['bill_user'] == $select_user['user_id'] ? 'selected' : '') .'>'. $select_user['user_fullname'] .'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 text-right">
                        <button class="btn btn-outline-blue round" id="bill_search" data-type="<?=$type?>" style="width: 100%">Lọc dữ liệu</button>
                    </div>
                    <?php
                    break;
                case 'sell':
                ?>
                    <div class="col-md-2 text-center">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><span class="la la-calendar-o"></span></span></div>
                            <input type='text' name="date_start" value="<?=$_GET['date_start']?$_GET['date_start']: ''?>" class="form-control pickadate datepicker round" placeholder="Từ ngày" />
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><span class="la la-calendar-o"></span></span></div>
                            <input type='text' name="date_end" value="<?=$_GET['date_end']?$_GET['date_end']: ''?>" class="form-control pickadate datepicker round" placeholder="Đến ngày" />
                        </div>
                    </div>
                    <div class="col-md-2 text-center">
                        <select name="bill_handbag" class="form-control round border-blue">
                            <option value="">-- Chọn kiểu túi --</option>
                            <?php
                            foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'handbag')->fetch() AS $handbag){
                                echo '<option value="'. $handbag['metadata_id'] .'" '. ($_GET['bill_handbag'] == $handbag['metadata_id'] ? 'selected' : '') .'>'. $handbag['metadata_name'] .'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 text-center">
                        <select name="bill_sizebag" class="form-control round border-blue">
                            <option value="">-- Chọn kích thước túi --</option>
                            <?php
                            foreach ($db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_type', 'sizebag')->fetch() AS $sizebag){
                                echo '<option value="'. $sizebag['metadata_id'] .'" '. ($_GET['bill_sizebag'] == $sizebag['metadata_id'] ? 'selected' : '') .'>'. $sizebag['metadata_name'] .'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 text-center">
                        <select name="bill_user" class="form-control round border-blue">
                            <option value="">-- Chọn người nhập liệu --</option>
                            <?php
                            foreach ($db_duong->select('user_id, user_fullname')->from(_DB_TABLE_USERS)->fetch() AS $bill_user){
                                echo '<option value="'. $bill_user['user_id'] .'"   '. ($_GET['bill_user'] == $bill_user['user_id'] ? 'selected' : '') .'>'. $bill_user['user_fullname'] .'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 text-right">
                        <button class="btn btn-outline-blue round" id="bill_search" data-type="<?=$type?>" style="width: 100%">Lọc dữ liệu</button>
                    </div>
                <?php
                break;
            }
            ?>
        </div><br />
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=$lang['title']?> <small>(<?=$pagination['count'].' bản ghi'?>)</small></h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right" href="bill.php?act=add&type=<?=$type?>"><?=$lang['add']?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content mt-1">
                        <div class="table-responsive">
                            <table id="recent-orders" class="table table-hover table-xl mb-0">
                                <thead>
                                <tr>
                                    <?php if($type == 'buy'){?>
                                    <th class="border-top-0 text-center" width="10%">Kiểu túi</th>
                                    <th class="border-top-0 text-center" width="10%">Kích thước</th>
                                    <th class="border-top-0 text-center" width="10%">Số lượng (g)</th>
                                    <th class="border-top-0 text-center" width="10%">Đơn giá</th>
                                    <th class="border-top-0 text-center" width="10%">Thành tiền</th>
                                    <th class="border-top-0 text-center" width="10%">Người lập phiếu</th>
                                    <th class="border-top-0 text-center" width="10%">Ghi chú</th>
                                    <th class="border-top-0 text-center" width="20%">Thời gian</th>
                                    <th class="border-top-0 text-center" width="10%">Quản trị</th>
                                    <?php }else{?>
                                    <th class="border-top-0 text-left" width="10%">Khách hàng</th>
                                    <th class="border-top-0 text-center" width="10%">Kiểu túi</th>
                                    <th class="border-top-0 text-center" width="10%">Kích thước</th>
                                    <th class="border-top-0 text-center" width="10%">Số lượng (g)</th>
                                    <th class="border-top-0 text-center" width="10%">Đơn giá</th>
                                    <th class="border-top-0 text-center" width="10%">Thành tiền</th>
                                    <th class="border-top-0 text-center" width="10%">Người lập phiếu</th>
                                    <th class="border-top-0 text-center" width="10%">Ghi chú</th>
                                    <th class="border-top-0 text-center" width="10%">Thời gian</th>
                                    <th class="border-top-0 text-center" width="10%">Quản trị</th>
                                    <?php }?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(count($datas) == 0){
                                    echo "<tr><td colspan='". ($type == 'buy' ? 9 : 10) ."' class='text-danger text-center'>Không có dữ liệu để hiển thị</td></tr>";
                                }
                                foreach ($datas AS $bill){
                                    $bill_handbag   = $db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_id', $bill['bill_handbag'])->fetch_first();
                                    $bill_sizebag   = $db_duong->select('metadata_id, metadata_name')->from(_DB_TABLE_METADATA)->where('metadata_id', $bill['bill_sizebag'])->fetch_first();
                                    $bill_user      = $db_duong->select('user_fullname')->from(_DB_TABLE_USERS)->where('user_id', $bill['bill_user'])->fetch_first();
                                    $bill_customer  = $db_duong->select('customer_name')->from(_DB_TABLE_CUSTOMER)->where('customer_id', $bill['bill_customer'])->fetch_first();
                                    ?>
                                    <tr id="tr_<?=$bill['bill_id']?>">
                                        <?php
                                        if($type == 'buy') {?>
                                        <td class="text-center"><?=$bill_handbag['metadata_name']?></td>
                                        <td class="text-center"><?=$bill_sizebag['metadata_name']?></td>
                                        <?php }else{?>
                                        <td class="text-left"><?=$bill_customer['customer_name']?></td>
                                        <td class="text-center"><?=$bill_handbag['metadata_name']?></td>
                                        <td class="text-center"><?=$bill_sizebag['metadata_name']?></td>
                                        <?php }?>
                                        <td class="text-center"><?=$bill['bill_amount']._CONFIG_UNIT?></td>
                                        <td class="text-center"><?=$function_duong->convertNumberMoney($bill['bill_price'])._CONFIG_MONEY?></td>
                                        <td class="text-center"><?=$function_duong->convertNumberMoney($bill['bill_total_price'])._CONFIG_MONEY?></td>
                                        <td class="text-center"><?=$bill_user['user_fullname']?></td>
                                        <td class="text-center"><?=$bill['bill_note']?></td>
                                        <td class="text-center"><?=date('H:i:s d/m/Y', strtotime($bill['bill_time']))?></td>
                                        <td class="text-center">
                                            <a href="bill.php?act=update&type=<?=$bill['bill_type']?>&id=<?=$bill['bill_id']?>" class="text-info"><i class="la la-pencil-square-o"></i> Sửa</a>
                                            <a href="javascript:;" class="text-danger" data-text="bill_delete" data-content="<?=$bill['bill_id']?>" data-type="<?=$type?>"><i class="la la-trash-o"></i> Xóa</a>
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