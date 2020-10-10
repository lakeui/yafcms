<?php
 
/**
 * Description of Ajax
 * @author zhangheng
 */

class AjaxController  extends AuthController  {
     
    
    //检测用户是否关注
    public function getUserDataAction() {
        $follow_user_id = $this->getRequest()->getPost('user_id');
        
        //是否关注
        $follow = 0;
        $obj = new UserModel();
        if(!empty($follow_user_id)){
            $res = $obj->getUserFollowRow([
                'user_id'=> $this->user_id,
                'follow_user_id'=>$follow_user_id
            ], 'id');
            $follow = !empty($res)?1:0;
        }
       
        finish(0,'',[
            'follow'=>$follow
        ]);
        
    }




    //关注用户
    public function followAction() {
        $follow_user_id = $this->getRequest()->getPost('user_id');
        $type = $this->getRequest()->getPost('type');
        if(empty($follow_user_id)){
            finish(2);
        }
        if($follow_user_id==$this->user_id){
            finish(2003);
        }
        //1检测用户是否存在
        $obj = new UserModel();
        $res = $obj->getUserByUserId($follow_user_id);
        if(empty($res)){
            finish(2001);
        }
        //2检测用户是否已经关注该用户
        $follow_id = $obj->getUserFollowRow([
            'user_id'=> $this->user_id,
            'follow_user_id'=>$follow_user_id,
            'type'=>1
        ],'id');

        if($type=='unfollow'){
            if(empty($follow_id)){
                finish(2004);
            }
            //3关注+4记录日志
            $f1 = $obj->unFollow([
                'user_id'=> $this->user_id,
                'follow_user_id'=>$follow_user_id,
            ],[
                'user_id'=> $this->user_id,
                'create_time'=>time(),
                'operate'=>'取消关注作者'.$res['nickname'],
                'type'=>5,
                'sub_type'=>2,
                'data'=>$follow_user_id
            ]);
            if(empty($f1)){
                finish(4); 
            }  
        }else{ 
            if(!empty($follow_id)){
                finish(2002);
            }

            //3关注+4记录日志
            $f1 = $obj->addFollow([
                'user_id'=> $this->user_id,
                'follow_user_id'=>$follow_user_id,
                'type'=>1,
                'create_time'=>time()
            ],[
                'user_id'=> $this->user_id,
                'create_time'=>time(),
                'operate'=>'关注了作者'.$res['nickname'],
                'type'=>5,
                'sub_type'=>1,
                'data'=>$follow_user_id
            ]);
            if(empty($f1)){
                finish(4); 
            } 
        }
        
        
        //5 发送私信
        //todo
        finish(0);
        
    }
    
    
    
    //收藏
    public function favAction(){
        $uuid =  $this->getRequest()->getPost('uuid');
        $type =  $this->getRequest()->getPost('type');
        
        if(empty($uuid)){
            finish(1,'参数错误');
        }
        
        $obj = new ArticleModel();
        $row = $obj->get([
            'uuid'=>$uuid
        ], [
            'id','fav_num','title'
        ]);
        if(empty($row)){
            finish(3001);
        }
        
        $userObj = new UserModel();
        //检测用户是否已经收藏
        $follow_id = $userObj->getUserFollowRow([
            'user_id'=> $this->user_id,
            'follow_user_id'=>$uuid,
            'type'=>2
        ],'id');
        
        if($type=='unfav'){  //取消收藏
            if(empty($follow_id)){
                finish(2006);
            }
            $f1 = $obj->unFollow([
                'user_id'=> $this->user_id,
                'follow_user_id'=>$uuid,
            ],[
                'user_id'=> $this->user_id,
                'create_time'=>time(),
                'operate'=>'取消收藏:'.$row['title'],
                'type'=>4,
                'sub_type'=>2,
                'data'=>$uuid
            ]);
            if(empty($f1)){
                finish(4); 
            } 
            $favNum = $row['fav_num']-1;
            $flag = $obj->update([
                'fav_num'=>$favNum
            ], [
                'id'=>$row['id']
            ]);
        }else{ //收藏
            if(!empty($follow_id)){
                finish(2005);
            }
            $f1 = $userObj->addFollow([
                'user_id'=> $this->user_id,
                'follow_user_id'=>$uuid,
                'type'=>2,
                'create_time'=>time()
            ],[
                'user_id'=> $this->user_id,
                'create_time'=>time(),
                'operate'=>'收藏文章:'.$row['title'],
                'type'=>4,
                'sub_type'=>1,
                'data'=>$uuid
            ]);
            if(empty($f1)){
                finish(4); 
            } 
            $favNum = $row['fav_num']+1;
            $flag = $obj->update([
                'fav_num'=>$favNum
            ], [
                'id'=>$row['id']
            ]);
        }  
        if(!empty($flag)){
            finish(0,'',$favNum);
        }
        finish(1,'操作失败');
    }
    
    
}
