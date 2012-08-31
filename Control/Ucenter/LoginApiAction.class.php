<?php
/**
 * UCenter 统一登录类
 * @author    lnczx <lnczx0915@gmail.com>
 */

class LoginApiAction extends UcenterController{

    public function index() {
        
    }
    
    /*
     *  统计登录验证接口，仅接受post方法,且通常为json方式调用
     *  必须参数:
     *      username
     *      password : 仅接受md5后的password;
     *      callback
     *      
     *  json格式，参考ThinkOAuth2.php function createAccessTokenWithUserName
     *    $token = array(
          "client_id"    => $client_id,
          "username"	 => $username,
          "access_token" => $this->genAccessToken(),
          "expires_in"	 => $this->getVariable('access_token_lifetime', OAUTH2_DEFAULT_ACCESS_TOKEN_LIFETIME),
          "scope"		 => $scope
        );   
     */
    
    public function login() {
	    //todo 1. 根据callback 获取域名验证是否来源于信任的域名
        
        
	    $client_account = $this->convertClientAccount($this->objInput->postStr('username'));
	    $login_password = $this->objInput->postStr('password');
	    
        $client_id = $this->objInput->postStr('client_id');
        $client_secret = $this->objInput->postStr('client_secret');
        
        // todo 做client_id 的有效性验证，可调用ThinkOAuth2.class.php checkClientCredentials 方法
        // todo 需要考虑跨域访问，如果不是有效性的客户端，如何操作	    

	    
	    // first param validate
	    if (empty($client_account) || empty($login_password)) {
	        $this->returnJson(0, '用户名不能为空');
	        $this->ajaxReturn(null, '用户名不能为空', 0, 'json');
	    }
	    
    	if (empty($login_password)) {
	        $this->ajaxReturn(null, '密码不能为空', 0, 'json');
	    }	 

	    //todo 2. 用户名长度的校验
	    
        //验证用户名及密码
        $mUser=ClsFactory::Create('Model.mUser');
        $userInfo = $mUser->getUserByUid($client_account);

        if (!empty($userInfo)) {
            
            if ($userInfo[$client_account]['client_password'] != $login_password) { 
                $this->ajaxReturn(null, '用户名密码错误', 0, 'json');     
            }
        } else {
            $this->ajaxReturn(null, '该用户不存在', 0, 'json');     
        }
        
        
        //todo 3. 用户的冻结状态
        
        //用户信息验证正确
        
        //todo 更新用户状态，可采用异步机制
//        $mUser->userOnline($client_account);
        
        //用户token, 格式看本函数注释
        $json = $this->oauth2->grantAccessToken();
//        $this->ajaxReturn(null, '登录成功', 1, 'json');
        if (empty($json)) {
            $this->ajaxReturn(null, '登录失败', 0, 'json');     
        }
        
        $oauth_data = json_decode($json, true);
        $user_token = token_encode($oauth_data);
        
        $expires_in = isset($oauth_data['expires_in']) ? ($oauth_data['expires_in']) :  3600;
        $expires = time() + $expires_in;
        
        // 生成统一认证完毕后的cookies
        $domain = C('COOKIEDOMAIN');
        
        if (empty($domain)) {
            $domain = '.wm616.cn';
        }
        
        // 设置登录cookie
        header("P3P: CP=CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR");
        header(getCookieStr(SESSION_TOKEN, $user_token, $expires, "/", $domain));
        
        $this->ajaxReturn(null, '登录成功', 1, 'json');
    }
    
    /*
     *  统一获取cookies接口，仅接受get方法,且通常为jsonp方式调用
     *  必须参数:
     *      $client_id : oauth2分配的client_id
     *  可选参数:
     *      $client_secret : oauth2分配的client_secret
     */    
    
    public function getCookie() {
//        $client_id = $this->convertClientAccount($this->objInput->getStr('client_id'));
//        $client_secret = $this->convertClientAccount($this->objInput->getStr('client_secret'));
//        
        // todo 做client_id 的有效性验证，可调用ThinkOAuth2.class.php checkClientCredentials 方法
        // todo 需要考虑跨域访问，如果不是有效性的客户端，如何操作// 返回错误代码
        
        
        // 获取cookie
        $callback = $this->objInput->getStr('callback');
        
        $token = $_COOKIE[SESSION_TOKEN];
        header("P3P: CP=CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR");
        $isLogined = false;
        if (!empty($token)) {
            $isLogined = true;
        }    
        
        // todo 规范返回方式
        $result = array(
            'status'	=>1,
            'info'		=>'',
            'data'		=> $token,
            'login'		=> $isLogined,
        );
        
        echo $callback. '(' . json_encode($result) . ')';
    }
    
    //转换成真实的client_account
    private function convertClientAccount($login_account) {
        $flag = false;
        $mark = preg_match('/^1[1-9]{1}[0-9]{9}/', $login_account);

        if ($mark) {
            $Businessphone = ClsFactory::Create ( 'Model.mBusinessphone' );
            $phoneinfo_uid = $Businessphone->getbusinessphonebyalias_id($login_account);
            if (!empty($phoneinfo_uid)) {
                $phone_status = $phoneinfo_uid[$login_account]['phone_status'];
                $client_account = $phoneinfo_uid[$login_account]['uid'];
                $mUser = ClsFactory::Create('Model.mUser');
                $userinfo = $mUser->getUserByUid($client_account);
                $school_info = $userinfo[$client_account]['school_info'];
                $schoolinfo = array_values($school_info);
                $operation_strategy = $schoolinfo[0]['operation_strategy'];
                if ($phoneinfo_uid[$login_account]['business_enable'] == 1) {
                    $flag = true;
                }
            }
        }
        return $flag ? $client_account : $login_account;
    }    
    
}
?>
