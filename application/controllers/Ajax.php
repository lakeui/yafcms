<?php

/**
 * 异步处理类
 */ 
class AjaxController extends BaseController{
     
    
    public function init(){
        if(!$this->getRequest()->isXmlHttpRequest()){
            finish(1);
        }
        \Yaf\Dispatcher::getInstance()->autoRender(FALSE);
    }
    
    
    public function getArticleAction() {
        $id =  $this->getRequest()->getPost('id');
        $obj = new ArticleModel();
        $contents = $obj->get([
            'uuid'=>$id
        ],'contents');
        finish(0,'',$contents);
    }




    public function getArticleNumAction(){
        $uuid =  $this->getRequest()->getPost('uuid');
        if(empty($uuid)){
            finish(1,'参数错误');
        }
        $obj = new ArticleModel();
        $row = $obj->get([
            'uuid'=>$uuid
        ], [
            'view_num','cmt_num','good_num','fav_num'
        ]);
        if(empty($row)){
            finish(0,'',[
                'view_num'=>0,
                'cmt_num'=>0,
                'good_num'=>0,
                'fav_num'=>0,
                'code'=>'',
            ]);
        }
        $row['code'] = '';
        finish(0,'',$row);
        
    }

    public function goodAction(){
        $uuid =  $this->getRequest()->getPost('uuid');
        if(empty($uuid)){
            finish(1,'参数错误');
        }
        $obj = new ArticleModel();
        $row = $obj->get([
            'uuid'=>$uuid
        ], [
            'id','good_num'
        ]);
        if(empty($row)){
            finish(1,'操作失败');
        }
        $flag = $obj->update([
            'good_num[+]'=>1
        ], [
            'id'=>$row['id']
        ]);
        if(!empty($flag)){
            finish(0);
        }
        finish(1,'操作失败');
    }
    
   
    
    /**
     * 获取短信验证码
     */
    public function getCodeAction() { 
       
        $request = $this->getRequest();
        $phone = $request->getPost('phone');
        $sn = $request->getPost('sn');
        if(!Tool::isMobile($phone) || !$sn){
            finish(2);
        } 
        $session = \Yaf\Session::getInstance();
        if($sn!=$session->sn){
            finish(1);
        }   
        $log = new LogsModel(); 
        $ip = get_client_ip(1); 
        $session->del('sn');
        if(!$log->checkSendIp($ip)){ //检测IP
            finish(1001);
        } 
        if(!$log->checkSendNum($phone)){ //检测手机是否已经发送
            finish(1001);
        }
        if(!$log->checkLatestTime($phone)){//检测发送时间间隔
            finish(3);
        } 
        //检测手机号是否已经注册
        $user = new UserModel();
        $type = authcode($sn,'DECODE');
        if($type=='forget'){
            if(!$user->checkPhoneExists($phone)){
                finish(1010);
            } 
        }else{
            if($user->checkPhoneExists($phone)){
                finish(1000);
            } 
        } 
        $code = rand(100000,999999);
        $key = md5($phone);
        $session->set($key,$code);
        $res = Sms::send($phone, $code);
        if(empty($res)){
            finish(1002);
        } 
        finish(0);
    }
     
    //注册功能
    public function regAction() {
        $phone =  $this->getRequest()->getPost('phone');
        $code =  $this->getRequest()->getPost('code');
        $passwd =  $this->getRequest()->getPost('passwd');
        $ip = get_client_ip(); 
        if(!Tool::isMobile($phone)){
            finish(1004);
        } 
        if(empty($code) || strlen($code)!=6){
            finish(1003);
        }
        if(empty($passwd) || strlen($passwd)!=32){
            finish(1005);
        }
        $key = md5($phone);
        $session = \Yaf\Session::getInstance();
        $sessionCode = $session->get($key);
        if(empty($sessionCode)){
            finish(1006);
        }
        if($sessionCode!=$code){
            finish(1003);
        }
        //检测手机是否已经注册
        $user = new UserModel();
        if($user->checkPhoneExists($phone)){
            finish(1000);
        }
        $nickname = 'lk'.uniqid();
        $status = !empty($this->setting['cfg_reg_validate'])?$this->setting['cfg_reg_validate']:0;
        $insert_id = $user->insert([
            'phone'=>$phone,
            'user_id'=> md5(uniqid()),
            'passwd'=> authcode($passwd,'ENCODE'),
            'reg_time'=>time(),
            'nickname'=>$nickname,
            'reg_ip'=>$ip,
            'issys'=>0,
            'status'=> $status
        ]);
        if(empty($insert_id)){
            finish(1007);
        }
        //设置登录  
        setLogin([
            'user_id'=>$insert_id,
            'nickname'=>$nickname,
            'phone'=>$phone,
            'face'=>'',
            'status'=>$status
        ]);
        finish(0);
    }
    
    //登录
    public function loginAction() {
        $phone =  $this->getRequest()->getPost('phone');
        $passwd =  $this->getRequest()->getPost('passwd');
        $remember =  $this->getRequest()->getPost('remember',0);
        $sn = $this->getRequest()->getPost('sn');
        $ip = get_client_ip(); 
       
        if(empty($passwd) || strlen($passwd)!=32){
            finish(1005);
        }
        $session = \Yaf\Session::getInstance();
        if($sn!=$session->sn){
            finish(1);
        }  
        $user = new UserModel();
        $row = $user->getUserByPhoneOrNickname($phone);
        if(empty($row)){
            finish(1008);
        }
        if($row['status']==-1 || $row['errnum']>=3){
            if($row['errnum']>3){
                $session->del('sn');
            }
            finish(1009);
        }
        if($passwd!= authcode($row['passwd'],'DECODE')){
            $errnum = $row['errnum']+1;
            $user->updateErrnum($row['id'], $errnum);
            finish(1008);
        }
        
        //更新登录信息
        $res = $user->updateUser($row['id'], [
            'last_login_time'=>time(),
            'last_login_ip'=>$ip,
            'errnum'=>0
        ]);
        if(empty($res)){
            finish(4);
        }
       
        //今日是否存在登录奖励积分
        if(!UserAssetsModel::getInstance()->checkIsPrizeScore($row['user_id'],'login')){
            //奖励积分
            UserAssetsModel::getInstance()->prizeScore('login', $row['user_id'],'登录奖励积分',1);
        }
        
        setLogin([
            'user_id'=>$row['user_id'],
            'nickname'=>$row['nickname'],
            'phone'=>$row['phone'],
            'face'=>$row['face'],
            'status'=>$row['status']
        ],$remember);
        finish(0);
    }
    
     //重制密码
    public function resetAction() {
        $phone =  $this->getRequest()->getPost('phone');
        $code =  $this->getRequest()->getPost('code');
        $passwd =  $this->getRequest()->getPost('passwd');
        $ip = get_client_ip(); 
        if(!Tool::isMobile($phone)){
            finish(1004);
        } 
        if(empty($code) || strlen($code)!=6){
            finish(1003);
        }
        if(empty($passwd) || strlen($passwd)!=32){
            finish(1005);
        }
        $key = md5($phone);
        $session = \Yaf\Session::getInstance();
        $sessionCode = $session->get($key);
        if(empty($sessionCode)){
            finish(1006);
        }
        if($sessionCode!=$code){
            finish(1003);
        }
        //检测手机是否已经注册
        $user = new UserModel();
        $user_id = $user->checkPhoneExists($phone);
        if(empty($user_id)){
            finish(1010);
        }
        $res = $user->updateUser($user_id,[
            'passwd'=> authcode($passwd,'ENCODE'),
        ]);
        if(empty($res)){
            finish(4);
        }
        logout();
        finish(0);
    }
    
    
    //退出
    public function logoutAction() {
        logout();
        finish(0);
    }


    public function feedbackAction(){
        $contact =  $this->getRequest()->getPost('contact');
        $content =  $this->getRequest()->getPost('content');
        if(empty($content) || empty($contact)){
            finish(1,'请输入留言内容');
        }
        $obj = new FeedbackModel();
        $flag = $obj->insert([
            'contact'=>$contact,
            'contents'=>$content,
            'ip'=> get_client_ip(),
            'create_time'=>time(),
            'fm'=>'www'
        ]);
        if(!empty($flag)){
            finish(0);
        } 
        finish(1,'系统繁忙'); 
    }
    
    
    public function linkAction(){
        $contact =  $this->getRequest()->getPost('contact');
        $website =  $this->getRequest()->getPost('website');
        $url =  $this->getRequest()->getPost('url');
        if(empty($contact) || empty($website) || empty($url)){
            finish(1,'请输入申请内容');
        }
        $obj = new LinkModel();
        $flag = $obj->insert([
            'contact'=>$contact,
            'title'=>$website,
            'url'=>$url, 
            'create_time'=>time(), 
        ]);
        if(!empty($flag)){
            finish(0);
        } 
        finish(1,'系统繁忙'); 
    }
    
    
    public function advAction(){
        $key =  $this->getRequest()->get('key');
        if(empty($key)){
            finish(1,'非法广告key');
        }
        $obj = new AdvModel();
        $res = $obj->get($key);
        finish(0,'',$res);
    }
    
    
    
    
    //图片上传
    public function uploadAction() {
        $file =  $this->getRequest()->getFiles('picture');
        if(empty($file)){
            finish(1011);
        }
        $obj = new Upload();
        $res = $obj->uploadOne($file);
        if(empty($res)){
            finish(1012);
        }
        $url = \Yaf\Registry::get('config')->sys->imgurl;
        finish(0,'',[
            'src'=>$url.$res['savename'],
            'key'=>$res['savename']
        ]);
        
        
        
    }
}
