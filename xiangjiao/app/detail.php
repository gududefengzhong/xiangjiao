<?php
/**
 * Created by PhpStorm.
 * User: rochestor
 * Date: 16/8/13
 * Time: 下午2:44
 */
require_once(dirname(dirname(__FILE__))."/app.php");

$row_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

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


$movie_type_config = array(
     '剧情',
    '爱情',
     '喜剧',
    '动作',
     '悬疑',
     '动画',
    '恐怖',
    '科幻',
    '犯罪',
    '战争',
    '记录',
    '伦理',
);



//建立连接
$conn = new MySQLi($hostname, $username, $password,$database,$port);

//检测连接
if( $conn -> connect_error ) {
    die("连接失败: " . $conn -> connect_error);
}

//设置客户端字符集
$conn -> set_charset("UTF8");

$detail_sql = "SELECT * FROM movie WHERE is_del=0 AND id=" . $conn -> escape_string($row_id);
//print_r($detail_sql);exit;
$detail_res = $conn -> query( $detail_sql );

if( $detail_res && $detail_res -> num_rows > 0 ) {
    while( $row = $detail_res -> fetch_assoc() ) {
        $detail_info[] = $row;
    }
}

//注意  $detail_info  如果为空,那么直接跳到  错误页面

$detail_info = $detail_info[0];
//print_r( $detail_info );exit;

$sql = "SELECT * FROM movie WHERE is_del=0";
//print_r($sql);exit;
$res = $conn -> query( $sql );

if( $res && $res -> num_rows > 0 ) {
    while( $row = $res -> fetch_assoc() ) {
        $movie_info[] = $row;
    }
}

//print_r( $movie_info );exit;
//print_r( $_GET );exit;

$movie_rank = array_slice( $movie_info, 0, 9 );

$movie_recommend = array_slice( $movie_info, 10, 10 );

$movie_types = array();

if( $movie_info ) {
    foreach( $movie_info as $k => $v ) {
        $tem = explode("," , $v['movie_type']);
        foreach( $tem as $k => $v ) {
            $movie_types[] = $v;
        }
    }
}
$movie_types = array_unique($movie_types);
//print_r( $movie_types );exit;

//显式关闭连接
$conn -> close();


include ("../template/detail.php");


