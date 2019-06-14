<?php
require_once 'src/core.php';
$header['title'] = (isset($header['title']) ? $header['title'] : 'Trang Quản Trị');
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="BUYNHANH.COM">
    <title><?=$header['title']?></title>
    <link rel="apple-touch-icon" href="<?=_URL_HOME?>/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?=_URL_HOME?>/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Comfortaa:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700" rel="stylesheet">
    <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="assets/fonts/simple-line-icons/style.min.css">
    <?php foreach ($css_plus AS $css){?>
    <link rel="stylesheet" type="text/css" href="<?php echo $css;?>">
    <?php }?>
    <script src="assets/vendors/js/vendors.min.js" type="text/javascript"></script>
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light bg-info navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item">
                    <a class="navbar-brand" href="index.php">
                        <img class="brand-logo" alt="modern admin logo" src="<?=_CONFIG_URL_HOME?>/assets/images/logo/logo-80x80.png">
                        <h3 class="brand-text">DƯƠNG TRANG</h3>
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
                    <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i></a>
                        <div class="search-input">
                            <input class="input" type="text" placeholder="Tìm kiếm ...">
                        </div>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="mr-1">Xin chào ,<span class="user-name text-bold-700"><?=$user['user_fullname']?></span></span>
                            <span class="avatar avatar-online"><img src="<?=_CONFIG_URL_AVATAR?>" alt="avatar"><i></i></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#"><i class="ft-user"></i> Xem trang cá nhân</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"><i class="la la-gears"></i> Sửa trang cá nhân</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?=_CONFIG_URL_LOGOUT?>"><i class="ft-power"></i> Thoát</a>
                        </div>
                    </li>
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
                            <i class="ficon ft-bell"></i>
                            <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span class="grey darken-2">Thông báo</span></h6>
                                <span class="notification-tag badge badge-default badge-danger float-right m-0"></span>
                            </li>
                            <li class="scrollable-container media-list w-100">

                            </li>
                            <!--<li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li> Đọc tất cả thông báo-->
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header">
                <span data-i18n="nav.category.layouts">Nội dung</span>
                <i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
            </li>
            <li class=" nav-item">
                <a href="#"><i class="icon-logout"></i><span class="menu-title"> Quản lý hàng nhập</span></a>
                <ul class="menu-content">
                    <li <?php echo ($header['module'] == 'bill' && in_array($type, array('buy')) && in_array($act, ['', 'update'])) ? 'class="active"' : '';?>>
                        <a class="menu-item" href="<?=_CONFIG_URL_HOME?>/bill.php?type=buy"><i class="ft-list"></i> Danh sách hàng nhập về</a>
                    </li>
                    <li <?php echo ($header['module'] == 'bill' && $act == 'add' && $type == 'buy') ? 'class="active"' : '';?>>
                        <a class="menu-item" href="<?=_CONFIG_URL_HOME?>/bill.php?act=add&type=buy"><i class="ft-file-plus"></i> Thêm hàng nhập về</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="#"><i class="icon-login"></i><span class="menu-title"> Quản lý hàng xuất</span></a>
                <ul class="menu-content">
                    <li <?php echo ($header['module'] == 'bill' && in_array($type, array('sell')) && in_array($act, ['', 'update'])) ? 'class="active"' : '';?>>
                        <a class="menu-item" href="<?=_CONFIG_URL_HOME?>/bill.php?type=sell"><i class="ft-list"></i> Danh sách hàng xuất đi</a>
                    </li>
                    <li <?php echo ($header['module'] == 'bill' && $act == 'add' & $type == 'sell') ? 'class="active"' : '';?>>
                        <a class="menu-item" href="<?=_CONFIG_URL_HOME?>/bill.php?act=add&type=sell"><i class="ft-file-plus"></i> Thêm hàng xuất đi</a>
                    </li>
                </ul>
            </li>
            <!-- BAN QUẢN TRỊ -->
            <li class=" navigation-header">
                <span data-i18n="nav.category.layouts">Ban Quản Trị</span>
                <i class="la la-diamond ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
            </li>
            <li class=" nav-item">
                <a href="#"><i class="ft-calendar"></i> <span class="menu-title">Quản lý túi</span></a>
                <ul class="menu-content">
                    <li <?php echo ($header['module'] == 'metadata' && in_array($act, ['handbag'])) ? 'class="active"' : '';?>>
                        <a class="menu-item" href="<?=_CONFIG_URL_HOME?>/metadata.php?act=handbag">
                            <i class="la la-credit-card"></i> Loại Túi
                        </a>
                    </li>
                    <li <?php echo ($header['module'] == 'metadata' && in_array($act, ['sizebag'])) ? 'class="active"' : '';?>>
                        <a class="menu-item" href="<?=_CONFIG_URL_HOME?>/metadata.php?act=sizebag">
                            <i class="ft-crop"></i> Kích thước túi
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="#"><i class="ft-users"></i><span class="menu-title">Quản lý khách hàng</span></a>
                <ul class="menu-content">
                    <li <?php echo ($header['module'] == 'customer' && in_array($act, array(''))) ? 'class="active"' : '';?>>
                        <a class="menu-item" href="<?=_CONFIG_URL_HOME?>/customer.php">
                            <i class="ft-user"></i> Danh sách khách hàng
                        </a>
                    </li>
                    <li <?php echo ($header['module'] == 'customer' && $act == 'add') ? 'class="active"' : '';?>>
                        <a class="menu-item" href="<?=_CONFIG_URL_HOME?>/customer.php?act=add">
                            <i class="ft-user-plus"></i> Thêm khách hàng
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item">
                <a href="#"><i class="ft-user"></i><span class="menu-title">Quản lý thành viên</span></a>
                <ul class="menu-content">
                    <li <?php echo ($header['module'] == 'user' && in_array($act, ['', 'update'])) ? 'class="active"' : '';?>>
                        <a class="menu-item" href="<?php echo _CONFIG_URL_HOME;?>/user.php">
                            <i class="ft-users"></i> Danh sách thành viên
                        </a>
                    </li>
                    <li <?php echo ($header['module'] == 'user' && in_array($act, array('add'))) ? 'class="active"' : '';?>>
                        <a class="menu-item" href="<?php echo _CONFIG_URL_HOME;?>/user.php?act=add">
                            <i class="ft-user-plus"></i> Thêm thành viên
                        </a>
                    </li>
                </ul>
            </li>
            <!-- BAN QUẢN TRỊ -->
            <li class=" navigation-header">
                <span data-i18n="nav.category.layouts">Điều hướng</span>
                <i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Layouts"></i>
            </li>
            <li class=" nav-item"><a href="<?php echo _CONFIG_URL_LOGOUT;?>"><i class="la la-long-arrow-left"></i><span class="menu-title">Đăng xuất</span></a></li>
        </ul>
    </div>
</div>
<div class="app-content content">
    <div class="content-wrapper">
