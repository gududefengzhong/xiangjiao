<?php
/**
 * Created by PhpStorm.
 * User: rochestor
 * Date: 16/8/12
 * Time: 下午10:18
 */
require_once(dirname(dirname(__FILE__))."/app.php");
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


$drama_type_config = array(
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

$drama_detail_url = "drama_detail.php";
$zone = filter_input(INPUT_GET,'zone',FILTER_SANITIZE_STRING);
$year = filter_input(INPUT_GET,'year',FILTER_SANITIZE_STRING);
$drama_type = filter_input(INPUT_GET,'drama_type',FILTER_SANITIZE_STRING);


//建立连接
$conn = new MySQLi($hostname, $username, $password,$database,$port);

//检测连接
if( $conn -> connect_error ) {
    die("连接失败: " . $conn -> connect_error);
}

$sql_where =  " WHERE is_del = 0 ";
if( $zone ) {
    $sql_where .= " AND zone='" . $zone . "'";
}

if( $year ) {
    $sql_where .= " AND date_format(show_time,'%Y')='" . $year . "'";
}

if( $drama_type ) {
    $sql_where .= " AND drama_type LIKE '%" . $drama_type . "%'";
}

//设置客户端字符集
$conn -> set_charset("UTF8");

$sql = "SELECT * FROM drama ".$sql_where;
//print_r($sql);exit;
$res = $conn -> query( $sql );


if( $res && $res -> num_rows > 0 ) {
    while( $row = $res -> fetch_assoc() ) {
        $drama_info[] = $row;
    }
}

//print_r( $_GET );exit;

$right_sql = "SELECT * FROM drama WHERE is_del=0";
//print_r($sql);exit;
$right_res = $conn -> query( $right_sql );


if( $right_res && $right_res -> num_rows > 0 ) {
    while( $row = $right_res -> fetch_assoc() ) {
        $right_drama_info[] = $row;
    }
}

$carousel_list = array_slice( $right_drama_info, 0, 10);

$drama_rank = array_slice( $right_drama_info, 0, 10 );
//print_r( $drama_rank );exit;

//$drama_recommend = array_slice( $drama_info, 10, 10 );
$drama_recommend = $drama_rank;

//类型
$drama_types = array();
//区域
$zone_list = array();
//年代
$year_list = array();

if( $drama_info && is_array($drama_info) ) {
    foreach( $drama_info as $k => $v ) {
        $tem = explode("," , $v['drama_type']);
        foreach( $tem as $kk => $vv ) {
            $drama_types[] = $vv;
        }
        $zone_list[] = $v['zone'];
        $year_list[] = date("Y", strtotime($v['show_time']));
    }
}
$drama_types = array_unique($drama_types);
$zone_list = array_unique($zone_list);
$year_list = array_unique($year_list);


//print_r( $drama_type );exit;
//电影

//print_r( $carousel_list );exit;
//echo __FILE__;exit;

//显式关闭连接
$conn -> close();








include ("../template/drama.php");