<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=chodientu.xls");
header("Pragma: no-cache");
header("Expires: 0");
//---------------------------------------
?>
<?php 
include('simple_html_dom.php');
error_reporting(0);
// khai bai biến
$url = "https://www.chodientu.vn/do-dung-nha-bep";
$end = 42;
$out_link_shop_unique = array();
$out_info_shop_refine = array();
$link_shop = "";
//
//reg 
$preg_link_shop = '/<a class="p-seller" target="_blank" href="(.*)">(.*)<\/a>/U';
$preg_info_shop = '/<li><i (.*)"><\/i>(.*)<\/li>/U';
$preg_name_shop = '/shop-name"><span>(.*)<\/span>/U';
//=====
$url_page[] = $url;
for ($i=2; $i <= $end; $i++) {
	$url_page[] = "$url?trang=$i";
	foreach ($url_page as $key => $value) {
		$content = file_get_contents($value);
		$link_shop = $link_shop . $content;
	}
}
preg_match_all($preg_link_shop, $link_shop, $out_link_shop, PREG_SET_ORDER);
//loai bo shop trùng nhau trong mang $out_link_shop
foreach ($out_link_shop as $value) {
	$link_shop_unique[] = $value[1];
}
$out_link_shop_unique = array_unique($link_shop_unique);
// lấy thoogn tin shop

foreach ($out_link_shop_unique as $key => $value) {
	$out_info_shop = '';
	$info_shop = file_get_contents($value);
	preg_match_all($preg_name_shop, $info_shop , $name_shop, PREG_SET_ORDER);
	preg_match_all($preg_info_shop, $info_shop , $out_info_shop, PREG_SET_ORDER);
	// xóa các phần tử trong mảng
	$count_info_refine = count($info_refine);
	for ($i=0; $i < $count_info_refine; $i++) { 
		array_shift($info_refine);
	}
	$info_refine[] = $name_shop[0][1];
	foreach ($out_info_shop as $key => $valuee) {
		$info_refine[] = $valuee[2];
	}
	$info_refine[] = $value;
	$out_info_shop_refine[] = $info_refine;
}
?>
<meta charset="utf-8" />
<table>
    <thead>
        <tr>
        	<td>Tên gian hàng</td>
        	<td>Địa chỉ</td>
        	<td>Số điện thoại</td>
        	<td>Email</td>
        	<td>Link</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($out_info_shop_refine as $row):?>
        <tr>
        	<td>
            <?= $row['0']; ?>
            </td>
            <td>
            <?= $row['1']; ?>
            </td>
            <td>
            <?= $row['2']; ?>
            </td>
            <td>
            <?= $row['3']; ?>
            </td>
            <td>
            <?= '<a href="'. $row['4'] . '">Link page</a>'; ?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>