<?php

/**
 * 用户biz 
 * @author zhangheng
 */
namespace biz;
use UserModel;

class UserBizModel {
    
    
    protected $handle ;
    
    public function __construct() {
        if(empty($this->handle)){
            $this->handle = new UserModel(); 
        }
    }

    /**
     * 获取用户信息
     * @param type $user_id
     * @param type $field
     * @return type
     */
    public function getUserByUserId($user_id,$field=[
        'id','user_id','phone','nickname','status','face','errnum','passwd',
        'reg_time','sex','article_num','url'
    ]) {
        if(empty($user_id)){
            return;
        }
        return $this->handle->getUserRow([
            'user_id'=>$user_id
        ],$field); 
    }

    
    

    public function countFollow($map) {
        return $this->handle->countFollowNum($map);
    }

    /** 
     * 获取follow 列表
     * @param type $param
     */
    public function getFollowList($map,$page=1,$size=10) {
        $where = [
            'ORDER'=>[
                'id'=>'DESC'
            ]
        ];
        if(!empty($map)){
            $where['AND'] = $map;
        }
        if(!empty($size)){
            $start = ($page-1)*$size;
            $where['LIMIT'] = [$start,$size];
        }
        return $this->handle->getUserFollowList($where);
    }
    
    
    public function comment($id,$type,$updateData,$data,$log) {
        //获取楼层
        $no = 1;
        $res = $this->handle->getCommentList([
            'ORDER'=>['no'=>'DESC'],
            'AND'=>[
                'user_id'=>$data['user_id'],
                'relate_id'=>$data['relate_id'],
                'type'=>$data['type']
            ],
            'LIMIT'=>[0,1]
        ],'no');
        if(!empty($res)){
            $no = $res[0]+1;
        }
        $data['no'] = $no;
        if($type==1){ //文章
            $commend_id = $this->handle->commentArticle($id,$updateData,$data,$log);
        }
        
        
        return [$no,$commend_id];
    }
     
    
    public function getCommentList($map,$order='DESC',$page=1,$limit=10, $field="*") {
        $start = ($page-1)*$limit;
        $condition = [
            'AND'=>$map,
            'LIMIT'=>[$start,$limit],
            'ORDER'=>['id'=>$order]
        ];
        $num = $this->handle->countCommentNum($map);
        $list = $this->handle->getCommentList($condition, $field,[
            'type'=>$map['type'],
            'id'=>$map['relate_id'],
            'start'=>$start,
            'limit'=>$limit,
            'order'=>$order
        ]);
        return [$list,$num];
    }
}
