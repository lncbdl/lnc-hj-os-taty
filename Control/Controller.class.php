<?php
/**
 * 控制层基类
 */
session_start();

abstract class Controller extends Action
{
    
    //用户输入对象
    protected $objInput;
    
    protected $commandobjarr = array();
    
    protected $user;
    
    public function __construct() {
        parent::__construct();
//        echo "<pre>";
//        echo "__Construct \n";
        
          $this->objInput =  Request::getInstance();
    }
    
    public function _initialize(){
    	header("Content-Type:text/html; charset=utf-8");
//        echo "<pre>";
//        echo "_initialize \n";    	
    	
    	//检查用户是否登录;
//    	$this->login_aop();
    	
 	    // 执行命令模式
        $this->run_command();
    }
    
    //判断用户是否登录.
    public function login_aop() {

//        echo "<pre>";
//        echo "loginAop \n";            

        $access_token = $this->get_access_token();
        $username = $this->get_cookie_account();

        if (empty($access_token) || empty($username)) {
            // 跨域调用统一获取cookie,
                $domain = $this->get_domain($_SERVER['HTTP_HOST']);
                //是否跨域
                if (C('COOKIEDOMAIN') != ".$domain") {        
                        $uc_cookie_url = $this->get_uc_cookie_url();
                        $uc_cookie_url = $uc_cookie_url . '?' . rand();
                        
                        $uc_login_url = $this->get_uc_login_url();
                    $this->assign('uc_get_cookie_url', "$uc_cookie_url");
                    $this->assign('uc_login_url', $uc_login_url);
                    $this->assign('domain', $domain);
                    $this->assign('cookie_name', SESSION_TOKEN);
                    $this->display('Public/uc_client');
                    exit;
                } else {
                // 当前域没有登录，跳转到登录页面
                    $this->to_login();
                }
        }

        //设定当前登录用户
        $mUser = ClsFactory::Create('Model.mUser');
        $userlist = $mUser->getUserByUid($username);
        if (isset($userlist[$username])) {
            $this->user = $userlist[$username];
        }

    }    
    
    //跳转到登录页面
    public function to_login($callback = ''){

        if(empty($callback)) {
            $callback = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
        }

        $uc_login = $this->get_uc_login_url();

   	    $sso_url = $uc_login . '?callback=' . urlencode($callback);        
        header("Location:$sso_url");
    }
    
    /*
     * 根据url 获取域名 
     * 举例: url = http://vm.wmw.cn/xxx.php
     *      $domain = $this->get_domain($url)  // echo wmw.cn
     */
    function get_domain($url){
        $pattern = "/[\w-]+\.(com|net|org|gov|cc|biz|info|cn)(\.(cn|hk))*/";
        preg_match($pattern, $url, $matches);
        if(count($matches) > 0) {
            return $matches[0];
        } else {
            $rs = parse_url($url);
            $main_url = $rs["host"];
            if(!strcmp(long2ip(sprintf("%u",ip2long($main_url))),$main_url)) {
                return $main_url;
            } else {
                $arr = explode(".",$main_url);
                $count=count($arr);
                $endArr = array("com","net","org","3322");//com.cn  net.cn 等情况
                if (in_array($arr[$count-2],$endArr)){
                    $domain = $arr[$count-3].".".$arr[$count-2].".".$arr[$count-1];
                }else{
                    $domain =  $arr[$count-2].".".$arr[$count-1];
                }
                return $domain;
            }
        }
    }
    
    /* 
     * 获取用户中心统一登录地址
     */    
    
    public function get_uc_login_url() {
        
        $uc_domain = C('UC_DOMAIN');
        $uc_login_url = C('UC_LOGIN_URL');
        $uc_login = "http://$uc_domain$uc_login_url";  
        if (empty($uc_login)) {
            $uc_login = 'http://'.$_SERVER['SERVER_NAME'] . 'ucenter/index';
        }
        return $uc_login;
    }    
    
    /* todo 放到common function 文件
     * 获取用户中心统一获取cookie地址
     */    
    
    public function get_uc_cookie_url() {
        
        $uc_domain = C('UC_DOMAIN');
        $uc_get_cookie_url = C('UC_GET_COOKIE_URL');
        $getcookie_url = "http://$uc_domain$uc_get_cookie_url";  
        if (empty($getcookie_url)) {
            $getcookie_url = 'http://'.$_SERVER['SERVER_NAME'] . '/ucenter/login_api/getcookie/';
        }
        return $getcookie_url;
    }     
    
    
    //获取access_token
	function get_access_token(){
		$token = $this->get_cookie_token_info();
		$access_token = '';
		if (isset($token['access_token'])) {
		    $access_token = $token['access_token'];
		}
		return $access_token;
	}      
    
    
    //获取用户帐号
	function get_cookie_account(){
		$token = $this->get_cookie_token_info();
		$username = '';
		if (isset($token['username'])) {
		    $username = $token['username'];
		}
		return $username;
	}
    
    //获取cookie中的token
	public function get_cookie_token_info($token_name) {

		if (empty($token_name)) {
			$token_name = SESSION_TOKEN;
		}
		
		$token = $_COOKIE[$token_name];
		$token_arr = token_decode($token);
		
		$result = array();
		if (!empty($token_arr) && count($token_arr) == 5) {
		    list($client_id, $username, $access_token, $expires_in, $scope) = $token_arr;
            $result = array(
              "client_id"    => $client_id,
              "username"	 => $username,
              "access_token" => $access_token,
              "expires_in"	 => $expires_in,
              "scope"		 => $scope
            );			    
		    
		}
		
		return $result;
	}        
	    
    // 执行命令
    public function run_command() {
                
        $this->_before_run_command();
        
        //执行系列命令
//        $chainobj = ClsFactory::Create('@.Control.Command.CommandChain');
//        $chainobj->addCommand($this->commandobjarr);
//        if(Db::getDbConf('main')) {
//            $chainobj->runCommand();
//        } 
        
        $this->_after_run_command();
        
    }
    
	public function add_command($command = null) {
	    if (empty($command)) {
	        return false;
	    }
	    
	    if (!($command instanceof Command)) {
	        return false;
	    }
	    
	    $this->commandobjarr[] = $command;
	}    
    
    private function _before_run_command() {
        //extend me
    }
    
    private function _after_run_command() {
        //extend me
    }    
    
    public function select_smarty() {
        $this->view->select_smarty();
    }
    
    /**
     * showMessage的基本逻辑处理方法
     * @param  $backurl
     * @param  $params
     * @param  $timeout
     * @param  $msg
     * @param  $tiptype(seccess,error)
     */
    protected function showMessage($backurl = null, $params = array(), $timeout = null, $msg = '', $tpl_name = null, $tiptype = null) {
        $tpl_name = !empty($tpl_name) ? $tpl_name : WEB_ROOT_DIR . "/View/Template/Public/_tips.html";
        if(!empty($backurl)) {
            if(!empty($params) && is_array($params)) {
                foreach($params as $key=>$val) {
                    $backurl .= "/$key/$val";
                }
            }
        }
        
        if(!empty($tiptype)){
            switch ($tiptype){
    			case "success" :
    					$pathImg = IMG_SERVER."/Public/images/success.gif";
    				break;
    			case "error" :
    				$pathImg = IMG_SERVER."/Public/images/error.jpg";
    				break;
    		}
    		$this->assign('pathImg',$pathImg);
        }
        
        $timeout = max(intval($timeout), 0);
        $msg = trim($msg);
        
//        $this->clear_all_assign();
        $this->assign('backurl', $backurl);
        $this->assign('timeout', $timeout);
        $this->assign('msg', $msg);
        
        $this->display($tpl_name);
        exit;        
    }

}
