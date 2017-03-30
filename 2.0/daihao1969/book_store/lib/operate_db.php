<?php
    require_once 'db.php';
    
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
        $openid = $_POST["openid"];
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $province = $_POST["province"];
        $city = $_POST["city"];
        $district = $_POST["district"];
        $address = $_POST["address"];
        $addressid = time();
        
        $conn = connect_db();
        $table = "address";
        $arr = array("addressid"=>$addressid,"openid"=>$openid, "name"=>$name, "phone"=>$phone, "province"=>$province, "city"=>$city, "district"=>$district, "address"=>$address);
        
        insert($conn, $table, $arr);
        mysqli_close($conn);
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
	    }
	}

?>





























