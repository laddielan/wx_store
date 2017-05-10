<?php 
    require_once 'lib/db.php';
/**
 *
 UI显示模块。
 *
 本页为订单状态页面。
 *
 根据提交的订单id(orderid)，将数据库中的数据读取出来显示在页面中。
 */

    if(isset($_GET["orderid"])){
        $orderid = $_GET["orderid"];
    }
    else {
        echo '<meta http-equiv="refresh" content="0;url=http://9book.55555.io/book_store/index.php">';
        exit();
    }
    session_start();
    if(isset($_SESSION["enterOrder"])){
        unset($_SESSION["enterOrder"]);
    }
   $conn = connect_db();
   $sql = "SELECT addressid,state,createtime,amount,freight,express FROM orders WHERE orderid= '".$orderid."'";
   $order_info = fetchOne($conn, $sql);
   date_default_timezone_set('PRC');
   $deadline = date('Y-m-d H:i:s', ($order_info["createtime"]+86400));
   switch($order_info["state"]){
       case 0:
           $title = "待付款的订单";
           $state_icon_img = "images/wait_to_pay.png";
           $state_p = "等待买家付款";
           $state_info = "请于".$deadline."前付款，超时订单将自动关闭.";
           break;       
   }
   
   $sql = "SELECT phone,name,province,city,district,address FROM address WHERE addressid=".$order_info["addressid"];
   $address_info = fetchOne($conn, $sql);
   

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
	<title><?php echo $title;?></title>
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/order.css">
	<script type="text/javascript" src="js/cssrefresh.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
</head>
<body class="hidden">
<section class="order-state-wrap">
	<div class="state-wrap">
		<div class="state-icon-wrap"><img src=<?php echo $state_icon_img;?>></div>
		<div class="state-info-wrap">
			<p><?php echo $state_p;?></p>
			<p class="state-info-small"><?php echo $state_info;?></p>
		</div>
	</div>
</section>
<section class="adrs-wrap">
	<div class="adrs-icon-wrap">
		<img src="images/address.png">
	</div>
	<div class="adrs-info-wrap">
		<p class="">收货人：<?php echo $address_info["name"];?> <span class="adrs-phone"><?php echo $address_info["phone"];?></span></p>
		<div class="adrs-content-wrap">
			<span class="adrs-title-wrap">收货地址：</span>
			<p class="adrs-content"><?php echo $address_info["province"].$address_info["city"].$address_info["district"].$address_info["address"];?></p>
		</div>
	</div>
	<div class="adrs-line-wrap">
	</div>
</section>
<section class="book-wrap">
	<h3 class="book-store-name">9号书店</h3>
	<ul>
<?php 
$sql = "SELECT booknum,bookid FROM order_content WHERE orderid= '".$orderid."'";
$books_res = fetchAll($conn, $sql);
foreach ($books_res as $book_item){
    $sql = "SELECT 书名,作者,现价 FROM books WHERE ID='".$book_item["bookid"]."'";
    $book_info = fetchAll($conn, $sql);
    $num = substr($book_item["bookid"], -4);
    $int_num = (int)$num;
    $imgSrc = "images/books/".$int_num.'-'.(1).'.jpg';

    $li_content = <<<eod
<li class="book-content-wrap">
	<div class="book-img-wrap">
		<img src={$imgSrc}>
	</div>
	<div class="book-name-wrap">
		<p class="book-name">{$book_info[0]["书名"]}</p>
		<p class="book-author">{$book_info[0]["作者"]}</p>
	</div>
	<div class="book-num-wrap">
		<p>&#65509;{$book_info[0]["现价"]}</p>
		<p>×{$book_item["booknum"]}</p>
	</div>
</li>
eod;
		    echo $li_content;
		}
?>
	</ul>
	<div class="express-wrap">
		<p class="express-title">配送方式</p>
		<div class="express-content">
			<p><?php echo $order_info["express"];?></p>
			<p>&#65509;<?php echo $order_info["freight"];?></p>			
		</div>
	</div>
	<div class="total-wrap">
		<p>合计</p>
		<p class="total-money">&#65509;<?php echo $order_info["amount"];?></p>
		
	</div>
</section>
<section id="pay_block" class="pay-block-wrap">
	<div id="we_pay" class="pay-btn-wrap">
		<!--<a href="#" id="we_pay" class="weui-btn weui-btn_primary" class="pay-btn">微信支付</a>-->
		<img class="wx_pay_img" src="images/wx_pay.png" />
	</div>	
</section>
<footer class="submit-wrap">
	<div class="submit-btn" id="to_pay">去付款</div>
	<div class="submit-total-wrap">合计：<span class="submit-total-money">&#65509;<?php echo round($order_info["amount"],2);?></span></div>
</footer>
<script type="text/javascript" src="js/orderstate.js"></script>
</body>
</html>