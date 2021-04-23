<?php
 
/**
 * Description of Ajax
 * @author zhangheng
 */

class AjaxController  extends AuthController  {
     
    
    
    //获取用户数据
    public function getUserDataAction() {
        $user_id = $this->getRequest()->getPost('user_id',0);
        $article_id = $this->getRequest()->getPost('article_id');
        if(empty($user_id) || empty($article_id)){
            finish(2);
        }
        $obj = new UserModel();
        $res = $obj->getUserFollowList([
            'user_id'=> $this->user_id,
            'relate_id'=>[$user_id,$article_id]
        ]);
        $follow = 0;
        $love = 0;
        $fav = 0;
        if(!empty($res)){
            foreach ($res as $vo) {
                if($user_id==$vo['relate_id'] && $vo['type']==1){
                    $follow = 1;
                }
                if($article_id==$vo['relate_id'] && $vo['type']==2){
                    $fav = 1;
                }
                if($article_id==$vo['relate_id'] && $vo['type']==3){
                    $love = 1;
                }
            }
        }
        finish(0,'',[
            'follow'=>$follow,
            'love'=>$love,
            'fav'=>$fav
        ]);
    }



    //关注/取消关注 用户
    public function followAction() {
        $follow_user_id = $this->getRequest()->getPost('id');
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
        $map = [
            'user_id'=> $this->user_id,
            'relate_id'=>$follow_user_id,
            'type'=>1,
            'mode'=>1,
        ];
        $follow_id = $obj->getUserFollowRow($map,'id');

        if($type=='unfollow'){
            if(empty($follow_id)){
                finish(2004);
            }
            //3关注+4记录日志
            $f1 = $obj->unFollow($map,[
                'user_id'=> $this->user_id,
                'create_time'=>time(),
                'operate'=>'取消关注作者:'.$res['nickname'],
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
            $f1 = $obj->addFollow($map,[
                'user_id'=> $this->user_id,
                'create_time'=>time(),
                'operate'=>'关注了作者:'.$res['nickname'],
                'type'=>5,
                'sub_type'=>1,
                'data'=>$follow_user_id
            ]);
            if(empty($f1)){
                finish(4); 
            } 
        } 
        //5 发送私信
        Queue::sendMsg([
            'type'=>1,
            'mode'=>1,
            'cmd'=>$type,
            'user_id'=> $this->user_id,
            'relate_id'=>$follow_user_id
        ]);
        finish(0);
        
    }
    
    
    //收藏/取消收藏 文章
    public function favAction(){
        $uuid =  $this->getRequest()->getPost('id');
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
        $map = [
            'user_id'=> $this->user_id,
            'relate_id'=>$uuid,
            'type'=>2,
            'mode'=>2,
        ];
        $userObj = new UserModel();
        //检测用户是否已经收藏
        $follow_id = $userObj->getUserFollowRow($map,'id');
        if($type=='unfav'){  //取消收藏
            if(empty($follow_id)){
                finish(2006);
            }
            $f1 = $userObj->unFollow($map,[
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
            $f1 = $userObj->addFollow($map,[
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
    
    
    //点赞 /取消
    public function goodAction(){
        $uuid =  $this->getRequest()->getPost('id');
        $type =  $this->getRequest()->getPost('type');
        if(empty($uuid)){
            finish(1,'参数错误');
        }
        $obj = new ArticleModel();
        $row = $obj->get([
            'uuid'=>$uuid
        ], [
            'id','good_num','title'
        ]);
        if(empty($row)){
            finish(3001);
        }
        $map = [
            'user_id'=> $this->user_id,
            'relate_id'=>$uuid,
            'type'=>3,
            'mode'=>2,
        ];
        $userObj = new UserModel();
        $follow_id = $userObj->getUserFollowRow($map,'id');
        if($type=='unlove'){  
            if(empty($follow_id)){
                finish(2008);
            }
            $f1 = $userObj->unFollow($map,[
                'user_id'=> $this->user_id,
                'create_time'=>time(),
                'operate'=>'取消喜欢文章:'.$row['title'],
                'type'=>6,
                'sub_type'=>2,
                'data'=>$uuid
            ]);
            if(empty($f1)){
                finish(4); 
            } 
            $goodNum = $row['good_num']-1;
            $flag = $obj->update([
                'good_num'=>$goodNum
            ], [
                'id'=>$row['id']
            ]);
        }else{ 
            if(!empty($follow_id)){
                finish(2007);
            }
            $f1 = $userObj->addFollow($map,[
                'user_id'=> $this->user_id,
                'create_time'=>time(),
                'operate'=>'喜欢文章:'.$row['title'],
                'type'=>6,
                'sub_type'=>1,
                'data'=>$uuid
            ]);
            if(empty($f1)){
                finish(4); 
            } 
            $goodNum = $row['good_num']+1;
            $flag = $obj->update([
                'good_num'=>$goodNum
            ], [
                'id'=>$row['id']
            ]);
        }  
        if(!empty($flag)){
            finish(0,'',$goodNum);
        }
        finish(1,'操作失败');
    }
    
    
    public function commentListAction() {
        $id =  $this->getRequest()->getPost('id');
        $type = $this->getRequest()->getPost('type');
        $page = $this->getRequest()->getPost('page',1);
        $order = $this->getRequest()->getPost('order',1);
         if(empty($id) || empty($type)){
            finish(2);
        }
        $obj = new \biz\UserBizModel();
        $orderStr = $order==1?'DESC':"ASC";
        list($list,$num) = $obj->getCommentList([
            'relate_id'=>$id,
            'type'=>$type
        ], $orderStr, $page); 
        if(!empty($list)){
            foreach ($list as &$vo) {
                $vo['info'] = $vo['no'].'楼 '.date("Y/m/d H:i",$vo['create_time']);
                $vo['face'] =  showImgStr($vo['face'],1);
            }
        } 
        finish(0,'',[
            'list'=>$list,
            'num'=>$num
        ]);
    }


    public function commentAction() {
        $id =  $this->getRequest()->getPost('id');
        $content =  $this->getRequest()->getPost('content');
        $type = $this->getRequest()->getPost('type');
        if(empty($id) || empty($content) || empty($type)){
            finish(2);
        }
        
        //检测文章是否存在
        $objArticle = new \biz\ArticleBizModel();
        $row = $objArticle->getArticleById($id, [
            'id','title','cmt_num'
        ]);
        if(empty($row)){
            finish(2009);
        }
        $time = time();
       
        $obj = new \biz\UserBizModel();
        
        
        
        list($no,$comment_id) = $obj->comment($id,$type, [
            'cmt_num[+]'=>1
        ], [
            'type'=>$type,
            'relate_id'=>$id,
            'user_id'=> $this->user_id,
            'create_time'=>$time, 
            'content'=>$content,
        ], [
            'user_id'=> $this->user_id,
            'create_time'=>$time,
            'operate'=>'评论文章:'.$row['title'],
            'type'=>3,
            'data'=>$id
        ]);
        if(empty($comment_id)){
            finish(4);
        }
        finish(0,'',[
            'id'=>$comment_id,
            'nickname'=> $this->user['nickname'],
            'face'=> showImgStr($this->user['face'],1),
            'content'=>$content,
            'info'=>$no.'楼 '.date("Y/m/d H:i",$time)
        ]);
    }
    
}
