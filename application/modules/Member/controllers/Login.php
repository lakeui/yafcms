<?php


class LoginController extends BaseController {

   
    public function indexAction() {
        $backurl = $this->getRequest()->getQuery('backurl','/');
        $session = \Yaf\Session::getInstance();
        $sn = md5(mt_rand());
        $session->sn = $sn; 
        $params = [
            'sn'=>$sn,
            'backurl'=>$backurl
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
        
        $params = [
            'sn'=>$sn
        ];  
        
        $this->getView()->assign($params);
    }

}
