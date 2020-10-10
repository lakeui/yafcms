<?php

/**
 * 短信接口 
 * @author zhangheng
 */
class Sms {
   
    
    private static $config = [
        'SignName'=>'细仔博客',
        'TemplateCode'=>'SMS_56570394',
        'AccessKeyId'=>'LTAIcQqQ7PGFI9w3',
        'Secret'=>'fgc4e8bpkxA35AeCUCWFEn3reqhKph'
    ];
    
    private $signName = '细仔博客';
    private $templateCode = 'SMS_56570394';
    private $recNum;
    private $paramString;
    
    
    
    public static function send($phone,$code){ 
        $url = 'https://sms.aliyuncs.com/';
        $param = [
            'Action'=>'SingleSendSms',
            'SignName'=>  self::$config['SignName'],
            'TemplateCode'=> self::$config['TemplateCode'],
            'RecNum'=>$phone,
            'ParamString'=>'{"code":"'.$code.'"}',
            'Format'=>'JSON',
            'Version'=>"2016-09-27",
            
            'AccessKeyId'=>  self::$config['AccessKeyId'], 
            'Timestamp'=>date("YYYY-MM-DDThh:mm:ssZ"),
            'SignatureNonce'=>'',
            'SignatureVersion'=>'1.0',
            
        ];  
        $param['SignatureMethod'] = 'HMAC-SHA1';
   
        
                
    }
    
}
