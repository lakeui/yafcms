<?php



class LoginController extends BaseController {

 

    public function indexAction() {
        $backurl = $this->getRequest()->getQuery('backurl','/');
        $session = \Yaf\Session::getInstance();
        $sn = md5(mt_rand());
        $session->sn = $sn; 
        $params = [
            'sn'=>$sn,
            'backurl'=>$backurl,
            'weiboUrl'=>$this->getOpenLoginUrl('weibo'),
            'githubUrl'=>$this->getOpenLoginUrl('github'),
//            'qqUrl'=>$this->getOpenLoginUrl('qq'),
        ];  
        $this->getView()->assign($params);
    }
    
    
    public function forgetAction() { 
        $session = \Yaf\Session::getInstance();
        $sn = authcode('forget','ENCODE');
        $session->sn = $sn; 
        $params = [
            'sn'=>$sn
        ];  
        $this->getView()->assign($params);
    }
    
     public function regAction() { 
        $session = \Yaf\Session::getInstance();
        $sn = md5(mt_rand());
        $session->sn = $sn; 
        $backurl = $this->getRequest()->getQuery('backurl','/');
        $params = [
            'sn'=>$sn,
            'backurl'=>$backurl,
            'weiboUrl'=>$this->getOpenLoginUrl('weibo'),
            'githubUrl'=>$this->getOpenLoginUrl('github'),
        ];  
        
        $this->getView()->assign($params);
    }
    
    
    //第三方登陆处理
    public function openAction() { 
        $session = \Yaf\Session::getInstance(); 
        $res = $session->get('userinfo');
        if(empty($res)){
            $this->redirect('/login.html');
        }
        $arr = [
            'WeChat'=>1,
            'GitHub'=>2,
            'Weibo'=>3,
            'QQ'=>4
        ];
        $type  = $arr[$res['provider']];
    
        if(!empty($this->user_id)){ //只绑定
            //检测是否已经绑定
            $userObj = new UserModel();
            $user_id = $userObj->getUserBindRow([
                'user_id'=>$this->user_id,
                'type'=>$type,
                'openid'=>$res['id']
            ],'user_id');
            if($user_id){ //已经绑定
                $this->redirect('/member/setting/open');
            }
            //开始绑定
            $flag = $userObj->bind([
                'user_id'=>$this->user_id,
                'account'=>$res['nickname'],
                'openid'=>$res['id'],
                'type'=>$type
            ]);
            if(!empty($flag)){
                $this->redirect('/member/setting/open');
            }
            throw new \Yaf\Exception('系统错误，绑定失败');
        } 
        //绑定并且创建用户
        $userObj = new UserModel();
        $user_id = $userObj->getUserBindRow([
            'type'=>$type,
            'openid'=>$res['id']
        ],'user_id'); 
        
        if(!empty($user_id)){
            $row = $userObj->getUserByUserId($user_id);
            $loginInfo = [
                'user_id'=>$user_id,
                'nickname'=>$row['nickname'],
                'phone'=>$row['phone'],
                'face'=>$row['avatar'],
                'status'=>$row['status']
            ];
        }else{
            $user_id = md5(uniqid());
            $ip = get_client_ip(); 
            $status = !empty($this->setting['cfg_reg_validate'])?$this->setting['cfg_reg_validate']:0;
            $flag = $userObj->bindAndCreateUser([
                'user_id'=> $user_id,
                'face'=>$res['avatar'],
                'nickname'=>$res['nickname'],
                'truename'=>$res['name'],
                'email'=>$res['email'],
                'reg_ip'=>$ip,
                'issys'=>0,
                'status'=> $status
            ], [
                'account'=>$res['nickname'],
                'openid'=>$res['id'],
                'type'=>$type
            ]);
            if(empty($flag)){ //绑定失败
                throw new \Yaf\Exception('绑定用户失败，重新授权');
            }
            $loginInfo = [
                'user_id'=>$user_id,
                'nickname'=>$res['nickname'],
                'phone'=>'',
                'face'=>$res['avatar'],
                'status'=>$status
            ];
            $session->del('userinfo');
            Queue::downloadFace([
                'user_id'=>$user_id,
                'face'=>$res['avatar']
            ]);
        } 
        if($res['source']=='bind'){
            $this->redirect('/member/setting/open');
        }
        $f = $this->handleLogin($user_id);
        if(empty($f)){
            throw new \Yaf\Exception('系统错误，重新授权');
        }
        $this->redirect('/');
    }

}
