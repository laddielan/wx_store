<?php 
	require_once 'lib/db.php';
    
	define("OPENID", "oOEo4wdha12cmoJ2WFSAWBZ2vPpA");

	$conn = connect_db();
	$sql = "SELECT * FROM shopcart WHERE openid='".OPENID."'";
	$sql_res = fetchAll($conn, $sql);
	
	

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
	<title>购物车</title>
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/user.css">
</head>
<body>
<header class="header-wrap">
	<div class="home-content"><a href="index.php"><img class="header-logo" src="images/logo.png"/>9号书店</a></div>	
</header>
<div id="content-wrap">
<?php
if(!empty($sql_res)){

    echo <<<eod
    <form>
    	<section>
    		<ul id="shopcart-content" class="shopcart-wrap">
    			<li class="shopcart-item check-all">
    				<div class="icon-check-wrap"><img class="icon-check" src="images/icon_to_check.png"></div>全选<input id="editBtn" type="button" name="" value="编辑">
    			</li>
eod;
    foreach ($sql_res as $book_item){
        $book_sql = "SELECT 书名,现价   FROM books WHERE books.ID='".$book_item["bookid"]."'";
        $book_info = fetchOne($conn, $book_sql);
        
        $num = substr($book_item["bookid"], -4);
        $int_num = (int)$num;
        $imgSrc = "images/books/".$int_num.'-'.(1).'.jpg';
        echo <<<eod
        <li class="shopcart-item">
			<div class="icon-check-wrap"><img class="icon-check" src="images/icon_to_check.png"></div>
			<a href="book.php?ID={$book_item["bookid"]}"><input type="hidden" value="{$book_item["itemid"]}"/><img class="shopcart-img" src={$imgSrc}><p class="item-book-name">{$book_info["书名"]}</p><br><p class="shopcart-price">&#65509;{$book_info["现价"]}</p><p class="shopcart-num">×<span>{$book_item["booknum"]}</sapn></p></a>
			<div class="edit-wrap">
				<div class="edit-num-wrap">
					<input type="button" class="page-btn-sub" value="-"><input  onpropertychange="replaceNotNumber(this)" class="page-text-number" type="text" name="bookNum" value='{$book_item["booknum"]}'><input class="page-btn-add" type="button" name="" value="+">
					<div class="shopcart-price">&#65509;{$book_info["现价"]}</div>
				</div>
				<div class="edit-delete-wrap"><input type="button" class="edit-delete-btn" value="删除" name="edit-delete"></div>
			</div>
		</li>
eod;
    }

    echo <<<eod
    </ul>
    	</section>
    	<footer class="shopcart-footer">
    		<div>
    			<p><span class="shopcart-price">合计：&#65509;0</span><br>不含运费</p>
    			<input type="submit" name="buy" value="结算">
    		</div>
    	</footer>
    </form>
eod;
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
</div>

<script type="text/javascript" src="js/user.js"></script>
</body>
</html>