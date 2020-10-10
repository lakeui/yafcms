<?php
/**
 * 手机验证码发送日志
 */
class LogsModel extends BaseModel {

    const SEND_MAX_TIMES = 1;
    private $table = 'wt_send_log';


    /**
     * 检测发送验证码次数
     * @param type $phone
     * @return boolean true 还可以发送 false 不可以发送
     */
    public function checkSendNum($phone){  
        $times = Tool::getTimes('today'); 
        $list = $this->db->select($this->table,['id'],[
            'AND'=>[
                'phone'=>$phone,
                'add_time[>=]'=>$times['s'],
                'add_time[<=]'=>$times['e'],
            ]
        ]); 
        dump($list);
        if($list && count($list)>=self::SEND_MAX_TIMES){
            return false;
        }  
        return true;
    }
    
    /**
     * 检测同IP发送次数
     * @param int $ip ip地址
     * @return boolean
     */
    public function checkSendIp($ip){ 
        $times = Tool::getTimes('today'); 
        $list = $this->db->select($this->table,['id'],[
            'AND'=>[
                'ip'=>$ip,
                'add_time[>=]'=>$times['s'],
                'add_time[<=]'=>$times['e'],
            ]
        ]); 
        if($list && count($list)>=self::SEND_MAX_TIMES){  //同一IP每天只能获取2次验证码
            return false;
        }  
        return true;
    }
    
    /**
     * 检测手机发送的最后一次时间
     */
    public function checkLatestTime($phone){ 
        $rs = $this->db->select($this->table, "add_time", [ 
            'phone'=>$phone,
            "ORDER" =>[
                "add_time" => "DESC"
            ],
            "LIMIT" => 1 
        ]);
        if($rs && (time()-$rs[0])<=60){ //2次发送时间间隔小于60秒
            return false;
        }
        return true; 
    }
    
    
}
