<?php 
require_once 'lib/db.php';

	//$db_server = mysqli_connect(SAE_MYSQL_HOST_M,SAE_MYSQL_USER,SAE_MYSQL_PASS,SAE_MYSQL_DB,SAE_MYSQL_PORT);
	$db_server = connect_db();
	
//选择数据库及 查询数据库	
    $book_ID = $_REQUEST["ID"];
    $query = "SELECT * FROM books WHERE ID='$book_ID'";
    $result = $db_server->query($query);
    
    if(!$result) die("Database access failed: ".mysqli_connect_error($result));
    
  //  $rows = mysql_num_rows($result);
    $j = 0;
    while(($row = $result->fetch_assoc())!=false){	
		$books[$j] = new Book($row['ID'],$row['书名'],$row['作者'],$row['备注'],$row['原价'],$row['现价'],$row['出版社'],$row['语种'],$row['页数'],$row['开本'],$row['ISBN'],$row['条形码'],$row['商品尺寸'],$row['商品重量'],$row['品牌'],$row['编辑推荐'],$row['媒体推荐'],$row['作者简介'],$row['图片数量']);
		$j++;
    }
	
    
	


class Book{
	public $ID,$name,$author,$oPrice,$nPrice,$remark,$press,$language,$page,$format,$ISBN,$barCode,$size,$weight,$brand,$copyReader,$mediaReader,$authorInfo,$imgNum;
	function Book($id,$na,$au,$re,$op,$np,$pr,$la,$pa,$fo,$IS,$ba,$si,$we,$br,$co,$me,$auInfo,$im){

		$this->author = $au;
		$this->authorInfo = $auInfo;
		$this->barCode = $ba;
		$this->brand = $br;
		$this->copyReader = $co;
		$this->format = $fo;
		$this->ID = $id;
		$this->ISBN = $IS;
		$this->language = $la;
		$this->mediaReader = $me;
		$this->name = $na;
		$this->nPrice = $np;
		$this->oPrice = $op;
		$this->page = $pa;
		$this->press = $pr;
		$this->remark = $re;
		$this->size = $si;
		$this->weight = $we;
		$this->imgNum = $im;
	}
	
}

//净化用户输入
function sanitizeString($var)
{
	if(get_magic_quotes_gpc())
		$var = stripcslashes($var);
	$var = htmlentities($var);
	$var = strip_tags($var);

	return $var;
}


//数据库保护
function sanitizeMySQL($var)
{
	$var = mysqli_real_escape_string($var);
	$var = sanitizeString($var);
	return $var;
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
	<title>图书详情</title>
	<link rel="stylesheet" type="text/css" href="css/bookv2.css">
</head>
<body>

<header class="header-wrap">
	<div class="home-content"><a href="index.php"><img class="header-logo" src="images/logo.png"/>9号书店</a></div>
	
</header>

<section>
	<header class="book-name-wrap">
		<p class="book-name"><?php echo $books[0]->name;?></p>
		<p class="book-author">作者：<?php echo $books[0]->author;?></p>
	</header>
	<div class="slide-wrap">
		<ul id="slideEles">
		<?php 
		  for($i=0;$i<$books[0]->imgNum;$i++){
		      $num = substr($books[0]->ID, -4);		    
		      $int_num = (int)$num;              
		      $imgSrc = "images/books/".$int_num.'-'.($i+1).'.jpg';
		  
		      if($i==0){
		          echo "<li class='slide-show' style='display: block;'><img src=".$imgSrc."></li>";
		      }
			 else{
			     echo "<li class='slide-show' style='display: none;'><img src=".$imgSrc."></li>";
			 }
			 
		  }
			?>
		</ul>
		<ul class="slide-flag-wrap" id="slideFlags">
		<?php 
		for($i=0;$i<$books[0]->imgNum;$i++){
		  if($i==0){
			echo "<li class='slide-flag1'></li>";
		  }
		  else {
		      echo "<li class='slide-flag2'></li>";
		  }
		
		}?>
		</ul>
	</div>
</section>
<section class="book-info-wrap">
	<div>
		<p class="book-price">定价：&#65509;<?php echo $books[0]->oPrice;?><br>售价：<span>&#65509;<?php echo $books[0]->nPrice;?></span><br>满68免费配送</p>
	</div>
	<div class="book-intro-wrap" id="book_intro">
		
			<?php if($books[0]->copyReader!=null){
			    
			         echo "<h2>编辑推荐</h2><div><p>".$books[0]->copyReader."</></div>";
			     }
			     if($books[0]->mediaReader!=null){
			         echo "<h2>媒体推荐</h2><div><p>".$books[0]->mediaReader."</></div>";
			     }
			     
			     if($books[0]->authorInfo!=null) {
			         echo "<h2>作者简介</h2><div><p>".$books[0]->authorInfo."</></div>";
			     }
			     
			?>	
	</div>
	<div class="base-info" id="base_info">
		<h2>基本信息</h2>
		<ul>
			<li><b>出版社：</b><?php echo $books[0]->press;?></li>
			<li><b>平装： </b><?php echo $books[0]->page;?></li>
			<li><b>语种：</b><?php echo $books[0]->language;?></li>
			<li><b>开本：</b><?php echo $books[0]->format;?></li>
			<li><b>ISBN: </b><?php echo $books[0]->ISBN;?></li>
			<li><b>条形码：</b> <?php echo $books[0]->barCode;?></li>
			<li><b>商品尺寸：</b><?php echo $books[0]->size;?></li>
			<li><b>商品重量：</b><?php echo $books[0]->weight;?></li>
			<?php 			
			 if($books[0]->brand!=null){
			     echo "<li><b>品牌：</b>".$books[0]->brand."</li>";
			 }
			
			?>
		</ul>
	</div>
</section>
<section>
	<div id="search" class="search-wrap">
	<input type="search" name="search_book" class="book-input" placeholder="搜索作者/书名">
	<input type="submit" name="search_book_submit" class="book-submit" value="搜索">
	</div>
	<div class="menu-wrap" id="all-menu">
		<ul class="menu-content">
			<li><a>小说<img src="images/icon_right.png"></a></li>
			<li><a>文学<img src="images/icon_right.png"></a></li>
			<li><a>艺术与摄影<img src="images/icon_right.png"></a></li>
			<li><a>传记<img src="images/icon_right.png"></a></li>
			<li><a>经济管理<img src="images/icon_right.png"></a></li>
			<li><a>少儿<img src="images/icon_right.png"></a></li>
			<li><a>计算机与互联网<img src="images/icon_right.png"></a></li>
			<li><a>社会科学<img src="images/icon_right.png"></a></li>
			<li><a>教材教辅与参考书<img src="images/icon_right.png"></a></li>
			<li><a>动漫与绘本<img src="images/icon_right.png"></a></li>
			<li><a>心理学<img src="images/icon_right.png"></a></li>
			<li><a>历史<img src="images/icon_right.png"></a></li>
			<li><a>医学<img src="images/icon_right.png"></a></li>
			<li><a>进口原版<img src="images/icon_right.png"></a></li>
		</ul>
	</div>
</section>
<footer>
	<div class="back-home-wrap" ><a class="back-home" href="index.php">回到首页> </a></div>
	<ul class="about-us">
		<li><a href="">店铺信息</a></li>
		<li><a href="">关于开发者</a></li>
		<li><a href="">我有Bug</a></li>
	</ul>
	<div class="bottom"><img src="images/end.png"></div>
</footer>
<section class="fixed-menu">
	<div class="fixed-kefu">客服</div>
	<div class="fixed-shopcart">购物车</div>
	<div id="fixed_add_shopcart" class="fixed-add-shopcart">加入购物车</div>
	<div id="fixed_add_now" class="fixed-add-now">立即购买</div>
</section>
<section id="page_add_shopcart" class="page-add-shopcart-wrap">
	<div class="page-add-shopcart-content">
	<form method="get" action="lib/operate_db.php?action=addShopcart">
		<div class="page-add-shopcart-info">
			<div class="page-add-shopcart-title"><img class="past-book" src="images/book_002_1.jpg">
			<img class="close-icon" id="page_close_btn" src="images/icon_close.png">
				<p><?php echo $books[0]->name;?></p>
				<p>
					<span>&#65509;<?php echo $books[0]->nPrice;?></span><br>
					定价：<del>&#65509;<?php echo $books[0]->oPrice;?></del>
				</p>			
			</div>		
    		<div class="page-add-shopcart-option">
    			<p >规格：</p><p id="page_guige"><?php echo "<input type='hidden' id='bookId' name='bookId' value='".$books[0]->ID."'/>" ?><input type="button" class="selected-option" name="" value="平装"> <input type="button" class="un-selected-option" name="" value="套装"></p>
    		</div>
    		<div class="page-add-shopcart-number">
    			购买数量：<input type="button" class="page-btn-sub"  id="page_num_btn_sub" value="-"><input id="page_text_num" class="page-text-number" type="text" name="bookNum" value="1"><input id="page_num_btn_add" class="page-btn-add" type="button" name="" value="+"><br><span>剩余3件</span>
    		</div>
    	</div>
		<div class="page-next-act" id="page-next-act-btn-add">
			<input id="addCart" class="page-next-act-btn" type="button" name="addCart" value="加入购物车">
		</div>
		<div class="page-next-act" id="page-next-act-btn-add-now">
			<input id="buyCart" class="page-next-act-btn" type="button" name="buyCart" value="下一步">
		</div>
	</form>
	</div>
	
</section>
<script type="text/javascript" src="js/book.js"></script>
</body>
</html>