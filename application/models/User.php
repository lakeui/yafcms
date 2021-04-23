<?php

class UserModel extends BaseModel{

    private $table = 'wt_user';
    private $bind = 'wt_user_bind';
    private $follow = 'wt_user_follow';
    private $log = 'wt_user_logs';
    private $comment = 'wt_comment';
    private $article = 'wt_news';


    //获取用户绑定列表
    public function getUserBindList($user_id) {
        $list = $this->db->select($this->bind,[
            'type','account'
        ],[
            'user_id'=>$user_id
        ]);  
        
        $bind = [];
        if(!empty($list)){
            //绑定类型 1=qq 2=weixin 3=weibo 4=github
            foreach ($list as $vo) {
                $bind[$vo['type']] = $vo;
            }
        }
        return $bind;
        
    }

    
    
    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    
    public function insert($data){
        return $this->db->insert($this->table,$data);
    }

    
    public function countCommentNum($where) {
        return $this->db->count($this->comment,$where);
    }


    public function getCommentList($condition,$field="*",$param ='') {
        if(!empty($param)){
            return $this->db->select("wt_comment(a)",[
                "[>]wt_user(b)" => ["a.user_id" => "user_id"],
            ],[
                'a.id','a.no','a.create_time','a.content','a.good_num',
                'b.face','b.nickname'
            ],[
                'AND'=>[
                    'a.type'=>$param['type'],
                    'a.relate_id'=>$param['id'],
                ],
                "ORDER" => ["a.id" => $param['order']],
                "LIMIT" => [$param['start'],$param['limit']]
            ]); 
        }else{
            return $this->db->select($this->comment,$field,$condition); 
        }
        
    }




    public function commentArticle($id,$updateData,$data,$log){
        $pdo = $this->db->getPdo();
        $pdo->beginTransaction();
        try {
            $f1 = $this->db->insert($this->comment,$data);
            $f2 = $this->db->update($this->article,$updateData,[
                'uuid'=>$id
            ]);
            $f3 = $this->db->insert($this->log,$log);
            if(!empty($f1) && !empty($f2) && !empty($f2)){
                $pdo->commit();
                return $f1;
            }
            $msg = "commentArticle 失败，f1:{$f1},f2:{$f2},f3:{$f3}";
        } catch (\Exception $exc) {
            $msg = $exc->getMessage();
        }
        \Logger::error([
            'data'=>[
                'data'=>$data,
                'log'=>$log,
                'updateData'=>$updateData,
            ],
            'msg'=>$msg
        ]);
        $pdo->rollBack();
        return false;
    }
    
    
    /**
     * 更新用户登录错误次数
     * @param type $user_id
     * @param type $errnum
     * @return type
     */
    public function updateErrnum($user_id,$errnum) {
        return $this->db->update($this->table,[
            'errnum'=>$errnum
        ],[
            'id'=>$user_id
        ]);
    }
    
    /**
     * 更新用户
     * @param type $user_id
     * @param type $data
     * @return type
     */
    public function updateUser($user_id,$data,$field="id") {
        return $this->db->update($this->table,$data,[
            $field=>$user_id
        ]);
    }

    
    public function getUserRow($where,$field="*") {
        return $this->db->get($this->table,$field,$where); 
    }


    /**
     * 根据user_id获取用户信息
     * @param type $user_id
     * @param type $field
     * @return type
     */
    public function getUserByUserId($user_id,$field=[
        'id','user_id','phone','nickname','status','face','errnum','passwd',
        'reg_time','sex','article_num'
    ]) {
        if(empty($user_id)){
            return;
        }
        return $this->db->get($this->table,$field,[
            'user_id'=>$user_id
        ]); 
    }

    /**
     * 根据手机或者昵称查找用户
     * @param type $phone
     * @param type $field
     * @return type
     */
    public function getUserByPhoneOrNickname($phone,$field=[
        'id','user_id','phone','nickname','status','face','errnum','passwd'
    ]) {
        return $this->db->get($this->table,$field,[
            'AND'=>[
                "OR" => [
                    "phone" =>  $phone,
                    "nickname" => $phone
		],
            ]
        ]); 
    }


    /**
     * 检测手机号是否已经注册
     * @param string $phone 手机号
     * @return boolean true：存在 false 不存在
     */
    public function checkPhoneExists($phone){ 
        $rs = $this->db->get($this->table,'id',[
            'phone'=>$phone
        ]); 
        if($rs){
            return $rs;
        }
        return false;
    }
    
    
    public function getUserFollowRow($where,$field='*') {
        return $this->db->get($this->follow,$field,$where); 
    }
    
     public function getUserFollowList($where,$field='*') {
        return $this->db->select($this->follow,$field,$where); 
    }
    
    public function countFollowNum($where) {
        return $this->db->count($this->follow,$where);
    }




    public function addFollow($data,$log) {
        $pdo = $this->db->getPdo();
        $pdo->beginTransaction();
        try {
            $data['create_time'] = time();
            $f1 = $this->db->insert($this->follow,$data);
            $f2 = $this->db->insert($this->log,$log);
            if(!empty($f1) && !empty($f2)){
                 $pdo->commit();
                return true;
            }
            $msg = "addFollow 失败，f1:{$f1},f2:{$f2}";
        } catch (\Exception $exc) {
            $msg = $exc->getMessage();
        }
        \Logger::error([
            'data'=>[
                'data'=>$data,
                'log'=>$log,
            ],
            'msg'=>$msg
        ]);
        $pdo->rollBack();
        return false;
    }
    
    
    public function unFollow($where,$log) {
        $pdo = $this->db->getPdo();
        $pdo->beginTransaction();
        try {
            $f1 = $this->db->delete($this->follow,$where);
            $f2 = $this->db->insert($this->log,$log);
            if(!empty($f1) && !empty($f2)){
                $pdo->commit();
                return true;
            }
            $msg = "unFollow 失败，f1:{$f1},f2:{$f2}";
        } catch (\Exception $exc) {
            $msg = $exc->getMessage();
        }
        \Logger::error([
            'data'=>[
                'data'=>$where,
                'log'=>$log,
            ],
            'msg'=>$msg
        ]);
        $pdo->rollBack();
        return false;
    }
    
    public function logs($data) {
         return $this->db->insert($this->log,$data);
    }
    
    
    public function bind($data) {
        $data['create_time'] = time();
        return $this->db->insert($this->bind,$data);
    }




    public function bindAndCreateUser($user,$bind) {
       $pdo = $this->db->getPdo();
        $pdo->beginTransaction();
        try {
            $user['reg_time'] = time();
            $f1 = $this->db->insert($this->table,$user);
            $bind['create_time'] = time();
            $bind['user_id'] = $user['user_id'];
            $f2 = $this->db->insert($this->bind,$bind);
            if(!empty($f1) && !empty($f2)){
                $pdo->commit();
                return true;
            }
            $msg = "绑定用户失败，f1:{$f1},f2:{$f2}";
        } catch (\Exception $exc) {
            $msg = $exc->getMessage();
        }
        \Logger::error([
            'data'=>[
                'user'=>$user,
                'bind'=>$bind,
            ],
            'msg'=>$msg
        ]);
        $pdo->rollBack();
        return false;
    }
    
    public function getUserBindRow($where,$field="*") {
        return $this->db->get($this->bind,$field,$where); 
    }
     
    
}
