<?php 
include('simple_html_dom.php');
// khai bai biến
$out_link_shop_unique = array();
$out_info_shop_refine = array();
//
$link_shop = file_get_contents("https://www.chodientu.vn/dien-thoai-di-dong");
$preg_link_shop = '/<a class="p-seller" target="_blank" href="(.*)">(.*)<\/a>/U';
$preg_info_shop = '/<li><i (.*)"><\/i>(.*)<\/li>/U';
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
	preg_match_all($preg_info_shop, $info_shop , $out_info_shop, PREG_SET_ORDER);
	// xóa các phần tử trong mảng
	$count_info_refine = count($info_refine);
	for ($i=0; $i < $count_info_refine; $i++) { 
		array_shift($info_refine);
	}
	foreach ($out_info_shop as $key => $valuee) {
		$info_refine[] = $valuee[2];
	}
	$info_refine[] = $value;
	$out_info_shop_refine[] = $info_refine;
}
echo '<pre>';
var_dump($out_info_shop_refine);



/*preg_match_all('/<li><i (.*)"><\/i>(.*)<\/li>/U',
    file_get_contents($value[0][1]),
    $out_contact, PREG_SET_ORDER);
foreach ($out_contact as $key => $value) {
	echo $value[2] . '<br />';
}*/
?>