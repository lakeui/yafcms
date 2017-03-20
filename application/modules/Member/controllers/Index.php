<?php


class IndexController extends Yaf\Controller_Abstract {

    public function indexAction() {
        $this->getView()->assign('page', 'hello');
    }
    
    

}
