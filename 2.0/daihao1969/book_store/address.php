<?php 
    require_once 'lib/db.php';
    define("OPENID","oOEo4wdha12cmoJ2WFSAWBZ2vPpA");
    $conn = connect_db();
    $sql = "SELECT * FROM address WHERE openid='".OPENID."'";
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
	<title>我的收货地址</title>

	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/address.css">
	 <script src="http://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>
    <script src="js/json/CityJson.js" type="text/javascript"></script>
    <script src="js/json/ProJson.js" type="text/javascript"></script>
    <script src="js/json/DistrictJson.js" type="text/javascript"></script>
</head>
<body>
<header class="header-wrap">
	<div class="home-content"><a href="index.php"><img class="header-logo" src="images/logo.png"/>9号书店</a></div>	
</header>
<section>
<?php 
    if(!empty($sql_res)){
        echo '<ul class="address-wrap">';
       foreach ($sql_res as $adrs_item){
           echo '<li class="adrs-item-wrap"><div class="icon-check-wrap"><img class="icon-check" src="images/icon_to_check.png"></div><p class="adrs-content-wrap">';
           echo $adrs_item["name"].'，';
           echo $adrs_item["phone"].'<br>'.$adrs_item["province"].' '.$adrs_item["city"].' '.$adrs_item["district"].' '.$adrs_item["address"];
           echo '</p><div class="icon-edit-wrap"><img class="icon-edit" src="images/icon_edit.png"></div></li>';
       }
        echo '</ul>';
    }
    else{
        echo '<h2>啥都没有</h2>';
    }
?>

</section>
<footer>
	<input type="button" id="add-new-adrs" name="" value="添加新地址">
</footer>
<section class="edit-wrap" id="page-edit">
<div class="edit-content">
	<div class="edit-header-wrap">
		<p class="edit-header-title"><span id="edit-close-btn" class="edit-header-close"><img src="images/icon_down.png"> 添加新地址</span>	
			<input type="button" id="edit-save-btn" class="edit-header-save-wrap" value="保存" name="">
		</p>
	</div>
	<ul>
		<li>
			<p class="edit-item-wrap">收货人：<input type="text" id="contact" name="contact"></p>
		</li>
		<li>
			<p class="edit-item-wrap">联系电话：<input type="text" placeholder="11位电话号码" id="telephone" name="telephone"></p>
		</li>
		<li>
		<div class="edit-item-wrap">		
			<p class="edit-item-location-title">所在地区：</p>
			<p class="edit-item-location"> 
				<select id="selProvince">
	        		<option value="0">请选择省份</option>
	    		</select>
			    <select id="selCity">
			        <option value="0">请选择城市</option>
			    </select>
			    <select id="selDistrict">
			        <option value="0">请选择区/县</option>
			    </select>
		    </p>
		</div>
		</li>
		<li>
			<p class="edit-item-wrap"><textarea id="detailAdrs" placeholder="详细地址"></textarea></p>
		</li>
	</ul>
</div>
	
</section>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/address.js"></script>
</body>
</html>