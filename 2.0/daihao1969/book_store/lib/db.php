<?php

/**
 * 连接数据库
 * @return resource
 * */
function connect_db()
{
    //$db_server = mysqli_connect(SAE_MYSQL_HOST_M,SAE_MYSQL_USER,SAE_MYSQL_PASS,SAE_MYSQL_DB,SAE_MYSQL_PORT);
    $db_server = mysqli_connect('LOCALHOST','root','laddie','info_of_user');
    mysqli_set_charset($db_server, 'utf8');	     
    if(!$db_server){
        die("Unable to connect to MySQL: ".mysqli_connect_error());
    }
    
   return $db_server;
}


/**
 * 往指定字段中插入数据
 * @param resource $conn
 * @param string $table
 * @param array $array
 * @return number
 * */
function insert($conn,$table,$array)
{
    $keys = join(",",array_keys($array));
    $vals = "'".join("','",array_values($array))."'";
    $sql = "INSERT {$table} ($keys) values($vals)";
    mysqli_query($conn, $sql);
    return mysqli_insert_id($conn);
}


/**
 * @param resource $conn
 * @param string $table
 * @param array $array 
 * @param string $where
 * @return  number
 * */
function update($conn,$table,$array,$where)
{
    $str = null;
    foreach ($array as $key => $val){
        
        if($str == null){
            $sep = "";
        }
        else{
            $sep = ",";
        }        
        $str.=$sep.$key."=".$val."";
    }
    
    $sql = "UPDATE {$table} SET {$str}".($where == null?null:" WHERE ".$where);
    echo $sql;
    $result = mysqli_query($conn, $sql);
    
    if($result){
        return mysqli_affected_rows($conn);
    }
    else{
        return false;
    }   
}


/**
 *得到指定一条记录
 * @param resource $conn
 * @param string $sql
 * @param string $result_type
 * @return multitype:
 */
function fetchOne($conn,$sql, $result_type=MYSQLI_ASSOC){
   
    $result = mysqli_query($conn,$sql);
    if(false == $result){    
        return false;
    }
    $row = mysqli_fetch_array($result, $result_type);
   
    return $row;
}


/**
 * 得到结果集中所有记录 ...
 * @param resource $conn
 * @param string $sql
 * @param string $result_type
 * @return multitype:
 */
function fetchAll($conn,$sql, $result_type=MYSQLI_ASSOC){
    $result = mysqli_query($conn, $sql);
    $rows = Array();
    while(@$row = mysqli_fetch_array($result,$result_type)){
        $rows[] = $row;
    }
    return $rows;
}


/**
 * 得到结果集中的记录条数
 * @param $conn resource
 * @param unknown_type $sql
 * @return number
 */
function getResultNum($conn,$sql){
    $result = mysqli_query($conn, $sql);
    //return mysqli_num_rows($result);
    return $result->num_rows;
}


/**
 * 删除记录
 * @param resource $conn
 * @param string $table
 * @param string $where
 * @return number
 */
function delete($conn,$table, $where=null){
    $where = $where==null ? null :"WHERE ".$where;
    $sql = "DELETE FROM {$table} {$where}";
    mysqli_query($conn,$sql);
    return mysqli_affected_rows($conn);
}



































	
?>