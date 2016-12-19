<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>test_php_mysql</title>
</head>
<body>

<?php
echo "connnect to the mysql server: <br />";
    $dbname = 'OMVaEaRzbiHZRufXuFQz';
    $host = "sqld.duapp.com";  //服务器主机地址
    $port = 4050;
    $user = "6b54471817fc44918eb1087d4d353810";  //mysql用户名
    $pass = "6d195d87bd424aa785639c63024d509d";  //mysql用户名密码

$conn = mysql_connect("{$host}:{$port}",$user,$pass,true);

if( !$conn ) {
    die("could not connect: " . mysql_error($conn));
}else {
    echo "connect successfully~";
}

if( !mysql_select_db( $dbname, $conn ) ) {
    die("select database failed : " . mysql_error($conn) );
}

/*至此连接已完全建立，就可对当前数据库进行相应的操作了*/
//创建一个数据库表
$sql = "create table if not exists test_mysql(
        id int primary key auto_increment,
        no int,
        name varchar(1024),
        key idx_no(no))";
$ret = mysql_query($sql, $conn);
if ($ret === false ) {
    die("Create Table Failed: " . mysql_error($conn));
} else {
    echo "Create Table Succeed<br />";
}


/*显式关闭连接，非必须*/
mysql_close($conn);

?>
</body>
</html>