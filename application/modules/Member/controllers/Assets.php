<?php


class LoginController extends Yaf\Controller_Abstract {

   
    public function indexAction() {
        $this->getView()->assign('page', 'hello');
    }
    
     public function regAction() {
        $this->getView()->assign('page', 'hello');
    }

}
