<?php
require_once 'src/core.php';
if(!$user){
    $function_duong->redirectUrl(_CONFIG_URL_LOGIN);
}
$header['module'] = 'metadata';
switch ($act){
    case in_array($act, ['handbag', 'sizebag']):
        $lang               = [];
        // Cài đặt biến ngôn ngữ
        switch ($act){
            case 'handbag':
                $lang['title']              = 'Quản lý loại túi';
                $lang['lable_add']          = 'Thêm loại túi';
                $lang['input_metaname']     = 'Nhập tên loại túi';
                $lang['input_submit_add']   = 'Thêm loại túi';
                $lang['list_meta']          = 'Danh sách loại túi';
                $lang['list_edit']          = 'Sửa kiểu túi';
                break;
            case 'sizebag':
                $lang['title']              = 'Quản lý kích thước túi';
                $lang['lable_add']          = 'Thêm kích thước túi';
                $lang['input_metaname']     = 'Nhập kích thước của túi';
                $lang['input_submit_add']   = 'Thêm kích thước túi';
                $lang['list_meta']          = 'Danh sách kích thước túi';
                $lang['list_edit']          = 'Sửa kích thước túi';
                break;
        }
        $header['title']    = $lang['title'];
        $css_plus           = ['assets/vendors/css/extensions/sweetalert.css'];
        $js_plus            = ['custom.js?act=handbag', 'assets/vendors/js/extensions/sweetalert.min.js'];
        require_once 'header.php';
        ?>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card border-left-blue border-right-blue">
                    <div class="card-header"><h4 class="card-title"> <?=$lang['lable_add']?></h4></div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="label"><small><?=$lang['input_metaname']?></small></label>
                            <input type="text" placeholder="<?=$lang['input_metaname']?>" class="round form-control border-blue" name="metadata_name" autofocus>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn round btn-outline-blue" id="metadata_add" data-act="<?=$act?>"><?=$lang['input_submit_add']?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card border-left-blue border-right-blue">
                    <div class="card-header">
                        <h4 class="card-title"><?=$lang['list_meta']?></h4>
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
                                    echo '<tr id="trMetaData_'. $metadata['metadata_id'] .'">';
                                    echo '<td width="50%" class="text-bold-700">';
                                    echo '<a data-toggle="modal" id="result_metadata_update_'. $metadata['metadata_id']  .'" data-target="#metadata_update_modal_'. $metadata['metadata_id'] .'" href="javascript:;"><i class="la la-long-arrow-right"></i> '. $metadata['metadata_name'] .'</a>';
                                    ?>
                                    <div class="modal fade text-left" id="metadata_update_modal_<?=$metadata['metadata_id']?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title"><?=$lang['list_edit']?></h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <fieldset class="form-group floating-label-form-group">
                                                        <label><small><?=$lang['input_metaname']?></small></label>
                                                        <input type="text" class="form-control round border-blue" id="metadata_update_text_<?=$metadata['metadata_id']?>" placeholder="Kiểu túi" value="<?=$metadata['metadata_name']?>">
                                                    </fieldset>
                                                    <br>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-outline-secondary round" data-dismiss="modal">Đóng</button>
                                                    <button class="btn btn-outline-primary round" data-src="<?=$act?>" data-text="metadata_update" data-content="<?=$metadata['metadata_id']?>">
                                                        Cập nhật
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    echo '</td>';
                                    echo '<td width="30%" class="text-center">'. date('Y-m-d H:i:s', strtotime($metadata['metadata_time'])) .'</td>';
                                    echo '<td width="20%" class="text-center"><a class="text-danger" href="javascript:;" data-text="metadata_delete" data-act="'. $act .'" data-content="'. $metadata['metadata_id'] .'"><i class="ft-trash-2"></i> Xóa</a></td>';
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
