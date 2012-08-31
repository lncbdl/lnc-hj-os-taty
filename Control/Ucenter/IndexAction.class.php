<?php
/**
 * UCenter 统一登录类
 * @author    lnczx <lnczx0915@gmail.com>
 */

class IndexAction extends Controller{

    protected $oauth2 = NULL;
    
    public function _initialize(){
    	header("Content-Type:text/html; charset=utf-8");
    }     
    
    public function index(){
          //todo 根据不同系统展现不同登录页面风格
//        $callback = $this->objInput->getStr('callback');
//        if (empty($callback)) {
//            $domain = 'wmw';  //default type;
//        } else {
//            $domain = $this->get_domain($callback);
//        }
//        print_r($domain);
//        if (empty($domain)) {
//            $domain = 'wmw';
//        }
//        
//        // 此方法为根据不同域名采用不同登录风格的方式
//        // 将 login.wmw.cn.html 转换为 login_wmw_cn.html,不然会提示模板不存在
//        $template = 'login.' . $domain;
//        $template = str_replace('.', '_', $template);
        
        $this->display('login');  
    }
    
}
?>
