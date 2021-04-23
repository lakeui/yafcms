<?php


class ContentsController extends AuthController {
    
   
    //文章列表
    public function articleAction() {
        $css = load('member', 'css');
        $params = [  
            'seo'=>[
                'seo_title'=>'我的文章'
            ],
            'css'=>$css,
            'hideFooter'=>true,
            'leftMenu'=> $this->leftMenu
        ];
        $this->getView()->assign($params);
    }
    
    //评论列表
    public function commentsAction() {
        $css = load('member', 'css');
        $params = [  
            'seo'=>[
                'seo_title'=>'我的评论'
            ],
            'css'=>$css,
            'hideFooter'=>true,
            'leftMenu'=> $this->leftMenu
        ];
        $this->getView()->assign($params);
    }
    
    //关注列表
    public function followAction() {
        $page = $this->getRequest()->getQuery('page','1');
        $limit = $this->getRequest()->getQuery('limit',10);
        $css = load('member', 'css');
        
        $map = [
            'type'=>1,
            'mode'=>1,
            'user_id'=> $this->user_id
        ]; 
        
        $obj = new \biz\UserBizModel();
        $list = $obj->getFollowList($map, $page,$limit);
        if(!empty($list)){
            foreach ($list as &$vo) {
                //获取用户信息
                $user = $obj->getUserByUserId($vo['relate_id']);
                $vo['user'] = $user;
            }
        } 
        
        $num = $obj->countFollow($map);
        $params = [  
            'seo'=>[
                'seo_title'=>'我关注的作者'
            ],
            'list'=>$list,
            'css'=>$css,
            'hideFooter'=>true,
            'num'=>$num,
            'leftMenu'=> $this->leftMenu
        ];
        $this->getView()->assign($params);
    }
    
    //我收藏的文章
    public function favAction() {
        $page = $this->getRequest()->getQuery('page','1');
        $limit = $this->getRequest()->getQuery('limit',10);
        $css = load('member', 'css');
        $map = [
            'type'=>2,
            'mode'=>2,
            'user_id'=> $this->user_id
        ]; 
        $objArticle = new \biz\ArticleBizModel();
        $obj = new \biz\UserBizModel();
        $list = $obj->getFollowList($map, $page,$limit);
        if(!empty($list)){
            foreach ($list as &$vo) {
                //获取文章信息
                $vo['title'] = $objArticle->getArticleById($vo['relate_id'],'title');
            }
        } 
        $num = $obj->countFollow($map);
        $params = [  
            'seo'=>[
                'seo_title'=>'我收藏的文章'
            ],
            'css'=>$css,
            'num'=>$num,
            'list'=>$list,
            'hideFooter'=>true,
            'leftMenu'=> $this->leftMenu
        ];
        $this->getView()->assign($params);
    }
    
    
    //我喜欢的文章
    public function loveAction() {
        $page = $this->getRequest()->getQuery('page','1');
        $limit = $this->getRequest()->getQuery('limit',10);
        $css = load('member', 'css');
        $map = [
            'type'=>3,
            'mode'=>2,
            'user_id'=> $this->user_id
        ]; 
        $objArticle = new \biz\ArticleBizModel();
        $obj = new \biz\UserBizModel();
        $list = $obj->getFollowList($map, $page,$limit);
        if(!empty($list)){
            foreach ($list as &$vo) {
                //获取文章信息
                $vo['title'] = $objArticle->getArticleById($vo['relate_id'],'title');
            }
        } 
        $num = $obj->countFollow($map);
        $params = [  
            'seo'=>[
                'seo_title'=>'我喜欢的文章'
            ],
            'css'=>$css,
            'num'=>$num,
            'list'=>$list,
            'hideFooter'=>true,
            'leftMenu'=> $this->leftMenu
        ];
        $this->getView()->assign($params);
    }
    
    
    

    //更新资料
    public function saveAction() {
        $this->isAjax();
        $post =  $this->getRequest()->getPost();
        $cmd =  $this->getRequest()->getPost('cmd');
        $obj = new UserModel();
        if($cmd=='profile'){ //个人资料
            $data = buildDatabaseData($post, [
                'face','nickname','sex','fck'
            ]);
            $res = $obj->updateUser($this->user['user_id'], $data);
        }elseif($cmd=='passwd'){ //修改密码
            if(empty($post['oldpasswd']) || empty($post['newpasswd']) 
                    || $post['newpasswd']!=$post['cfmpasswd']){
                finish(1013);
            }
            $obj = new UserModel();
            $str = $obj->getUserByUserId($this->user['user_id'], 'passwd');
            if(authcode($str,'DECODE')!= md5($post['oldpasswd'])){
                finish(1014);
            }
            $res = $obj->updateUser($this->user['user_id'], [
                'passwd'=> authcode(md5($post['newpasswd']),'ENCODE')
            ]);
            if($res){
                logout();
            }
        }elseif($cmd=='home'){  //主页设置
            $data = buildDatabaseData($post, [
                'home','qrcode','shortdesc'
            ]);
            $res = $obj->updateUser($this->user['user_id'], $data);
        }
        if(empty($res)){
            finish(4);
        }
        finish(0);
    }
     

}
