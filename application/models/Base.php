<?php 
/**
 * 基类
 * @author zhangheng
 */
class BaseModel {
    
    protected $db = null;
    protected $redis = null;


    public function __construct() {
        if(is_null($this->db)){
            $this->db = $obj = new Db();
        }
    }
           
    
    public function initRedis(){
        if(is_null($this->redis)){
            $config = \Yaf\Registry::get('config')->redis->toArray(); 
            $this->redis = new \Redis();
            $this->redis->connect($config['host']?:'127.0.0.1', $config['port']?:6379);
            if($config['auth']){
                $this->redis->auth($config['auth']);
            }
        }
        return $this->redis;
    }
             
    
    
}
