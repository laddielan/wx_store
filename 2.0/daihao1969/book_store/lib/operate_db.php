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
    
	if(isset($_GET["action"])){
	    if($_GET["action"]=="addShopcart"){
	        addShopcart();
	    }
	  
	}

?>