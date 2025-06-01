<?php
$routes['default_controller'] = 'home';
/*
    Đường dân ảo => đường dân thật
*/
$routes['san-pham'] = 'product/index';
$routes['danh-sach-san-pham'] = 'product/list_product';
$routes['chi-tiet-san-pham'] = 'product/detail';
$routes['trang-chu'] = 'home';
$routes['tin-tuc/.+-(\d).html'] = 'news/category/$1';