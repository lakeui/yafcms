<?php

class UserModel extends BaseModel{

    private $table = 'wt_user';
    private $bind = 'wt_user_bind';
    private $follow = 'wt_user_follow';
    private $log = 'wt_user_logs';


    //获取用户绑定列表
    public function getUserBindList($user_id) {
        $list = $this->db->select($this->bind,[
            'type','account'
        ],[
            'user_id'=>$user_id
        ]); 
        $data = [
            1=>[
                'title'=>'绑定微信',
                'icon'=>'weixin',
                'isbind'=>0,
                'url'=>''
            ],
            2=>[
                'title'=>'绑定Github',
                'icon'=>'github',
                'isbind'=>0,
                'url'=>''
            ],
            3=>[
                'title'=>'绑定微博',
                'icon'=>'weibo',
                'isbind'=>0,
                'url'=>''
            ],
            4=>[
                'title'=>'绑定QQ',
                'icon'=>'qq',
                'isbind'=>0,
                'url'=>''
            ]
        ];
        
        $bind = [];
        if(!empty($list)){
            //绑定类型 1=qq 2=weixin 3=weibo 4=github
            foreach ($list as $vo) {
                $bind[$vo['type']] = 1;
            }
        }
        $html = '';
        foreach ($data as $key => $vo) {
            if(!empty($bind[$key])){
                $html.="<li id='{$vo['icon']}' class='{$vo['icon']}-item binded'><a  href='javascript:'><i class='fa fa-{$vo['icon']}'></i><br/>
	 		已绑定 {$vo['account']}
	 		</a></li>";
            }else{
                $html.="<li id='{$vo['icon']}' class='{$vo['icon']}-item'><a target='_blank' href='{$vo['url']}'><i class='fa fa-{$vo['icon']}'></i><br/>
	 		{$vo['title']}
	 		</a></li>";
            }
            
        }
        return $html;
    }

    
    
    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    
    public function insert($data){
        return $this->db->insert($this->table,$data);
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
    public function updateUser($user_id,$data) {
        return $this->db->update($this->table,$data,[
            'id'=>$user_id
        ]);
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
    
    
    public function addFollow($data,$log) {
        $pdo = $this->db->getPdo();
        $pdo->beginTransaction();
        try {
            $f1 = $this->db->insert($this->follow,$data);
            $f2 = $this->db->insert($this->log,$log);
            if(!empty($f1) && !empty($f2)){
                 $pdo->commit();
                return true;
            }
            $msg = "关注用户失败，f1:{$f1},f2:{$f2}";
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
            $msg = "取消关注失败，f1:{$f1},f2:{$f2}";
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
    
}
