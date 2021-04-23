<?php
use Overtrue\Socialite\SocialiteManager;
/**
 * 第三方登陆回调处理
 */
class LoginController extends BaseController{

    
    public function init() {
        parent::init();
        \Yaf\Dispatcher::getInstance()->autoRender(FALSE); //禁用模版
    }
 
    
    public function callbackAction() {
        $type = $this->getRequest()->getQuery('type');
        try {
            $config = \Yaf\Registry::get('config')->socialite->toArray(); 
            $socialite = new SocialiteManager($config);
            $user = $socialite->driver($type)->user();
            if(empty($user)){
                exit('获取用户失败');
            }
            $session = \Yaf\Session::getInstance(); 
            $session->set('userinfo',[
                'id'=>$user->getId(),
                'nickname'=>$user->getNickname(),
                'name'=>$user->getName(),
                'email'=>$user->getEmail(),
                'avatar'=>$user->getAvatar(), 
                'provider'=>$user->getProviderName(),
            ]); 
            $this->redirect('/member/login/open');
        } catch (\Exception $exc) {
             exit($exc->getTraceAsString());
        }
    }
     
    

}
