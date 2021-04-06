<?php
require_once "../../autoload/Autoload.php";

if (!Auth::user()) {
    Redirect::url('admin/account/login.php');
}

$currentMonth = date('m');
$currentYear = date('Y');

$sql = "SELECT count(id) as khachhangmoi from khachhang where YEAR(created_at) = $currentYear and MONTH(created_AT) = $currentMonth";
$newCustomer = $DB->query($sql);

$sql = "SELECT count(id) as donhangmoi from donhang where YEAR(created_at) = $currentYear and MONTH(created_AT) = $currentMonth ";
$newOrder = $DB->query($sql);

$sql = "SELECT count(id) as donhangcho from donhang where YEAR(created_at) = $currentYear and MONTH(created_AT) = $currentMonth and donhang.trangthai = 0";
$orderPending = $DB->query($sql);

$sql = "SELECT count(id) as donhangdaxuly from donhang where YEAR(created_at) = $currentYear and MONTH(created_AT) = $currentMonth and donhang.trangthai = 1";
$orderSuccess = $DB->query($sql);

$sql = "SELECT count(id) as sanphammoi from sanpham where YEAR(created_at) = $currentYear and MONTH(created_AT) = $currentMonth ";
$newProduct = $DB->query($sql);

$sql = "SELECT count(id) as baivietmoi from sanpham where YEAR(created_at) = $currentYear and MONTH(created_AT) = $currentMonth ";
$newPost = $DB->query($sql);

$title = "Dashboard";
require_once "../../layouts/admin/header.php";

?>

<div class="page-content-wrapper-inner">
	<div class="content-viewport">
		<div class="row">
			<div class="col-12 py-5">
				<h4>Dashboard</h4>
				<p class="text-gray mt-3">
					Xin chào ,
					<?php print_r(Auth::user()->name) ?>
				</p>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-3 col-sm-6 col-6 equel-grid">
				<div class="grid">
					<div class="grid-body text-gray">
						<div class="d-flex justify-content-between">
							<span><?= $newCustomer[0]->khachhangmoi ?></span>
						</div>
						<p class="text-black">Khách hàng mới</p>
						<div class="wrapper w-50 mt-4">
							<canvas height="45" id="stat-line_1"></canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-6 equel-grid">
				<div class="grid">
					<div class="grid-body text-gray">
						<div class="d-flex justify-content-between">
							<p><?= $newOrder[0]->donhangmoi ?></p>
							<?php if ($newOrder[0]->donhangmoi != 0) :?>
								<p>
									<?= $orderPending[0]->donhangcho / $newOrder[0]->donhangmoi * 100; ?> % đang chờ
								</p>
								<p>
									<?= $orderSuccess[0]->donhangdaxuly / $newOrder[0]->donhangmoi * 100 ?> % đã xử lý
								</p>
							<?php endif?>
						</div>
						<p class="text-black">Đơn hàng mới</p>
						<div class="wrapper w-50 mt-4">
							<canvas height="45" id="stat-line_2"></canvas>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-6 equel-grid">
				<div class="grid">
					<div class="grid-body text-gray">
						<div class="d-flex justify-content-between">
							<p><?= $newProduct[0]->sanphammoi ?></p>
						</div>
						<p class="text-black">Sản phẩm mới</p>
						<div class="wrapper w-50 mt-4">
							<canvas height="45" id="stat-line_3"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 col-6 equel-grid">
				<div class="grid">
					<div class="grid-body text-gray">
						<div class="d-flex justify-content-between">
							<p><?= $newPost[0]->baivietmoi ?></p>
						</div>
						<p class="text-black">Bài viết mới</p>
						<div class="wrapper w-50 mt-4">
							<canvas height="45" id="stat-line_4"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
    require_once '../../layouts/admin/footer.php';
?>
