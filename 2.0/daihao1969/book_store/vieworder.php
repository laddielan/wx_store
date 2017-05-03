<?php 
require_once 'lib/db.php';
if (!isset($_GET["action"])){
    echo '<meta http-equiv="refresh" content="0;url=http://localhost:88/php_mysql/book_store/index.php">';
    exit();
}
define("OPENID", "oOEo4wdha12cmoJ2WFSAWBZ2vPpA");

global $order_res;
switch($_GET["action"]){
    case "topay":
        $order_res = selectOrder(0);
        break;
    case "tosend":
        $order_res = selectOrder(1);
        break;
    case "sent":
        $order_res = selectOrder(2);
        break;
    case "done":
        $order_res = selectOrder(3);
        break;
    case "allOrder":
        for($i=0;$i<4;$i++){
            $temp = selectOrder($i);
            if(!empty($temp)&&!empty($order_res)){
                $order_res = array_merge($order_res,$temp);
            }
            else if(!empty($temp)&&empty($order_res)){
                $order_res = $temp;
            }
        }
        break;
     default:
         echo '<meta http-equiv="refresh" content="0;url=http://localhost:88/php_mysql/book_store/index.php">';
         exit();
}

function selectOrder($state_num){
    if(0==$state_num){
        $conn = connect_db();
        $sql = "SELECT orderid,amount FROM orders WHERE openid='".OPENID."' and state=0";
        $order_res = fetchAll($conn, $sql);
        
        for($i=0;$i<count($order_res);$i++){
            $sql = "SELECT bookid,booknum FROM order_content WHERE orderid='".$order_res[$i]["orderid"]."'";
            $num = getResultNum($conn, $sql);
            $order_res[$i]["itemnum"] = $num;
            $one_book = fetchOne($conn, $sql);
            $num = substr($one_book["bookid"], -4);
            $int_num = (int)$num;
            $imgSrc = "images/books/".$int_num.'-'.(1).'.jpg';
            $sql = "SELECT 书名,现价  FROM books WHERE ID='".$one_book["bookid"]."'";
            $one_book_info = fetchOne($conn, $sql);
            $order_res[$i]["bookname"] = $one_book_info["书名"];
            $order_res[$i]["bookprice"] = $one_book_info["现价"];
            $order_res[$i]["booknum"] = $one_book["booknum"];
            $order_res[$i]["imgsrc"] = $imgSrc;
            $order_res[$i]["stateinfo"]="等待买家付款";
        }
        return $order_res;
    }
    else{
        return null;
    }
}

function topay(){
    $conn = connect_db();
    $sql = "SELECT orderid,amount FROM orders WHERE openid='".OPENID."' and state=0";
    $order_res = fetchAll($conn, $sql);
    
    for($i=0;$i<count($order_res);$i++){
        $sql = "SELECT bookid,booknum FROM order_content WHERE orderid='".$order_res[$i]["orderid"]."'";
        $num = getResultNum($conn, $sql);
        $order_res[$i]["itemnum"] = $num;
        $one_book = fetchOne($conn, $sql);
        $num = substr($one_book["bookid"], -4);
        $int_num = (int)$num;
        $imgSrc = "images/books/".$int_num.'-'.(1).'.jpg';
        $sql = "SELECT 书名,现价  FROM books WHERE ID='".$one_book["bookid"]."'";
        $one_book_info = fetchOne($conn, $sql);
        $order_res[$i]["bookname"] = $one_book_info["书名"];
        $order_res[$i]["bookprice"] = $one_book_info["现价"];
        $order_res[$i]["booknum"] = $one_book["booknum"];
        $order_res[$i]["imgsrc"] = $imgSrc; 
        
    }
    return $order_res;
}
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
	<link rel="stylesheet" type="text/css" href="css/vieworder.css">
	<script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<?php 
if(!empty($order_res)){
    foreach($order_res as $order_item){
        $html_content = <<<eod
<section class="order-wrap">
	<div class="head-wrap">
		<div class="head-info-wrap">
			<h3>店铺：9号书店</h3>
			<p class="head-order-number">订单编号：<span>{$order_item["orderid"]}</span></p>
		</div>
		<p class="head-order-state">{$order_item["stateinfo"]}</p>
	</div>
	<div class="content-wrap">
		<div class="content-content">
			<div class="content-img-wrap">
				<img src={$order_item["imgsrc"]}>
			</div>
			<div class="content-info-wrap">
				<p class="content-book-name">{$order_item["bookname"]}</p>
				<div class="content-book-price">&#65509;{$order_item['amount']}</div>
			</div>
		</div>
		<div class="content-view-all">
			<a class="view-all" href="orderstate.php?orderid={$order_item["orderid"]}">查看全部{$order_item['itemnum']}件商品</a>
		</div>
	</div>
	<div class="amount-wrap">
		<p class="amount-content">合计：<span class="orange-color">&#65509;{$order_item['amount']}</span></p>
	</div>
	<div class="btn-wrap">
		<a class="pay-btn" href="orderstate.php?orderid={$order_item["orderid"]}">付款</a>
		<div class="cancle-btn">取消</div>
	</div>
</section>
eod;
		echo $html_content;
    } 
    echo "<p class='at-end'>没有更多订单了╮(╯▽╰)╭</p>";
}
else{
    echo <<<eod
<div class="empty-cart-wrap">
    <p>空空如也</p>
    <a href="index.php">去逛逛</a>
</div>
eod;
}

?>

<footer>	
</footer>
<script type="text/javascript" src="js/vieworder.js"></script>
</body>
</html>