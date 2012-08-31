<?php
/**
 * UCenter 控制类
 * @author lnczx
 */

import('ORG.OAuth2.ThinkOAuth2');
abstract class UcenterController extends Controller
{
    //用户输入对象
    protected $objInput;

    protected $oauth2 = NULL;
        
    public function __construct() {
        parent::__construct();
    }
    
    public function _initialize(){
    	header("Content-Type:text/html; charset=utf-8");
    	//判断用户是否登录    	      
        $this->oauth2 = new ThinkOAuth2();
        
 	    // 执行命令模式
        $this->run_command();
    }
    
}
