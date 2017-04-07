<?php
 	session_start();
 	$fromurl = "http://localhost:88/php_mysql/book_store/shopcart.php";
	if(!isset($_SESSION['openid'])||!isset($_SERVER['HTTP_REFERER'])|| $_SERVER['HTTP_REFERER'] != $fromurl){
		echo '<meta http-equiv="refresh" content="0;url=http://localhost:88/php_mysql/book_store/index.php">';
		exit();
	}
	
	$itemids =explode(',', $_COOKIE['itemidarr']);
	print_r($itemids);
	

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
	<meta name="format-detection" content="telephone=no" />
	<meta name="apple-mobile-web-app-capable" content="yes" />   
	<meta name="apple-mobile-web-app-status-bar-style" content="black">    
	<meta name="author" content="daihao1969" /> 
	<title>待付款的订单</title>
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/order.css">
	<script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<section class="adrs-wrap">
	<div class="adrs-icon-wrap">
		<img src="images/address.png">
	</div>
	<div class="adrs-info-wrap">
		<p class="">收货人：兰志丹 <span class="adrs-phone">18202751223</span></p>
		<div class="adrs-content-wrap">
			<span class="adrs-title-wrap">收货地址：</span>
			<p class="adrs-content">湖北省武汉市洪山区华中科技大学韵苑5栋湖北省武汉市洪山区华中科技大学韵苑5栋</p>
		</div>
	</div>
	<div class="adrs-edit-icon-wrap">
		<img src="images/icon_right.png">
	</div>
	<div class="adrs-line-wrap">
	</div>
</section>
<section class="book-wrap">
	<h3 class="book-store-name">9号书店</h3>
	<ul>
		<li class="book-content-wrap">
			<div class="book-img-wrap">
				<img src="images/books/1-1.jpg">
			</div>
			<div class="book-name-wrap">
				<p class="book-name">解忧杂货店</p>
				<p class="book-author">东野圭吾</p>
			</div>
			<div class="book-num-wrap">
				<p>&#65509;39.50</p>
				<p>×1</p>
			</div>
		</li>
		<li class="book-content-wrap">
			<div class="book-img-wrap">
				<img src="images/books/1-1.jpg">
			</div>
			<div class="book-name-wrap">
				<p class="book-name">解忧杂货店</p>
				<p class="book-author">东野圭吾</p>
			</div>
			<div class="book-num-wrap">
				<p>&#65509;39.50</p>
				<p>×1</p>
			</div>
		</li>
	</ul>
	<div class="express-wrap">
		<p class="express-title">配送方式</p>
		<div class="express-content">
			<p>韵达快递</p>
			<p>&#65509;8.00</p>			
		</div>
	</div>
	<div class="total-wrap">
		<p>合计</p>
		<p class="total-money">&#65509;88.00</p>
		
	</div>
</section>
<footer class="submit-wrap">
	<div class="submit-btn">提交订单</div>
	<div class="submit-total-wrap">合计：<span class="submit-total-money">&#65509;88.00</span></div>
</footer>
<script type="text/javascript" src="js/order.js"></script>
</body>
</html>