<?php
require_once 'wx.php';
define("APPID", "wx2d54a161bbd17895");
define("APPSECRET", "82c3de30cede9db4acdb33894f10f5bc");



//用户授权后的回调
if(isset($_GET["code"])&&isset($_GET["state"])){
    $code = $_GET["code"];
    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code={$code}&grant_type=authorization_code";
    
    $result_json = func_https_request($url);
    $result_arr = json_decode($result_json, true);
    
    if(isset($result_arr["access_token"])){
        if(!isset($_COOKIE["9book_openid"])){
            $deadtime = time()+60*60*30;
            setcookie("9book_openid", $result_arr["openid"],$deadtime,"/");
            session_start();
            $_SESSION["9book_openid"] = $result_arr["openid"];
        }
        else{
            $deadtime = time()+60*5;
            setcookie("9book_openid", $result_arr["openid"],$deadtime,"/");
            session_start();
            $_SESSION["9book_openid"] = $result_arr["openid"];
        }
        echo '<meta http-equiv="refresh" content="0;url=http://9book.55555.io/book_store/index.php">';
        exit();
       
    }
    else {
        if(isset($result_arr["errcode"])){
            $deadtime = time()+3600*24;
            setcookie("errcode", $result_arr["errcode"],$deadtime);
            echo "errcode:".$result_arr["errcode"];
        }
        else {
            $deadtime = time()+3600*24;
            setcookie("9book_test", "nothing",$deadtime);
            echo "Nothing";
        }
    }
    
}

