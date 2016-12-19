<?php
/**
 * Created by PhpStorm.
 * User: rochestor
 * Date: 16/8/11
 * Time: 上午12:27
 */

require_once(dirname(dirname(__FILE__))."/common/upload.php");
require_once(dirname(dirname(__FILE__))."/app.php");
$movie_type_config = array(
    "juqing" => "剧情",
    "love" => "爱情",
    'comedy' => "喜剧",
    'action' => "动作",
    'lunli' => "伦理",
    'kehuan' => "科幻",
    'kongbu' => "恐怖",
    'jilu' => "记录",
    'fanzui' => "犯罪",
    'xuanyi' => "悬疑",
    'donghua' => "动画",
    'zhanzheng' => "战争",
);


header ( "Content-type:text/html;charset=utf-8" );//必须的,否则mysqli乱码
$hostname = "127.0.0.1";//不能写localhost否则出错  http://blog.csdn.net/dazhi_100/article/details/44157787
$username = "root";
$password = "Mudi.123";
$database = 'crm';
//phpinfo();exit;
//建立连接
$conn = new MySQLi($hostname, $username, $password,$database);

//检测连接
if( $conn -> connect_error ) {
    die("连接失败: " . $conn -> connect_error);
}

//设置客户端字符集
$conn -> set_charset("UTF8");

$sql = "SELECT id, drama_type FROM drama WHERE is_del=0";
$res = $conn -> query( $sql );
//print_r($res);exit;

if( $res && $res -> num_rows > 0 ) {
    $movie_info = $res -> fetch_all(MYSQLI_ASSOC);
}

//print_r( $movie_info );exit;

foreach( $movie_info as $k => $v ) {
    $id = $v['id'];
    $movie_type = $v['drama_type'];
    $res = '';

    foreach( $movie_type_config as $k => $v ) {
        if( strpos( $movie_type, $k ) !== FALSE ) {
            $res .= $v.",";
        }
    }
    $update_info = array(
        "drama_type" => rtrim($res,","),
    );
//print_r( $update_info );exit;



    $sets = "";
    $where = " WHERE id=${id}";
    foreach ( $update_info as $key => $val ){
        $sets.=$key."='".$val."',";
    }
    $sets=rtrim($sets,','); //去掉SQL里的最后一个逗号
    $sql="UPDATE drama SET {$sets} {$where}";
//    print_r( $sql );exit;
    $res=$conn -> query($sql);

    if($res){
        echo $k + 1 . " 编辑成功<br />";
    }else{
        echo $k + 1 . " 编辑失败<br />";
    }
}

exit;

/**
 * @return string
 * 准备好电影类型,包含选中状态
 */
function prepare_movie_type( $movie_type ) {
    global $movie_type_config;

    $res = '';
    foreach( $movie_type_config as $k => $v ) {
        if( strpos( $movie_type, $k ) !== FALSE ) {
            $res .= "<input type='checkbox' checked='checked' name='movie_type[]' value='{$k}''>" . $v;
        }else{
            $res .= "<input type='checkbox' name='movie_type[]' value='{$k}''>" . $v;
        }

    }
    return $res;

}



/**
 * @return mixed
 * 构建上传文件的信息
 */
function get_files() {
    $i = 0;
    foreach( $_FILES as $file ) {
        if(is_string( $file['name'])) {
            $files[$i] = $file;
            $i++;
        }elseif(is_array($file['name'])){
            foreach( $file['name'] as $key => $val){
                $files[$i]['name'] = $file['name'][$key];
                $files[$i]['type'] = $file['type'][$key];
                $files[$i]['tmp_name'] = $file['tmp_name'][$key];
                $files[$i]['error'] = $file['error'][$key];
                $files[$i]['size'] = $file['size'][$key];
                $i++;
            }
        }
    }
    return $files;
}

//常用公共方法
/**
 * 跳转到错误提示页
 *
 * @param $redirect 跳转链接（到错误页后的）
 * @param $type     类型，true为成功页，false为失败页
 * @param $msg      错误提示文字
 * @author di.mu
 * @date 2016-08-10
 */
function page_result($redirect, $type = true, $msg = false, $second = 3) {
    if (!$msg) {
        if ($type) {
            $msg = '操作成功！';
        } else {
            $msg = '数据错误';
        }
    }
    if (!$redirect) $redirect = $_SERVER['REQUEST_URI'];
    set_session("page_notice_word", $msg);
    set_session("last_page", $_SERVER['REQUEST_URI']);
    set_session("redirect", $redirect);
    set_session("page_notice_type", $type);
    set_session("redirect_second", $second);
    header('Location: ' . "/page_result.php");
    die();
}

/**
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 * @return void
 */
function redirect($url, $time = 0, $msg = '', $msg_set_session = false) {
    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            if ($msg_set_session) {
                set_session("redirect_word", $msg);
            } else {
                echo($msg);
            }
        }
        exit();
    } else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0) {
//            $str .= $msg;   //需要进一步优化此处
        }
        if ($msg_return) {
            set_session("redirect_word", $str);
        } else {
            echo($str);
        }
    }
}


//操作数据库的方法
/* array(
'username'=>'king',
'password'=>'123123',
'email'=>'dh@qq.com'
) */

/**
 * 插入记录的操作
 * @param array $array
 * @param string $table
 * @return boolean
 */
function insert($array,$table){
    $keys=join(',',array_keys($array));
    $values="'".join("','", array_values($array))."'";
    $sql="insert {$table}({$keys}) VALUES ({$values})";
    $res=mysql_query($sql);
    if($res){
        return mysql_insert_id();
    }else{
        return false;
    }
}


/**
 * MYSQL更新操作
 * @param array $array
 * @param string $table
 * @param string $where
 * @return number|boolean
 */
function update($array,$table,$where=null){
    foreach ($array as $key=>$val){
        $sets.=$key."='".$val."',";
    }
    $sets=rtrim($sets,','); //去掉SQL里的最后一个逗号
    $where=$where==null?'':' WHERE '.$where;
    $sql="UPDATE {$table} SET {$sets} {$where}";
    $res=mysql_query($sql);
    if ($res){
        return mysql_affected_rows();
    }else {
        return false;
    }
}


/**
 * 删除记录的操作
 * @param string $table
 * @param string $where
 * @return number|boolean
 */
function delete($table,$where=null){
    $where=$where==null?'':' WHERE '.$where;
    $sql="DELETE FROM {$table}{$where}";
    $res=mysql_query($sql);
    if ($res){
        return mysql_affected_rows();
    }else {
        return false;
    }
}



/**
 * 查询一条记录
 * @param string $sql
 * @param string $result_type
 * @return boolean
 */
function fetchOne($sql,$result_type=MYSQL_ASSOC){
    $result=mysql_query($sql);
    if ($result && mysql_num_rows($result)>0){
        return mysql_fetch_array($result,$result_type);
    }else {
        return false;
    }
}





/**
 * 得到表中的所有记录
 * @param string $sql
 * @param string $result_type
 * @return boolean
 */
function fetchAll($sql,$result_type=MYSQL_ASSOC){
    $result=mysql_query($sql);
    if ($result && mysql_num_rows($result)>0){
        while ($row=mysql_fetch_array($result,$result_type)){
            $rows[]=$row;
        }
        return $rows;
    }else {
        return false;
    }
}


/**取得结果集中的记录的条数
 * @param string $sql
 * @return number|boolean
 */
function getTotalRows($sql){
    $result=mysql_query($sql);
    if($result){
        return mysql_num_rows($result);
    }else {
        return false;
    }

}

/**释放结果集
 * @param resource $result
 * @return boolean
 */
function  freeResult($result){
    return  mysql_free_result($result);
}



/**断开MYSQL
 * @param resource $link
 * @return boolean
 */
function close($link=null){
    return mysql_close($link);
}






//exit;


include("../template/edit_movie.php");