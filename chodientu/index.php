<?php 
	include"simple_html_dom.php";
	$page = 25;
	$start_page = "0";
	$end_page = "";
	$url = "";
	$html = array();
	$data = "";
	// danh sách cac danh muc cần get data
	$danh_sach_danh_muc = lay_link();
	$danh_muc_get = 0;
	$dmshop = array();

	//$listshop = array();
	if (isset($_POST['btn'])) {
		//get value var
		if (isset($_POST['url'])) {
			$url = $_POST['url'];
		}
		//-----------------------
		//lay_html($url);
		//$dsshop = lay_danh_sach_shop();


		//----------------------
		// id danh muc cần get data
		$danh_muc_get = $_POST['danh_muc_get'];

		$start_page = $_POST['start_page'];
		$end_page = $start_page + $page;

		// next trang
		$start_page = $end_page;
		$page = $_POST['page'];
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<?php //print_r($dsshop); 
	$html = file_get_html('path.html');
	foreach ($html->find('a') as $value) {
		echo $value->href;
	}
	?>
	<form action="index.php" method="POST">
		Link : <input type="text" name="url" value="<?= $danh_sach_danh_muc["$danh_muc_get"]; ?>" /><br />
		Danh mục (<?= count($danh_sach_danh_muc); ?>) : <input type="number" name="danh_muc_get" value="<?= $danh_muc_get; ?>"><br />
		Từ trang : <input type="text" name="start_page" value="<?= $start_page; ?>" /> <br />
		Tiếp đến trang : <input type="text" name="page" value="<?= $page; ?>"><br />
		 <input type="submit" name="btn" value="Getdata"><br />
	</form>
	Danh sách danh mục: <br />
		<?php 
		foreach ($danh_sach_danh_muc as $key => $value) {
			echo $key . '=>' . "'$value'" . ',<br />';
		}
		 ?>
</body>
</html>
<?php 

	
	//lay noi dung html
	function lay_html($url){
		$content = file_get_contents($url);
		file_put_contents('path.html', '');
		file_put_contents('path.html', $content);
	}
	// link danh muc cần lấy
	function lay_danh_sach_shop(){
		$list = array();
		$file_path = 'path.html';
		$html = file_get_html("$file_path");
		/*foreach ($html->find('div') as $value) {
			$list[] = $value->href;
		}*/
		return $list;
	}

	//=============
	// lấy link cac danh mục cần get
	/*function lay_link(){
		$danh_sach_danh_muc = array();
		$url = 'https://www.chodientu.vn/';
		$html = file_get_html($url);
		foreach ($html->find('div[class=as-submenu] > ul > li > a') as $value) {
			$danh_sach_danh_muc[] = $value->href;
		}
		return $danh_sach_danh_muc;
	}*/
	function lay_link(){
		$danh_sach_danh_muc = array(
			0=>'https://www.chodientu.vn/phong-ngu',
			1=>'https://www.chodientu.vn/phong-tam-phong-ve-sinh',
			2=>'https://www.chodientu.vn/do-dung-nha-bep',
			3=>'https://www.chodientu.vn/do-trang-tri-1543',
			4=>'https://www.chodientu.vn/do-dung-an-uong-4459',
			5=>'https://www.chodientu.vn/dung-cu-sua-chua',
			6=>'https://www.chodientu.vn/dien-gia-dung',
			7=>'https://www.chodientu.vn/ve-sinh-nha-cua',
			8=>'https://www.chodientu.vn/tien-ich-ca-nhan',
			9=>'https://www.chodientu.vn/noi-ngoai-that',
			10=>'https://www.chodientu.vn/nha-cua-do-gia-dung',
			11=>'https://www.chodientu.vn/dien-thoai-di-dong',
			12=>'https://www.chodientu.vn/linh-phu-kien-dien-thoai',
			13=>'https://www.chodientu.vn/phu-kien-may-tinh-bang',
			14=>'https://www.chodientu.vn/may-tinh-bang',
			15=>'https://www.chodientu.vn/quan-ao-nu',
			16=>'https://www.chodientu.vn/quan-ao-nam',
			17=>'https://www.chodientu.vn/do-cuoi',
			18=>'https://www.chodientu.vn/thoi-trang-trang-suc-khac',
			19=>'https://www.chodientu.vn/trang-phuc-tre-so-sinh',
			20=>'https://www.chodientu.vn/thoi-trang-tre-em',
			21=>'https://www.chodientu.vn/giay-dep',
			22=>'https://www.chodientu.vn/tui-cap-vi',
			23=>'https://www.chodientu.vn/trang-suc',
			24=>'https://www.chodientu.vn/phu-trang',
			25=>'https://www.chodientu.vn/thoi-trang-trang-suc',
			26=>'https://www.chodientu.vn/suc-khoe-tinh-duc',
			27=>'https://www.chodientu.vn/thuc-pham-chuc-nang',
			28=>'https://www.chodientu.vn/cham-soc-mat',
			29=>'https://www.chodientu.vn/nuoc-hoa',
			30=>'https://www.chodientu.vn/cham-soc-toc',
			31=>'https://www.chodientu.vn/cham-soc-than-the',
			32=>'https://www.chodientu.vn/my-pham-cho-nam-gioi',
			33=>'https://www.chodientu.vn/dung-cu-cham-soc-suc-khoe-sac-dep',
			34=>'https://www.chodientu.vn/y-te',
			35=>'https://www.chodientu.vn/trang-diem',
			36=>'https://www.chodientu.vn/lam-dep-suc-khoe',
			37=>'https://www.chodientu.vn/do-choi',
			38=>'https://www.chodientu.vn/be-di-ra-ngoai',
			39=>'https://www.chodientu.vn/san-pham-danh-cho-ba-bau',
			40=>'https://www.chodientu.vn/san-pham-cho-ba-me-sau-sinh',
			41=>'https://www.chodientu.vn/be-an-toan',
			42=>'https://www.chodientu.vn/be-manh-khoe',
			43=>'https://www.chodientu.vn/ve-sinh-cho-be',
			44=>'https://www.chodientu.vn/vat-dung-cho-be',
			45=>'https://www.chodientu.vn/be-ngu',
			46=>'https://www.chodientu.vn/do-choi-cho-be',
			47=>'https://www.chodientu.vn/me-va-be',
			48=>'https://www.chodientu.vn/may-tinh-mang-khac',
			49=>'https://www.chodientu.vn/phan-mem',
			50=>'https://www.chodientu.vn/desktop',
			51=>'https://www.chodientu.vn/linh-phu-kien-may-tinh',
			52=>'https://www.chodientu.vn/tai-nghe',
			53=>'https://www.chodientu.vn/may-anh-so',
			54=>'https://www.chodientu.vn/may-quay-camera',
			55=>'https://www.chodientu.vn/phu-kien-may-anh-may-quay',
			56=>'https://www.chodientu.vn/ong-nhom-kinh-thien-van',
			57=>'https://www.chodientu.vn/may-tinh-xach-tay',
			58=>'https://www.chodientu.vn/may-tinh-may-anh-ky-thuat-so',
			59=>'https://www.chodientu.vn/cay-nuoc-nong-lanh',
			60=>'https://www.chodientu.vn/may-hut-bui',
			61=>'https://www.chodientu.vn/thiet-bi-suoi',
			62=>'https://www.chodientu.vn/tivi',
			63=>'https://www.chodientu.vn/am-thanh-phu-kien',
			64=>'https://www.chodientu.vn/dien-tu-dien-lanh-khac',
			65=>'https://www.chodientu.vn/hinh-anh-phu-kien',
			66=>'https://www.chodientu.vn/bang-dia-cac-loai',
			67=>'https://www.chodientu.vn/yoga-the-hinh-tham-my',
			68=>'https://www.chodientu.vn/the-thao-khac',
			69=>'https://www.chodientu.vn/hoa',
			70=>'https://www.chodientu.vn/nhac-cu',
			71=>'https://www.chodientu.vn/sach-bao-tap-chi',
			72=>'https://www.chodientu.vn/qua-tang',
			73=>'https://www.chodientu.vn/hoat-dong-da-ngoai',
			74=>'https://www.chodientu.vn/the-thao-dong-doi',
			75=>'https://www.chodientu.vn/giay-gang-tay-the-thao',
			76=>'https://www.chodientu.vn/the-thao-van-hoa-pham',
			77=>'https://www.chodientu.vn/banh-keo-mut',
			78=>'https://www.chodientu.vn/do-uong-3149',
			79=>'https://www.chodientu.vn/ngu-coc',
			80=>'https://www.chodientu.vn/san-pham-tu-thit',
			81=>'https://www.chodientu.vn/duong-sua-trung-bo-phomat',
			82=>'https://www.chodientu.vn/thuy-hai-san',
			83=>'https://www.chodientu.vn/rau-qua',
			84=>'https://www.chodientu.vn/gia-vi',
			85=>'https://www.chodientu.vn/do-an-che-bien-san',
			86=>'https://www.chodientu.vn/may-theu',
			87=>'https://www.chodientu.vn/do-my-nghe',
			88=>'https://www.chodientu.vn/do-co-gia-co-do-suu-tam',
			89=>'https://www.chodientu.vn/trang-suc-my-nghe',
			90=>'https://www.chodientu.vn/do-phong-thuy',
			91=>'https://www.chodientu.vn/thu-cong-my-nghe-khac'
			);
		return $danh_sach_danh_muc;
	}
 ?>
