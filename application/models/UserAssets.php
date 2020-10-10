<?php

class UserAssetsModel extends BaseModel{

    private $table = 'wt_user_assets';
    private $logs = 'wt_user_assets_logs';
    
    private $score_item = 'wt_score_item';
    
    
    
     
    private static $instance=null;


    public static function getInstance() {
        if(is_null(self::$instance)){
            self::$instance = new UserAssetsModel();
        }
        return self::$instance;
    }


    /**
     * 获取积分规则奖励积分数量
     * @param type $flag
     * @return type
     */
    public function getScoreItemByFlag($flag,$field='score') {
        return $this->db->get($this->score_item,$field,[
            'flag'=>$flag,
            'status'=>1
        ]);
    }

    /**
     * 积分奖励/消费
     * @param type $flag
     * @param type $user_id
     * @param type $title
     * @param type $action
     * @return boolean
     */
    public function prizeScore($flag,$user_id,$title,$action) {
        $score = $this->getScoreItemByFlag($flag);
        if(empty($score) || empty($user_id)){
            return;
        }
        $score = authcode($score,'DECODE');
        $res = $this->getUserAssets($user_id,['user_id','score_key']);
        if(empty($res)){
            $user_score = 0;
            $insert = true;
        }else{
            $insert = false;
            $user_score = intval(authcode($res['score_key'],'DECODE'));
        }
        if($action==1){
            $after_score = $user_score+$score;
        }elseif($action==2){
            if($score>$user_score){
                finish(3000);
            }
            $after_score = $user_score-$score;
        }  
        $pdo = $this->db->getPdo();
        $pdo->beginTransaction();
        // 1.更新用户积分
        try {
            if($insert){
                $f1 = $this->insertAssets([
                    'score_key'=> authcode($after_score,'ENCODE'),
                    'score'=> $after_score,
                    'user_id'=>$user_id,
                ]); 
            }else{
                $f1 = $this->updateAssets([
                    'score_key'=> authcode($after_score,'ENCODE'),
                    'score'=>$after_score
                ], [
                    'user_id'=>$user_id
                ]); 
            }
            // 2.记录日志
            $f2 = $this->insertAssetsLogs([
                'user_id'=>$user_id,
                'type'=>1,
                'action'=>$action,
                'flag'=>$flag,
                'title'=>$title,
                'create_time'=>time(),
                'num_key'=> authcode($score,'ENCODE'),
                'before_num_key'=> authcode($user_score,'ENCODE'),
                'after_num_key'=> authcode($after_score,'ENCODE'),
                'num'=> $score,
                'before_num'=> $user_score,
                'after_num'=> $after_score,
                'ip'=> get_client_ip(),
                'status'=>1
            ]);
            if($f1 && $f2){
                $pdo->commit();
                return true;
            }
            $msg = "积分处理错误f1:{$f1},f2:{$f2}";
        } catch (\Exception $exc) {
            $msg = $exc->getMessage();
        }
        \Logger::error([
            'data'=>[
                'user_id'=>$user_id,
                'score'=>$score,
                'action'=>$action
            ],
            'msg'=>$msg
        ]);
        $pdo->rollBack();
        return false;
    }

    
    
    /**
     * 获取用户最近三个月积分分类排行
     * @param type $user_id
     */
    public function getTreeMonthScoreRank($user_id) {
        $etime = time();
        $stime = strtotime('-3 month');
        $sql = "select flag,sum(num) as snum from {$this->logs} where create_time>={$stime} and create_time<={$etime} and user_id='{$user_id}' group by flag order by snum desc; ";
        $res = $this->db->query($sql);
        if(empty($res)){
            return;
        }
        $list = $res->fetchAll(PDO::FETCH_ASSOC);
        foreach ($list as $key=>&$vo) {
            if($key>3){
                break;
            }
            $name = $this->getScoreItemByFlag($vo['flag'],'name');
            $vo['name'] = $name;
             
        }
        return $list;
    }

    
    


    /**
     * 获取用户资产
     * @param type $user_id
     * @return type
     */
    public function getUserAssets($user_id,$field="*") {
        return $this->db->get($this->table,$field,[
            'user_id'=>$user_id
        ]); 
    }

    
   /**
    * 获取用户资产日志记录列表
    * @param type $user_id
    * @param type $type
    * @param type $p 分页
    * @param type $size
    * @param type $field
    * @return type
    */
    public function getUserAssetsLogsList($user_id,$type,$p=1,$size=10,$field='*') {
        $start = ($p-1)*$size;
        return $this->db->select($this->logs,$field,[
            'AND'=>[
                'user_id'=>$user_id,
                'type'=>$type
            ],
            'ORDER'=>['id'=>'DESC'],
            'LIMIT'=>[$start,$size]
        ]); 
    }
    
    
    //坚持今日是否存在
    public function checkIsPrizeScore($user_id,$flag) {
        $today = date("Y-m-d");
        $stime = strtotime($today." 00:00:00");
        $etime = strtotime($today." 23:59:59");
        return $this->db->get($this->logs,'id',[
            'user_id'=>$user_id,
            'flag'=>$flag,
            'create_time[<>]'=>[$stime,$etime]
        ]);
    }




    /**
     * 统计数量
     * @param type $user_id
     * @param type $type
     * @return type
     */
    public function countUserAssetsLogs($user_id,$type) {
         return $this->db->count($this->logs,[
            'AND'=>[
                'user_id'=>$user_id,
                'type'=>$type
            ]
        ]); 
    }

  
    
    public function insertAssetsLogs($data) {
        return $this->db->insert($this->logs,$data);
    }

    public function updateAssets($data,$where) {
        return $this->db->update($this->table,$data,$where);
    }
    
    public function insertAssets($data) {
        return $this->db->insert($this->table,$data);
    }
    
}
