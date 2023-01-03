<?php

/**
 * 短信接口 
 * @author zhangheng
 */

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;


class Sms {
   
    
    private static $config = [
        'SignName'=>'XXX',
        'TemplateCode'=>'XXX',
        'AccessKeyId'=>'XXX',
        'Secret'=>'xxxx'
    ];
    
 
    
    public function __construct($param=[]) {
        
    }
  
    
    public static function send($phone,$code){ 
        AlibabaCloud::accessKeyClient(self::$config['AccessKeyId'], self::$config['Secret'])
            ->regionId('cn-hangzhou')
            ->asDefaultClient();
        try {
             $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => $phone,
                        'SignName' => self::$config['SignName'],
                        'TemplateCode' => self::$config['TemplateCode'],
                        'TemplateParam' => '{"code":"'.$code.'"}',
                    ],
                ])->request();
            $res = $result->toArray();
            if($res['Code']=='OK'){
                finish(0); 
            }
            $msg = $res['Message'];
        } catch (ClientException $e) {
           $msg = $e->getErrorMessage();
        } catch (ServerException $e) {
            $msg = $e->getErrorMessage();
        }
        finish(10,$msg);
    }
    
}
