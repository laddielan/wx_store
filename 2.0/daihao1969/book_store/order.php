<?php
    require_once 'lib/db.php';
 	session_start();
 	$fromurl = "http://localhost:88/php_mysql/book_store/shopcart.php";
	if(!isset($_SESSION['openid'])||!isset($_SERVER['HTTP_REFERER'])|| $_SERVER['HTTP_REFERER'] != $fromurl){
		echo '<meta http-equiv="refresh" content="0;url=http://localhost:88/php_mysql/book_store/index.php">';
		exit();
	}
	
	$itemids =explode(',', $_COOKIE['itemidarr']);
	$conn = connect_db();


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
<?php 
$sql = "SELECT * FROM address WHERE openid='".$_SESSION['openid']."'";
$adrs = fetchAll($conn, $sql);


?>
	<div class="adrs-icon-wrap">
		<img src="images/address.png">
	</div>
	<div class="adrs-info-wrap">
		<p class="">收货人：<?php echo $adrs[0]["name"]?> <span class="adrs-phone"><?php echo $adrs[0]["phone"]?></span></p>
		<div class="adrs-content-wrap">
			<span class="adrs-title-wrap">收货地址：<input type="hidden" id="addressid" value=<?php echo $adrs[0]['addressid']; ?>></span>
			<p class="adrs-content"><?php echo $adrs[0]["province"]." ".$adrs[0]["city"]." ".$adrs[0]["district"]." ".$adrs[0]["address"];?></p>
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
	<ul id="books_content">
<?php 
foreach ($itemids as $this_itemid){
    $sql = "SELECT * FROM shopcart WHERE itemid='".$this_itemid."'";
    $shopcart = fetchAll($conn, $sql);
    $sql = "SELECT 现价,作者,书名  FROM books WHERE ID='".$shopcart[0]['bookid']."'";
    $bookinfo = fetchAll($conn, $sql);
    
    $num = substr($shopcart[0]["bookid"], -4);
    $int_num = (int)$num;
    $imgSrc = "images/books/".$int_num.'-'.(1).'.jpg';
    $licontent = <<<eod
    <li class="book-content-wrap">
    		<input type="hidden" value={$this_itemid}>
			<div class="book-img-wrap">
				<img src={$imgSrc}>
			</div>
			<div class="book-name-wrap">
				<p class="book-name">{$bookinfo[0]["书名"]}</p>
				<p class="book-author">{$bookinfo[0]["作者"]}</p>
			</div>
			<div class="book-num-wrap">
				<p>&#65509;<span>{$bookinfo[0]["现价"]}</span></p>
				<p>×<span>{$shopcart[0]["booknum"]}</span></p>
			</div>
		</li>
eod;
	echo $licontent;
    
    
}


?>
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
		<p class="total-money">&#65509;<span id="total_money">88.00</span></p>		
	</div>	
</section>
<section id="pay_block" class="pay-block-wrap">
	<input type="button" class="pay-input" name="pay" value="微信支付">
	<a href="index.php">关闭</a>
	<div id="responsetext"></div>
</section>
<footer class="submit-wrap">
	<input type="button" class="submit-btn" id="submit_pay" name="" value="提交订单">
	<div class="submit-total-wrap">合计：<span class="submit-total-money">&#65509;<span id="b_total_money">88.00</span></span></div>
</footer>
<script type="text/javascript" src="js/order.js?randomId=<%=Math.random()%>"></script>
</body>
</html>