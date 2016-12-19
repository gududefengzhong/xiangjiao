<?php
/**
 * Created by PhpStorm.
 * User: rochestor
 * Date: 16/8/7
 * Time: 下午1:23
 */
require_once(dirname(dirname(__FILE__))."/app.php");
//连接数据库
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
$conn = new MySQLi($hostname, $username, $password, $database,$port);

//检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

//设置客户端字符集
$conn->set_charset("UTF8");


$action = $_GET['action'];

if ("get_info" == $action) {
    $row_id = $_POST['row_id'];
//    print_r( $row_id);exit;
    $sql = "select * from movie where id=$row_id";
    $res = $conn->query($sql);

    if( $res && $res -> num_rows > 0 ) {
        while( $row = $res -> fetch_assoc() ) {
            $movie_info[] = $row;
        }
    }
    $res->free();
    $conn->close();
    print_r(json_encode(array("ok" => 1, 'msg' => $movie_info)));


} elseif ("submit" == $action) {

    print_r( $_POST );
    print_r( $_FILES );exit;


} elseif ("delete" == $action) {
    $row_id = $_POST['row_id'];
//    print_r( $row_id);exit;
    $sql = "UPDATE movie SET is_del = 1 where id=$row_id";
    $res = $conn->query($sql);
    if ( res ) {
        print_r(json_encode(array("ok" => 1, 'msg' => "删除成功")));
    }else {
        print_r(json_encode(array("ok" => 0, 'msg' => "删除失败")));
    }
    $conn->close();


}

