<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=batdongsan.xls");
header("Pragma: no-cache");
header("Expires: 0");
//---------------------------------------
?>
<?php
	include('simple_html_dom.php');
	$url = '';
	$start_page = '';
	$end_page = '';
	if (isset($_POST['link']) ) {
		$url = $_POST['link'];
		$start_page = $_POST['startpage'];
		$end_page = $_POST['endpage'];
		$alldata = getData($url, $end_page, $start_page);
		$col = array();
		foreach ($alldata as $value) {
			$col['0'] = $value['1'];
			$col['1'] = $value['3'];
			$col['2'] = $value['4'];
			$col['3'] = $value['5'];
			$col['4'] = $value['name'];
			$col['5'] = $value['address'];
			$col['6'] = $value['phone'];
			$col['7'] = $value['mobile'];
			$col['8'] = $value['email'];
			$col['9'] = $value['link'];
			$data[] = $col;
		}
		/*echo '<pre>';
		print_r($data);*/
	}
	function getData($url ,$end_page,$start_page){
		$file_path = 'path.html';
		$links = getLinks($url,$end_page,$start_page );
		foreach ($links as $key => $link) {
			$contents = getHtml($link);
			save_content($file_path,$contents);
			$data[] = getCustomerInfo($file_path, $link);
		}
		file_put_contents($file_path, '');
		return $data;
	}
	//get link nhiều trang
	function getLinks($url, $end_page, $start_page = 1){
		$file_path = 'path.html';
		$data = array();
		$link_path = $url;

		for ($i = $start_page; $i <= $end_page; $i++) {
			if ($i>1) {
				$link_path = "$url/p$i";
			}
			$contents = getHtml($link_path);
			save_content($file_path, $contents);
			$new_data = getLink($file_path);
			foreach ($new_data as $key => $value) {
				array_push($data, $value);
			}
		}
		return $data;
	}
	//get link HTML file html
	function getLink($file){
		$get_link = file_get_html($file);
		$link = array();
		foreach($get_link->find('div[class=p-title] > a') as $e) {
			if($e->href){
				$link[] = 'http://batdongsan.com.vn' . $e->href;
			}
			else {
				return $link;
			}
		}
		return $link;
	}
	// Get nội dung HTML trang HTML cần get link
	function getHtml($url){
		$ch = curl_init();
	//-------------------------------
		curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux i686; pt-BR; rv:1.9.2.18) Gecko/20110628 Ubuntu/10.04 (lucid) Firefox/3.6.18' );
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 30000 );
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		return $result;
	}
	// get data
	function getCustomerInfo($file, $link){
		$getInfo = file_get_html($file);
		foreach ($getInfo->find('div[class=left-detail] > div[class=right] > a') as $key => $e) {
			if (isset($e->innertext)) {
				foreach($getInfo->find('div[class=left-detail] > div[class=right]') as $e1) {
					if (isset($e1->innertext)) {
						$info[] = $e1->innertext;
					}
					else{
						$info[] = "NULL";
					}
					if (count($info) >= 6) {
						break;
					}
				}
				break;
			}
			break;
		}
		$info[] = "NULL";
		foreach($getInfo->find('div[class=left-detail] > div[class=right]') as $e) {
			if (isset($e->innertext)) {
				$info[] = $e->innertext;
			}
			else{
				$info[] = "NULL";
			}
			if (count($info) >= 6) {
				break;
			}
		}
		//array_shift($info);
		if (count($info) <= 6 ) {
			for ($i=1; $i <= (6-count($info)); $i++) { 
				$info[] = 'NULL';
			}
		}
		/*foreach($getInfo->find('div[id=LeftMainContent__productDetail_floor] > div[class=right]') as $e) {
			if (isset($e->innertext)) {
				$info['floor'] = $e->innertext;
			}else{
				$info['floor'] = "NULL";
			}
		}*/
		//--------------------- Name -------------------------
		if (count($getInfo->find('div[id=LeftMainContent__productDetail_contactName] > div[class=right]')) > 0) {
			foreach($getInfo->find('div[id=LeftMainContent__productDetail_contactName] > div[class=right]') as $e) {
				if (isset($e->innertext)) {
					$info['name'] = $e->innertext;
				}
			}
		}
		else{
			$info['name'] = "NULL";
		}
		//--------------------- Address -------------------------
		if (count($getInfo->find('div[id=LeftMainContent__productDetail_contactAddress] > div[class=right]')) > 0) {
			foreach($getInfo->find('div[id=LeftMainContent__productDetail_contactAddress] > div[class=right]') as $e) {
				if (isset($e->innertext)) {
					$info['address'] = $e->innertext;
				}
			}
		}
		else{
			$info['address'] = "NULL";
		}
		//--------------------- Phone -------------------------
		if (count($getInfo->find('div[id=LeftMainContent__productDetail_contactPhone] > div[class=right]')) > 0) {
			foreach($getInfo->find('div[id=LeftMainContent__productDetail_contactPhone] > div[class=right]') as $e) {
				if (isset($e->innertext)) {
					$info['phone'] = $e->innertext;
				}
			}
		}
		else{
			$info['phone'] = "NULL";
		}
		//--------------------- Mobile -------------------------
		if (count($getInfo->find('div[id=LeftMainContent__productDetail_contactMobile] > div[class=right]')) > 0) {
			foreach($getInfo->find('div[id=LeftMainContent__productDetail_contactMobile] > div[class=right]') as $e) {
				if (isset($e->innertext)) {
					$info['mobile'] = $e->innertext;
				}
			}
		}
		else{
			$info['mobile'] = "NULL";
		}
		//--------------------- Email -------------------------
		if (count($getInfo->find('div[id=LeftMainContent__productDetail_contactEmail] > script]')) > 0) {
			foreach($getInfo->find('div[id=LeftMainContent__productDetail_contactEmail] > script]') as $e) {
				if (isset($e->innertext)) {
					$new_str = explode("'>", $e->innertext);
					$info['email'] = strstr( $new_str[0], '&' );
				}
			}
		}
		else{
			$info['email'] = "NULL";
		}
		$info['link'] = '<a href="'.$link.'">Link Page</a>';
		return $info;
	}
	
	// lưu nội dung HTMl vào file path.html
	function save_content($file_path, $contents){
		file_put_contents($file_path, '');
		file_put_contents($file_path, $contents);
	}
?>
<meta charset="utf-8" />
<table>
    <thead>
        <tr>
        	<td>Địa Chỉ</td>
        	<td>Loại Giao Tin</td>
        	<td>Ngày đăng kí</td>
        	<td>Ngày hết hạn</td>
            <td>Tên liên lạc</td>
            <td>Địa chỉ</td>
            <td>Điện thoại</td>
            <td>Mobile</td>
            <td>Email</td>
            <td>Link</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row):?>
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
            <?= $row['4']; ?>
            </td>
            <td>
            <?= $row['5']; ?>
            </td>
            <td>
            <?= $row['6']; ?>
            </td>
            <td>
            <?= $row['7']; ?>
            </td>
            <td>
            <?= $row['8']; ?>
            </td>
            <td>
            <?= $row['9']; ?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>