<?php

define("APPID", "wx2d54a161bbd17895");
define("APPSECRET", "82c3de30cede9db4acdb33894f10f5bc");
//用于向微信发送消息
function func_https_request($url, $data = null){

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

//获取用户的OpenID
function func_get_user_info(){
   
    $redirect_uri = "http://9book.55555.io/book_store/lib/wx_operate.php";
    $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
    func_https_request($url);
}
































?>