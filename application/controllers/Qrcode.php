<?php

class QrcodeController extends BaseController {

  
    public function init() {
        Yaf\Dispatcher::getInstance()->disableView();
        parent::init();
    }
     
      
    public function indexAction(){
        $uuid = $this->getRequest()->getParam('uuid'); 
        $url = 'http://m.lakeui.com/p/'.$uuid;
        $file = WEB_PATH.'upload/'.$uuid.'.png';
        if(!is_file($file)){
            QRcode::png($url,$file,QR_ECLEVEL_H,8,2);
            $file = makeImg($file);
        } 
        Header("Content-type: image/png");
        echo file_get_contents($file);
        exit;
    }
}
