<?php
/**
 * Created by PhpStorm.
 * User: rochestor
 * Date: 16/8/14
 * Time: 上午1:12
 */
require_once(dirname(dirname(__FILE__))."/app.php");
header ( "Content-type:text/html;charset=utf-8" );//必须的,否则mysqli乱码
//$hostname = "127.0.0.1";//不能写localhost否则出错  http://blog.csdn.net/dazhi_100/article/details/44157787
$hostname = "sqld.duapp.com";//不能写localhost否则出错  http://blog.csdn.net/dazhi_100/article/details/44157787
//$username = "root";
$username = "6b54471817fc44918eb1087d4d353810";
//$password = "Mudi.123";
$password = "6d195d87bd424aa785639c63024d509d";
//$database = 'crm';
$database = 'OMVaEaRzbiHZRufXuFQz';
//$port = '3306';
$port = 4050;

//echo date("Y-m-d H:i:s");exit;
//建立连接
$conn = new MySQLi($hostname, $username, $password,$database,$port);

//检测连接
if( $conn -> connect_error ) {
    die("连接失败: " . $conn -> connect_error);
}

//设置客户端字符集
$conn -> set_charset("UTF8");

$drama_name = filter_input(INPUT_GET,"drama_name",FILTER_SANITIZE_STRING);
$drama_id = filter_input(INPUT_GET,'drama_id',FILTER_VALIDATE_INT);


$sql_where = " WHERE is_del=0 ";
if( $drama_name ) {
    $sql_where .= " AND drama_name='{$drama_name}'";
}

if( $drama_id ) {
    $sql_where .= " AND drama_id={$drama_id}";
}

$sql = "SELECT * FROM drama_info " . $sql_where;
//print_r($sql);exit;
$res = $conn -> query( $sql );


if( $res && $res -> num_rows > 0 ) {
    while( $row = $res -> fetch_assoc() ) {
        $drama_info[] = $row;
    }
}

//print_r( $drama_info );exit;
//print_r( $_GET );exit;


//显式关闭连接
$conn -> close();

//exit;

include_once ("../template/drama_info.php");