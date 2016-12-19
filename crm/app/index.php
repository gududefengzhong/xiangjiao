<?php
/**
 * Created by PhpStorm.
 * User: rochestor
 * Date: 16/8/5
 * Time: 上午1:58
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


//建立连接
$conn = new MySQLi($hostname, $username, $password,$database,$port);

//检测连接
if( $conn -> connect_error ) {
    die("连接失败: " . $conn -> connect_error);
}

//设置客户端字符集
$conn -> set_charset("UTF8");



$zone = $_GET['zone'];
$movie_type = $_GET['movie_type'];
$show_time = $_GET['show_time'];

$sql_where = " WHERE is_del=0 ";
if( $zone ) {
    $sql_where .= " AND zone='{$zone}'";
}

if( $movie_type ) {
    $sql_where .= " AND movie_type LIKE '%{$movie_type}%'";
}

if( $show_time ) {
    $sql_where .= " AND show_time='{$show_time}'";
}

$sql = "SELECT * FROM movie " . $sql_where;
//print_r($sql);exit;
$res = $conn -> query( $sql );

if( $res && $res -> num_rows > 0 ) {
    while( $row = $res -> fetch_assoc() ) {
        $movie_info[] = $row;
    }
}

//print_r( $movie_info );exit;
//print_r( $_GET );exit;


//显式关闭连接
$conn -> close();

//exit;

include_once ("../template/index.php");


