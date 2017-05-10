<?php
	
	//time: 2017/01/11
	//功能：创建菜单，由“9号书店”和“其他服务”两个子菜单组成
	//使用前需填入$appid 和$appsecret 的值
	
	$appid = "wx2d54a161bbd17895";
	$appsecret = "82c3de30cede9db4acdb33894f10f5bc";
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
	
	$output = https_request($url);
	$jsoninfo = json_decode($output,true);
	
	$access_token = $jsoninfo["access_token"];
	
	$jsonmenu = '{
		"button":[
		{
			"name":"9号书店",
			"sub_button":[
			{
				"type":"view",
				"name":"书店首页",
				"url":"http://9book.55555.io/book_store/index.php"
			},
			{
				"type":"click",
				"name":"讲个段子",
				"key":"段子"
			},
			{
				"type":"click",
				"name":"文艺的话",
				"key":"文艺"
			}
			]
		},
		{
			"name":"我的9号",
			"sub_button":[
			{
				"type":"view",
				"name":"购物车",
				"url":"http://9book.55555.io/book_store/shopcart.php",
				
			},
			{
				"type":"view",
				"name":"个人中心",
				"url":"http://9book.55555.io/book_store/user.php",
			
			}
			]
		}
		]
	}';
	

	
	$url = " https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
	$result = https_request($url,$jsonmenu);
	
	var_dump($result);
	
	function https_request($url,$data = null){
		
		$curl = curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
		
		if(!empty($data)){
			curl_setopt($curl,CURLOPT_POST,1);
			curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
		}
		
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>