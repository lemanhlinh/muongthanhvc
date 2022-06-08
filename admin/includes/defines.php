<?php

$sort_path = $_SERVER['SCRIPT_NAME'];
//	$sort_path = str_replace('/index.php','', $sort_path);
$sort_path = (preg_replace('/\/[a-zA-Z0-9\_]+\.php/i', '', $sort_path));

// lấy folder administrator

$pos = strripos($sort_path, '/');
$folder_admin = substr($sort_path, ($pos + 1));

define('URL_ROOT', "http://" . $_SERVER['HTTP_HOST'] . str_replace($folder_admin, '', $sort_path));
define('URL_ROOT_REDUCE', str_replace($folder_admin, '', $sort_path));
define('URL_ROOT_ADMIN', str_replace('/', '', $sort_path) . '/');

if (!defined('DS')) {

    define('DS', DIRECTORY_SEPARATOR);

}
$path = $_SERVER['SCRIPT_FILENAME'];
$path = str_replace('index.php', '', $path);
$path = str_replace('index2.php', '', $path);
$path = str_replace('/', DS, $path);
$path = str_replace('\\', DS, $path);
$path = str_replace(DS . $folder_admin . DS, DS, $path);

define('PATH_BASE', $path);
define('IS_REWRITE', 1);
define('WRITE_LOG_MYSQL', 0);
define('USE_MEMCACHE', 0);

define('GROUP_0', 0);
define('GROUP_1', 1);
define('GROUP_2', 2);
define('GROUP_COMPANY', [
    GROUP_0 => 'Admin',
    GROUP_1 => 'Tập đoàn',
    GROUP_2 => 'Đơn vị'
]);

define('POSITION_GROUP_1_1', 1);
define('POSITION_GROUP_1_2', 2);
define('POSITION_GROUP_1_3', 3);
define('POSITION_GROUP_1_4', 4);
define('POSITION_GROUP_1_5', 5);

define('POSITION_GROUP_2_1', 1);
define('POSITION_GROUP_2_2', 2);
define('POSITION_GROUP_2_3', 3);
define('POSITION_GROUP_2_4', 4);

define('POSITION_GROUP_1', [
    POSITION_GROUP_1_1 => 'Kế toán tổng hợp',
    POSITION_GROUP_1_2 => 'Tổng giám đốc',
    POSITION_GROUP_1_3 => 'Ban tài chính',
    POSITION_GROUP_1_4 => 'Ban Kinh Doanh',
    POSITION_GROUP_1_5 => 'Phòng ban khác',
]);

define('POSITION_GROUP_2', [
    POSITION_GROUP_2_1 => 'Kế toán trưởng',
    POSITION_GROUP_2_2 => 'Giám đốc khách sạn',
    POSITION_GROUP_2_3 => 'Kế toán trưởng KS',
    POSITION_GROUP_2_4 => 'Kinh doanh khách sạn',
]);

define('VOUCHER_1', 1);
define('VOUCHER_2', 2);
define('VOUCHER_3', 3);
define('VOUCHER_4', 4);
define('TYPE_VOUCHER', [
    VOUCHER_1 => 'Voucher phòng nghỉ miễn phí',
    VOUCHER_2 => 'Voucher phòng nghỉ có mệnh giá',
    VOUCHER_3 => 'Voucher tiền mặt',
    VOUCHER_4 => 'Các loại Voucher khác phát sinh',
]);


$positions = array(
    'top_default' => 'Top',
    'bot_default' => 'Bottom',
    'home_news' => 'Tin tức',
//		'home_full' => 'Banner full',
//		'home_products' => 'Sản phẩm trang chủ',
//		'news' => 'slide tin full',
    'top' => 'Home Top'
);

?>

