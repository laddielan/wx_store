<?php
    require_once 'lib/db.php';
    
    if(!isset($_COOKIE["9book_openid"])){
        echo '<meta http-equiv="refresh" content="0;url=http://9book.55555.io/book_store/lib/auth_page.php">';
        exit();
    }
    define("OPENID", $_COOKIE["9book_openid"]);
/**
 *
 UI显示模块。
 *
 本页为提交订单页面。
 *
 从cookie里读出提交的书在购物车里的itemid，然后查询数据库将其显示出来
 */


//根据session和$_SERVER['HTTP_REFERER']来判断是不是从购物车页面跳转到本页面，如果不是，就返回首页。
 	session_start();

 	$fromurl = "http://9book.55555.io/book_store/shopcart.php";
	if(!isset($_SERVER['HTTP_REFERER'])|| $_SERVER['HTTP_REFERER'] != $fromurl||!isset($_SESSION["enterOrder"])){
		echo '<meta http-equiv="refresh" content="0;url=http://9book.55555.io/book_store/index.php">';
		exit();
	}
	
	

//从cookie里读出提交的书在购物车里的itemid，然后查询数据库将其显示出来。
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
	<link rel="stylesheet" type="text/css" href="">
	<link rel="stylesheet" type="text/css" href="css/order.css">
	<script type="text/javascript" src="js/zepto.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<section class="adrs-wrap">
<?php 
$sql = "SELECT * FROM address WHERE openid='".OPENID."'";
$adrs = fetchOne($conn, $sql);

if(!empty($adrs)){
	
    $adrs_htm_content = <<<eod
<div class="adrs-exist-wrap">
<div class="adrs-icon-wrap">
		<img src="images/address.png">
</div>
<div class="adrs-info-wrap">
	<p>收货人：<span id="adrs_name">{$adrs["name"]}</span> <span id="adrs_phone" class="adrs-phone">{$adrs["phone"]}</span></p>
	<div class="adrs-content-wrap">
		<span class="adrs-title-wrap">收货地址：<input type="hidden" id="addressid" value={$adrs["addressid"]}></span><br/>
		<p id="adrs_content" class="adrs-content">{$adrs["province"]} {$adrs["city"]}  {$adrs["district"]}  {$adrs["address"]}</p>
	</div>
</div>
<div id="edit_adrs" class="adrs-edit-icon-wrap">
	<img src="images/icon_right.png">
</div>
</div>
    
eod;
		echo $adrs_htm_content;
}
else{
    $html_content = <<<eod
<div class="adrs-null-wrap">
	<a href="address.php">
		<div class="add-adrs-icon-wrap">
			<img src="images/icon_add_adrs.png">
		</div>
		<p class="add-adrs">
			新增收获地址
		</p>
		<div class="add-adrs-edit-wrap">
			<img src="images/icon_right.png">
		</div>
	 </a>
 </div>
eod;
    
    echo $html_content;
}

?>

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
			<p>快递随机发货</p>
			<p>&#65509;<span id="freight">8.00</span></p>			
		</div>
	</div>
	<div class="total-wrap">
		<p>合计</p>
		<p class="total-money">&#65509;<span id="total_money">88.00</span></p>		
	</div>	
</section>

<footer class="submit-wrap">
	<input type="button" class="submit-btn" id="submit_pay" name="" value="提交订单">
	<div class="submit-total-wrap">合计：<span class="submit-total-money">&#65509;<span id="b_total_money">88.00</span></span></div>
</footer>
<section id="adrs_popup" class="address-popup-wrap">
<?php
 $sql = "SELECT * FROM address WHERE openid='".OPENID."'";
 $address_res = fetchAll($conn, $sql);
if(!empty($address_res)){
        echo '<ul class="address-wrap">';
       foreach ($address_res as $adrs_item){
           $address_li = <<<eod
           <li class="adrs-item-wrap"><input type="hidden" value={$adrs_item["addressid"]}><div class="icon-check-wrap"><img class="icon-check" src="images/icon_to_check.png"></div><p class="adrs-content-wrap"><span>{$adrs_item["name"]}</span>，<span>{$adrs_item["phone"]}</span><br><span>{$adrs_item["province"]} {$adrs_item["city"]} {$adrs_item["district"]} {$adrs_item["address"]}</span></p></li>
eod;
			echo $address_li;
       }
        echo '</ul>';
    }
    else{
        echo '<h2>啥都没有</h2>';
    }
?>
</section>
<script type="text/javascript" src="js/order.js?randomId=<%=Math.random()%>"></script>
</body>
</html>