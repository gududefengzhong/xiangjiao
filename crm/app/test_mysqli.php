<?php
/**
 * Created by PhpStorm.
 * User: rochestor
 * Date: 16/8/6
 * Time: 下午10:46
 */

//建立到MySql的连接
$conn = new mysqli("127.0.0.1",'root','Mudi.123');
print_r( $conn );exit;


//打开指定的数据库
$conn -> select_db("sys");

$conn = new mysqli();
$conn -> connect('127.0.0.1','root','Mudi.123');
print_r( $conn );exit;

//建立连接的同时,指定数据库
$conn = new mysqli("127.0.0.1",'root','Mudi.123','sys');
$conn -> connect_error;//得到连接产生的错误信息
$conn -> connect_errno;//得到链接产生的错误编号

//获取客户端信息
$conn -> client_info();
//或者
$conn -> get_client_info();

//客户端版本
$conn -> client_version;

//服务器信息
$conn -> get_server_info();

//服务器版本
$conn -> server_version;

$conn -> set_charset("utf8");


//执行单条SQL语句,只能执行一条sql语句
$sql = "";
$res = $conn -> query( $sql );

//example

$sql = "INSERT INTO user(username, password) values('di.mu','di.mu')";
$res = $conn -> query( $sql );
if( $res ) {
    echo "恭喜您注册成功,您是网站的第".$conn -> insert_id . "位用户<br />";
    //得到上一步操作产生的受影响的条数
    echo "有". $conn -> affected_rows . "行记录受影响 ";
}else {
    echo "ERROR " . $conn -> errno . " : ". $conn -> error;
}

//example2
$res = $conn -> query( $sql );
if( $res && $res -> num_rows > 0 ) {
    echo $res -> num_rows;
    //获取结果集中的所有记录,默认返回的是二维的索引+索引的形式
    $rows = $res -> fetch_all();
    $rows = $res -> fetch_all(MYSQLI_ASSOC);
    $rows = $res -> fetch_all(MYSQLI_NUM);
    $rows = $res -> fetch_all(MYSQLI_BOTH);
    print_r( $rows );

    //得到结果集中的第一条记录作为索引数组返回
    $row = $res -> fetch_row();
    //得到结果集中的第一条记录作为关联数组返回
    $row = $res -> fetch_assoc();
    //得到结果集中的第一条记录作为关联,索引数组返回
    $row = $res -> fetch_array();

    //得到数组对象
    $row = $res -> fetch_object();

    //移动结果集内部指针
    $res -> data_seek(0);
    $row = $res -> fetch_assoc();
    print_r( $row );exit;

    //获取结果集中的所有记录
    while( $row = $res -> fetch_assoc() ) {
        print_r( $row );
        echo "<hr />";
//        $row[] = $row;
    }

    //释放结果集
    $res -> close();




    //多个结果集
    $sql = 'select id ,name from user';
    $sql .= "select id ,name from aa.user";

    //use_result  store_result();//获取第一条查询产生的结果集
    //more_results():检测是否有更多的结果集
    //next_result(): 将结果集指针向下面移动一位;

    if( $conn -> multi_query( $sql ) ) {
        do{
            if( $res = $conn -> store_result() ) {
                $rows[] = $res -> fetch_all( MYSQLI_ASSOC );
            }
        }while( $conn -> more_results() && $conn -> next_result() );
    }else{
        echo $conn -> error;
    }


    //预处理语句
    $sql = "INSERT INTO user(username,password,age) VALUES(?,?,?)";

    //准备预处理语句
    $stmt = $conn -> prepare( $sql );
    //s: string字符串
    //i: integer整形
    //d: double浮点型

    $username ='di.mu';
    $password = md5('mudi');
    $age=23;
    //绑定参数
    $stmt -> bind_param("ssi", $username,$password,$age);

    //执行预处理语句
    if( $stmt -> execuct( $sql ) ) {
        //绑定结果集中的值到变量
//        $stmt -> bind_resule();
        //遍历结果集
        while( $stmt -> fetch() ) {
            echo '';
        }

        $stmt -> free_result();
        $stmt -> close();

    }









}else {
    echo '查询错误,或者结果集中没有记录';
}

