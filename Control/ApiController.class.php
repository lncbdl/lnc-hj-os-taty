<?php
/**
 * UCenter 控制类
 * @author lnczx
 */

import('ORG.OAuth2.ThinkOAuth2');
abstract class ApiController extends Controller
{
    //用户输入对象
    protected $objInput;

    protected $oauth2 = NULL;
        
    public function __construct() {
        parent::__construct();
    }
    
    public function _initialize(){
    	header("Content-Type:text/html; charset=utf-8");    
        $this->oauth2 = new ThinkOAuth2();   
    }
    
}
