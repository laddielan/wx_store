<?php

	//$db_server = mysqli_connect(SAE_MYSQL_HOST_M,SAE_MYSQL_USER,SAE_MYSQL_PASS,SAE_MYSQL_DB,SAE_MYSQL_PORT);
	$db_server = mysqli_connect('LOCALHOST','root','laddie','info_of_user');

	if(!$db_server){
		die("Unable to connect to MySQL: ".mysqli_connect_error());
	}
		
	mysqli_set_charset($db_server, 'utf8');  

//选择数据库及 查询数据库	
    $query = "SELECT * FROM books";
    $result = $db_server->query($query);
    
    if(!$result) die("Database access failed: ".mysqli_error());
    
  //  $rows = mysql_num_rows($result);
    $book_num = 0;
    while(($row = $result->fetch_assoc())!=false){	
		$books[$book_num] = new Book($row['ID'],$row['书名'],$row['作者'],$row['原价']);
	//	$books[$j]->print_info();	
		$book_num++;
    }
	
	


class Book{
	public $ID,$name,$author,$oPrice;
	function Book($id,$n,$r="",$op){
		$this->ID = $id;
		$this->name = $n;
		$this->author = $r;
		$this->oPrice = $op;
	}
	public function print_info(){
		echo "ID:".$this->ID."<br/>"."书名：".$this->name."<br/>"."介绍：".$this->author."<br/>";
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
	<title>9号书店</title>
	<link rel="stylesheet" type="text/css" href="css/weui.css">
	<link rel="stylesheet" type="text/css" href="css/indexv9.css">
	
</head>
<body>
<section>
<header class="header-wrap" id="top">
	<div class="home-content"><a href=""><img class="header-logo" src="images/logo.png"/>9号书店</a></div>
	<div class="shopcart-content"><a href=""><img class="header-logo" src="images/shopcart0.png"></a></div>
</header>
<div class="search-wrap">
	<form>
		<input type="search" class="book-search" name="search_book" placeholder="搜索书名/作者"><input class="search-submit-btn" type="submit" value="搜索" name="search_book_submit">
	</form>
</div>
<div class="slide-wrap">
	<ul id="slideEles">
		<li class="slide-show" style="display: block;" ><a href=""><img src="images/bar_001.jpg"></a></li>
		<li class="slide-show"><a href=""><img src="images/bar_002.jpg"></a></li>
		<li class="slide-show"><a href=""><img src="images/bar_003.jpg"></a></li>
		<li class="slide-show"><a href=""><img src="images/bar_004.jpg"></a></li>
	</ul>
	<ul class="slide-flag-wrap" id="slideFlags">
		<li class="slide-flag1"></li>
		<li class="slide-flag2"></li>
		<li class="slide-flag3"></li>
		<li class="slide-flag4"></li>
	</ul>	
</div>	
</section>
<section>
	<nav class="nav-wrap">
		<ul>
			<li class="nav-content"><a href="#cxb"><img src="images/icon_sale.png" /><div>畅销榜</div></a></li>
		
			<li class="nav-content"><a href="#xssj"><img src="images/icon_new.png" /><div>新书上架</div></a></li>
		
			<li class="nav-content"><a href="#jrtj"><img src="images/icon_today.png" /><div>今日特价</div></a></li>
		
			<li class="nav-content"><a href="#"><img src="images/icon_rent.png" /><div>图书漂流</div></a></li>
		</ul>
			
	</nav>
</section>

<section>
	<div class="tuijian-wrap">
    	<header>
    		<img class="tuijian-wrap-header-img" src="images/line.png"><h2>为您推荐</h2><img class="tuijian-wrap-header-img" src="images/line.png">
    	</header>	
		
    	<ul id="tuijian_ul"><?php 
    	$book_num = count($books,0);
    	       for($i=0;$i<$book_num;$i++){
    	           $imgSrc = "images/books/".($i+1)."-1.jpg";
    	?>
    		<li class="book-content">
    		<a href="book.php?ID=<?php echo $books[$i]->ID;?>">	<img class="book-img" src="<?php echo $imgSrc;?>" >
    			<div class="book-name"><?php echo $books[$i]->name; ?></div>
    			<div class="book-price">&#65509;<?php echo $books[$i]->oPrice;?></div> 
    		</a>		
    		</li>
    	<?php 
    	       }
    	?>
    	</ul>
	
	</div>
</section>
<section>
	<div class="hot-class-wrap">
		<header>
			<img src="images/line.png"><h2>热门分类</h2><img src="images/line.png">
		</header>
		<div class="hot-class-content">
			<ul>
				<li class="hot-class"><a><img src="images/c_xiaoshuo.jpg"><p class="class-name">小说</p></a></li>
				<li class="hot-class"><a><img src="images/c_jisuan.jpg"><p class="class-name">计算机科学</p></a></li>
				<li class="hot-class"><a><img src="images/c_jingji.jpg"><p class="class-name">经济管理</p></a></li>
				<li class="hot-class"><a><img src="images/c_wenxue.jpg"><p class="class-name">文学</p></a></li>
				<li class="hot-class"><a><img src="images/c_shaoer.jpg"><p class="class-name">少儿</p></a></li>
				<li class="hot-class"><a><img src="images/c_jinkou.jpg"><p class="class-name">进口原版</p></a></li>
				<li class="hot-class"><a><img src="images/c_lishi.jpg"><p class="class-name">历史</p></a></li>
				<li class="hot-class"><a><img src="images/c_yishu.jpg"><p class="class-name">艺术</p></a></li>
				<li class="hot-class"><a><img src="images/c_zhuanji.jpg"><p class="class-name">传记</p></a></li>
				<li class="hot-class"><a href="#all-menu"><img src="images/c_gengduo.png"><p class="class-name">更多分类</p></a></li>
			</ul>
		</div>
	</div>
</section>
<section>
	<div class="zhanshi-wrap">
		<header id="cxb"><h2 class="cx">| 畅销榜 |</h2></header>
		<div>
			<ul>
				<li class="zhanshi-content"><img src="images/c_001.jpg"><span class="cx sp">1</span><p class="zhanshi-name"><span class="cx">直到那一天： </span>当普通人以爱的名义陷入疯狂，你该如何区分善恶的边界？</p><p>&#65509;26.80</p></li>
				<li class="zhanshi-content"><img src="images/c_002.jpg"><span class="cx sp">2</span><p class="zhanshi-name"><span  class="cx">未来简史：</span>进入21世纪后，曾经长期威胁人类生存、发展的瘟疫、饥荒和战争已经被攻克，智人面临着新的待办议题：永生不老、幸福快乐和成为具有“神性”的人类。</p><p>&#65509;26.80</p></li>
				<li class="zhanshi-content"><img src="images/c_003.jpg"><span class="cx sp">3</span><p class="zhanshi-name"><span  class="cx">人类简史：</span>从十万年前有生命迹象开始到21世纪资本、科技交织的人类发展史。</p><p>&#65509;26.80</p></li>
			</ul>
		</div>
	</div>
	<div class="zhanshi-wrap">
		<header id="xssj"><h2 class="xs">| 新书上架 |</h2></header>
		<div>
			<ul>
				<li class="zhanshi-content"><img src="images/x_001.jpg"><p class="zhanshi-name"><span class="xs">BBC世界史： </span>我们对世界历史的理解总是在不断改变，因为世界各地时时刻刻都有新的发现，并向我们的旧有偏见发起挑战。</p><p class="xs zhanshi-author">作者：安德鲁·玛尔</p><p>&#65509;26.80</p></li>
				<li class="zhanshi-content"><img src="images/x_002.jpg"><p class="zhanshi-name"><span class="xs">白先勇细说红楼梦(套装共2册) ：</span>“红楼梦是我的文学圣经，我写作的百科全书。”</p><p class="xs">作者：白先勇</p><p>&#65509;124.32</p></li>
				<li class="zhanshi-content"><img src="images/x_003.jpg"><p class="zhanshi-name"><span class="xs zhanshi-author">时间的女儿：</span>从十万年前有生命迹象开始到21世纪资本、科技交织的人类发展史。十万年前，地球上至少有六个人种，为何今天却只剩下了我们自己？</p><p class="xs">作者：八月长安</p><p>&#65509;31.05</p></li>
				<li class="zhanshi-content"><img src="images/x_004.jpg"><p class="zhanshi-name"><span class="xs zhanshi-author">时光列车：</span>“我要把所有的事情都记住，为一件外套写一首咏叹调，为一家咖啡店谱一部安魂曲。”</p><p class="xs zhanshi-author">作者：帕蒂•史密斯</p><p>&#65509;26.80</p></li>
			</ul>
		</div>
	</div>
	<div class="zhanshi-wrap">
		<header id="jrtj"><h2 class="jr">| 今日特价 |</h2></header>
		<div>
			<ul>
				<li class="zhanshi-content"><img src="images/j_001.jpg"><p class="zhanshi-name">1984(经典权威译本)(附英文版)(套装共2册)</p><p>原价：<s>&#65509;49.00</s> 现价：<span class="jr">&#65509;30.00</span></p></li>
				<li class="zhanshi-content"><img src="images/j_002.jpg"><p class="zhanshi-name">中国幽默儿童文学创作·任溶溶系列:没头脑和不高兴(注音版)(套装共5册)</p><p>原价：<s>&#65509;54.00</s> 现价：<span class="jr">&#65509;39.80</span></p></li>
				<li class="zhanshi-content"><img src="images/j_003.jpg"><p class="zhanshi-name">精神分析引论(德语未删节译本)</p><p>原价：<s>&#65509;38.00</s> 现价：<span class="jr">&#65509;29.30</span></p></li>
				<li class="zhanshi-content"><img src="images/j_004.jpg"><p class="zhanshi-name">穆斯林的葬礼(2015版)</p><p>原价：<s>&#65509;65.30</s> 现价：<span class="jr">&#65509;37.20</span></p></li>
				<li class="zhanshi-content"><img src="images/j_005.jpg"><p class="zhanshi-name">营销管理（第15版·彩色版）</p><p>原价：<s>&#65509;165.30</s> 现价：<span class="jr">&#65509;77.30</span></p></li>
			</ul>
		</div>
	</div>
</section>
<section>
	<div class="menu-wrap" id="all-menu">
	<h2>全部分类</h2>
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
<div class="bottom">
	<img src="images/end.png">
</div>
<div id="toTop" class="to-top">
	<a href="#top">顶</a>
</div>
<script type="text/javascript" src="js/index.js">
</script>
</body>
</html>

