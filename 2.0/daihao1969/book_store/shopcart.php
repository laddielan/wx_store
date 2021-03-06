<?php 
	require_once 'lib/db.php';
	require_once 'lib/wx.php';
	
	if(!isset($_COOKIE["9book_openid"])){
	    echo '<meta http-equiv="refresh" content="0;url=http://9book.55555.io/book_store/lib/auth_page.php">';
	    exit();
	}
	else {
	    $deadtime = time()+60*60*30;
	    setcookie("9book_openid",$_COOKIE["9book_openid"],$deadtime,"/");
	}
	define("OPENID", $_COOKIE["9book_openid"]);
/**
 *
 UI显示模块。
 *
 本页为购物车页面。
 *
 从数据库读出购物车里的内容，然后将其显示出来。
 */   
    session_start();
    $_SESSION['enterOrder'] = true;
    
   

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
			<a href="book.php?ID={$book_item["bookid"]}"><input type="hidden" value="{$book_item["itemid"]}"/><img class="shopcart-img" src={$imgSrc}><p class="item-book-name">{$book_info["书名"]}</p><br><p class="shopcart-price">&#65509;<span>{$book_info["现价"]}</span></p><p class="shopcart-num">×<span>{$book_item["booknum"]}</sapn></p></a>
			<div class="edit-wrap">
				<div class="edit-num-wrap">
					<input type="button" class="page-btn-sub" value="-"><input class="page-text-number" type="text" name="bookNum" value='{$book_item["booknum"]}'><input class="page-btn-add" type="button" name="" value="+">
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
    			<p><span class="shopcart-price">合计：&#65509;<span>0</span></span><br>不含运费</p>
    			<input id="buy" type="button" disabled="disabled" name="buy" value="结算">
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
<script type="text/javascript" src="js/cookie.js?randomId=<%=Math.random()%>"></script>
<script type="text/javascript" src="js/common.js?randomId=<%=Math.random()%>"></script>
<script type="text/javascript" src="js/shopcart.js?randomId=<%=Math.random()%>"></script>
</body>
</html>