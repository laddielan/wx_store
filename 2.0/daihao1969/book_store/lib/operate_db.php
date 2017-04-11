<?php
    require_once 'db.php';
    
   
    
    function addShopcart(){
        $bookid = $_GET["bookId"];
        $booknum = $_GET["bookNum"];
        $openid = "oOEo4wdha12cmoJ2WFSAWBZ2vPpA";
        $table = "shopcart";
        $conn = connect_db();
        $sql = "SELECT * FROM shopcart WHERE bookId='".$bookid."' and openid='".$openid."'";
        $item = fetchOne($conn, $sql);
        if(false == $item){
            //用当前时间作为当前订单书籍itemid
            $itemid = time();
          
            $array = array("itemid"=>$itemid, "bookid"=>$bookid,"openid"=>$openid, "booknum"=>$booknum);
           // print_r($array);
            insert($conn, $table, $array);
        }
        else{
            $itemid = $item["itemid"];
            $obooknum = $item["booknum"];
            $booknum +=$obooknum;
            
            $where = "itemid=".$itemid;
            $array = array("booknum"=>$booknum);
            update($conn, $table, $array, $where);
        }
        
        mysqli_close($conn);
    }

    //根据itemId更新书籍数量
    function updateShopcart(){
        $itemid = $_GET["itemId"];
        $booknum = $_GET["bookNum"];
        $conn = connect_db();
        $table = "shopcart";
        $array = array("booknum"=>$booknum);
        $where = "itemid=".$itemid;
        update($conn,$table,$array,$where);
        mysqli_close($conn);
    }

    //根据itemid删除条目
    function deleteShopcart(){
        $itemid = $_GET["itemId"];
        $conn = connect_db();
        $table = "shopcart";
        $where = "itemid=".$itemid;
        delete($conn,$table,$where);
    }
    
    function addNewAdrs(){
        $conn = connect_db();
        $openid = $_POST["openid"];
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $province = $_POST["province"];
        $city = $_POST["city"];
        $district = $_POST["district"];
        $address =  $_POST["address"];
        $addressid = time();
       
      
        $table = "address";
        $arr = array("addressid"=>$addressid,"openid"=>$openid, "name"=>$name, "phone"=>$phone, "province"=>$province, "city"=>$city, "district"=>$district, "address"=>$address);
        
        insert($conn, $table, $arr);
        mysqli_close($conn);
    }
    
	
	
	function addOrder(){
	   
	    $addressid = $_POST["addressid"];
	    $itemsid = $_POST["itemsid"];
	    $itemid_arr = explode(",",$itemsid);
	    
	    $conn = connect_db();
	    
	    //获取OpenID
	    $sql = "SELECT openid FROM address WHERE addressid=".$addressid;
	    $openid_res = fetchAll($conn, $sql);
	    $openid =  $openid_res[0]["openid"];
	    $orderid = "O".time();
	    
	    $table = "orders";
	    $order_arr = array("openid"=>$openid,"orderid"=>$orderid,"addressid"=>$addressid,"state"=>0,"createtime"=>time());
	    insert($conn, $table, $order_arr);
	    

	    foreach ($itemid_arr as $itemid){
	     
	        $sql = "SELECT booknum,bookid FROM shopcart WHERE itemid=".$itemid;
	        $bookinfo = fetchAll($conn, $sql);
	       
	        //把购物车里的这条记录删除
	        $table = "shopcart";
	        $where = "itemid='".$itemid."'";
	        delete($conn, $table,$where);
	        
	        //在订单内容表中添加这条数据
	        $table = "order_content";
	        $order_content_arr = array("contentid"=>time(),"orderid"=>$orderid,"bookid"=>$bookinfo[0]["bookid"],"booknum"=>$bookinfo[0]["booknum"]);
	        insert($conn, $table, $order_content_arr);
	    }	    
	}
	
	if(isset($_GET["action"])){
	    switch ($_GET["action"]){
	        case "addShopcart": addShopcart(); break;
	        case "updateShopcart":updateShopcart();break;
	        case "deleteShopcart":deleteShopcart();break;
	         
	    }
	}
	
	if(isset($_POST["action"])){
	    switch ($_POST["action"]){
	        case "addAdrs":addNewAdrs();break;
	        case "addOrder":addOrder();break;
	    }
	}

?>





























