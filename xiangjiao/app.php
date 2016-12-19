<?php
/**
 * Created by PhpStorm.
 * User: rochestor
 * Date: 16/8/12
 * Time: 上午12:19
 */
date_default_timezone_set("Asia/Shanghai");
error_reporting(E_ALL^E_NOTICE^E_WARNING);
header ( "Content-type:text/html;charset=utf-8" );//必须的,否则mysqli乱码