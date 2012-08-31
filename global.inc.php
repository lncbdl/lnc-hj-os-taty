<?php
define('WEB_ROOT_DIR', dirname(__FILE__)); //网站根目录
define('CONFIGE_DIR', WEB_ROOT_DIR . '/Config'); //网站配置文件目录

//define('NSP_DIR', dirname(dirname(__FILE__)) .'/NSP');
//define('LIBRARIES_DIR' , NSP_DIR . '/Libraries');					//librarirs目录

//导入NSP框架
require dirname(dirname(__FILE__)) .'/NSP/CORE.php';

include_once(CONFIGE_DIR . '/define.php');
include_once(CONFIGE_DIR . '/vocation.php');
include_once(CONFIGE_DIR . '/alias.php');

//include_once(LIBRARIES_DIR . '/common.php');
//include_once(LIBRARIES_DIR . '/ClsFactory.class.php');
// 定义项目名称和路径 
if(!defined('APP_NAME')) {
    define('APP_NAME',  'taty');
}
//清除核心缓存
//define('NO_CACHE_RUNTIME' ,True);
//define('APP_PATH' ,  WEB_ROOT_DIR);
// 定义 ThinkPHP 框架路径 ( 相对于入口文件 )
//define('THINK_PATH', WEB_ROOT_DIR . '/ThinkPHP/');

//判断是否是ajax请求
define('IS_AJAX_REQUESTED', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) ? true : false);
//require('CORE.php');
?>
