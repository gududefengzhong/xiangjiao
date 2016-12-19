<?php
require_once(dirname(dirname(__FILE__))."/common/upload.php");
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

//phpinfo();exit;
//建立连接
$conn = new MySQLi($hostname, $username, $password,$database,$port);

//检测连接
if( $conn -> connect_error ) {
    die("连接失败: " . $conn -> connect_error);
}

//设置客户端字符集
$conn -> set_charset("UTF8");

//print_r( $_POST );exit;
//print_r( $_FILES );
if( $_POST ) {
//    print_r( $_POST );exit;

    $movie_name = trim(filter_input(INPUT_POST,'movie_name',FILTER_SANITIZE_STRING));
    $show_time = trim(filter_input(INPUT_POST,'show_time',FILTER_SANITIZE_STRING));
    $zone = trim(filter_input(INPUT_POST,'zone',FILTER_SANITIZE_STRING));
    $url = trim(filter_input(INPUT_POST,'url',FILTER_SANITIZE_STRING));
    $pan_code = trim(filter_input(INPUT_POST,'pan_code',FILTER_SANITIZE_STRING));
    $brief_desc = trim(filter_input(INPUT_POST,'desc',FILTER_SANITIZE_STRING));
    $title = trim(filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING));
    $short_title = trim(filter_input(INPUT_POST,'short_title',FILTER_SANITIZE_STRING));
    $director = trim(filter_input(INPUT_POST,'director',FILTER_SANITIZE_STRING));
    $actors = trim(filter_input(INPUT_POST,'actors',FILTER_SANITIZE_STRING));
    $movie_type = implode(",",$_POST['movie_type']);
//    print_r( $movie_type );exit;


    $image_files = get_files();
    $pics = [];
    if( $image_files && is_array( $image_files )) {
        foreach( $image_files as $k => $v ) {
            $image_upload = new upload($v,"../../xiangjiao/image",true);
            array_push($pics,$image_upload->uploadFile());
        }
    }

    $main_pic = implode(",", $pics);
//    print_r( $main_pic );exit;

    $insert_info = array(
        "movie_name" => $movie_name,
        "show_time" => $show_time,
        "zone" => $zone,
        "url" => $url,
        "pan_code" => $pan_code,
        "brief_desc" => $brief_desc,
        "title" => $title,
        "short_title" => $short_title,
        "director" => $director,
        "actors" => $actors,
        "movie_type" => $movie_type,
        "main_pic" => $main_pic,
        "create_time" => date("Y-m-d H:i:s",time()),
        "last_modify_time" => date("Y-m-d H:i:s",time()),
    );


    $keys=join(',',array_keys($insert_info));
    $values="'".join("','", array_values($insert_info))."'";
    $sql="INSERT INTO movie ({$keys}) VALUES ({$values})";
//    print_r( $sql );exit;
    $res = $conn -> query($sql);
    if($res){
        header("refresh:3;url=index.php");
        echo "操作成功";
    }else{
        header("refresh:3;url=index.php");
        echo "操作失败";
    }



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


include("../template/add_movie.php");