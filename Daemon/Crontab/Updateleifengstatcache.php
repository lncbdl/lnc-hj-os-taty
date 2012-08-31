<?php
header("Content-Type:text/html;charset=utf-8");
if(!defined('DAEMON_ROOT')) {
    define('DAEMON_ROOT', realpath(dirname(__FILE__) . "/../"));
}
include_once DAEMON_ROOT . "/Daemon.inc.php";

class UpdateleifengstatcacheAction extends Controller {
    protected $need_stat_sub_provincelist = array(
        '浙江省',
    );
    
    public function exec() {
        $mLeifeng = ClsFactory::Create('Model.mLeifeng');
        $stat_xxlf_datas = $mLeifeng->statCsUserByProvince($this->need_stat_sub_provincelist);
        if(!empty($stat_xxlf_datas)) {
            //获取缓存表中存在的记录信息
            $ids = array_keys($stat_xxlf_datas);
            $cachelist = $mLeifeng->getLeifengStatecacheById($ids);
            
            foreach($stat_xxlf_datas as $list) {
                foreach($list as $datas) {
                    $id = $datas['id'];
                    //暂时将参赛人数初始化为参加学习雷锋的人数
                    $datas['csrs'] = $datas['xxlf'];
                    if(!isset($cachelist[$id])) {
                        $mLeifeng->addLeifengStatcache($datas);
                    } else {
                        unset($datas['id']);
                        $mLeifeng->modifyLeifengStatecache($datas, $id);
                    }
                }
            }
        }
    }
}

$updateCache = new UpdateleifengstatcacheAction();
$updateCache->exec();
?>