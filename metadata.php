<?php
require_once 'src/core.php';
if(!$user){
    $function_duong->redirectUrl(_CONFIG_URL_LOGIN);
}
$header['module'] = 'metadata';
switch ($act){
    case 'handbag':
        $header['title']    = 'Quản lý loại túi';
        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css'];
        $js_plus            = ['custom.js?act=handbag', 'assets/vendors/js/extensions/sweetalert.min.js'];
        require_once 'header.php';
        ?>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card border-left-blue border-right-blue">
                    <div class="card-header"><h4 class="card-title"> Thêm mới</h4></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="label"><small>Tên loại túi</small></label>
                            <input type="text" placeholder="Nhập tên loại túi" class="rounded form-control border-blue" name="handbag_name" autofocus>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn rounded btn-outline-blue" id="handbag_add">Thêm loại túi</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card border-left-blue border-right-blue">
                    <div class="card-header">
                        <h4 class="card-title">Danh sách</h4>
                    </div>
                    <div class="card-content mt-1">
                        <div class="table-responsive">
                            <table id="recent-orders" class="table table-hover table-xl mb-0">
                                <tbody>
                                <?php
                                $metadatas = $db_duong->from(_DB_TABLE_METADATA)->where('metadata_type', $act)->fetch();
                                if(count($metadatas) == 0){
                                    echo '<tr><td colspan="3" class="text-center">Chưa có dữ liệu để hiển thị</td></tr>';
                                }
                                foreach ($metadatas AS $metadata){
                                    echo '<tr id="handbagData_'. $metadata['metadata_id'] .'">';
                                        echo '<td width="50%" class="text-bold-700"><i class="la la-long-arrow-right"></i> '. $metadata['metadata_name'] .'</td>';
                                        echo '<td width="30%" class="text-center">'. date('Y-m-d H:i:s', strtotime($metadata['metadata_time'])) .'</td>';
                                        echo '<td width="20%" class="text-center"><a class="text-danger" href="javascript:;" data-text="handbag_delete" data-content="'. $metadata['metadata_id'] .'"><i class="ft-trash-2"></i> Xóa</a></td>';
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
