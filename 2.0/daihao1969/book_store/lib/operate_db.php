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
    
	if(isset($_GET["action"])){
	    if($_GET["action"]=="addShopcart"){
	        addShopcart();
	    }
	   else if($_GET["action"]=="updateShopcart"){
            updateShopcart();
       }
       else if($_GET["action"]=="deleteShopcart"){
            echo "Get~";
            deleteShopcart();
       }
	}

?>