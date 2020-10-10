<?php
 
namespace Upload;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
class Qiniu {

    protected $token = ''; 
    protected $type = 1;




    public function __construct($config) {
        $auth = new Auth($config['qiniu']['ak'], $config['qiniu']['sk']); 
        if($config['qiniu']['callback']){ 
            $this->type = 2;
            $policy = array(
//                'callbackUrl' => $config['qiniu']['callback'],
//                'callbackBody' => 'key=$(key)&hash=$(etag)&filesize=$(fsize)&type=$(imageInfo.format)&height=$(imageInfo.height)&width=$(imageInfo.width)'
            ); 
            $this->token = $auth->uploadToken($config['qiniu']['bucket'],null,3600,$policy); 
        }else{
            $this->token = $auth->uploadToken($config['qiniu']['bucket']); 
        }
        
        
    }

    public function save($file,$replace=true) { 
        $filename = $file['savename']; 
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($this->token, $filename, $file['tmp_name']);
        if ($err !== null) { 
            $this->setError($err);
            return false;
        }  
        if($this->type==2){
            return $ret['data'];
        }else{
            return $ret['key'];
        } 
    }

}
