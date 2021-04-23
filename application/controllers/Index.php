<?php

class IndexController extends BaseController {

 
    public function indexAction() {    
        $action = $this->theme.'Action';
        return $this->$action();
    }

    
    private function uisdcAction() {   
        $p = $this->getRequest()->getQuery('p',1);
        $size = 10;
         //分类
        $type = $this->pluginTypeList();
         
        //文章
        $objArticle = new ArticleModel();
        $list = $objArticle->selectRelate('index',$p,$size); 
        
        //获取总页数
        $total = $objArticle->count([
            'status'=>1
        ]);
        $maxPage = ceil($total/$size);
        $nextPage = $p+1;
        $prePage = $p-1;
        $nextPage = $nextPage>$maxPage?'':$nextPage;
        $prePage = $prePage<1?'':$prePage;
        $prePageLink = $nextPageLink = '';
        if(!empty($prePage)){
            $url = '/?p='.$prePage;
            if($prePage==1){
                $url ='/';
            }
            $prePageLink = '<a href="'.$url.'"><i class="fa fa-long-arrow-left"></i> 上一页</a>';
        }
        if(!empty($nextPage)){
            $nextPageLink = '<a class="fr" href="/?p='.$nextPage.'">下一页 <i class="fa fa-long-arrow-right"></i></a>';
        }
         
        
        $objSoul = new SoulModel();
        $soul = $objSoul->findRand();
        
      
        //标签
        $objTag = new TagModel();
        $tag = $objTag->select([
            'ORDER'=>['num'=>"DESC"],
            'LIMIT'=>15
        ],['num','tagname']);
        
        //最新加入用户
        $userObj = new UserModel();
        $ulist = $userObj->select([
            'ORDER'=>['reg_time'=>'DESC'],
            'LIMIT'=>12
        ],[
            'id','face','nickname','sex'
        ]);
        
        
        //友链
        $linkObj = new LinkModel();
        $link = $linkObj->select([
            'status'=>1,
            'index'=>1,
            'ORDER'=>['rise'=>'ASC'],
            'LIMIT'=>6
        ],[
            'url','title'
        ]);
        
        $seo = $this->getSeo('index',[],[],$p);  
        
        
        $viewPath = $this->getView()->getScriptPath();
        
        //banner广告
        $banner = $this->getAdv('banner',false);
        
        
        $topArticle = $this->pluginTopRead();
  
        $params = [
            'type'=>$type,
            'list'=>$list,
            'tag'=>$tag,
            'ulist'=>$ulist,
            'link'=>$link, 
            'seo'=>$seo,
            'banner'=>$banner, 
            'topArticle'=>$topArticle,
            'viewPath'=>$viewPath, 
            'prePageLink'=>$prePageLink,
            'nextPageLink'=>$nextPageLink,
            'soul'=>$soul
        ]; 
        $this->getView()->assign($params);
    }
    
    
    
    private function mediaAction() {   
        $p = $this->getRequest()->getQuery('p',1);
        $size = 10;
         //分类
        $type = $this->pluginTypeList();
         
        //文章
        $objArticle = new ArticleModel();
        $list = $objArticle->selectRelate('index',$p,$size); 
        
        //获取总页数
        $total = $objArticle->count([
            'status'=>1
        ]);
        $maxPage = ceil($total/$size);
        $nextPage = $p+1;
        $prePage = $p-1;
        $nextPage = $nextPage>$maxPage?'':$nextPage;
        $prePage = $prePage<1?'':$prePage;
        $prePageLink = $nextPageLink = '';
        if(!empty($prePage)){
            $url = '/?p='.$prePage;
            if($prePage==1){
                $url ='/';
            }
            $prePageLink = '<a href="'.$url.'"><i class="fa fa-long-arrow-left"></i> 上一页</a>';
        }
        if(!empty($nextPage)){
            $nextPageLink = '<a class="fr" href="/?p='.$nextPage.'">下一页 <i class="fa fa-long-arrow-right"></i></a>';
        }
         
        
        $objSoul = new SoulModel();
        $soul = $objSoul->findRand();
        
      
        //标签
        $objTag = new TagModel();
        $tag = $objTag->select([
            'ORDER'=>['num'=>"DESC"],
            'LIMIT'=>15
        ],['num','tagname']);
        
        //最新加入用户
        $userObj = new UserModel();
        $ulist = $userObj->select([
            'ORDER'=>['reg_time'=>'DESC'],
            'LIMIT'=>12
        ],[
            'id','face','nickname','sex'
        ]);
        
        
        //友链
        $linkObj = new LinkModel();
        $link = $linkObj->select([
            'status'=>1,
            'index'=>1,
            'ORDER'=>['rise'=>'ASC'],
            'LIMIT'=>6
        ],[
            'url','title'
        ]);
        
        $seo = $this->getSeo('index',[],[],$p);  
        
        
        $viewPath = $this->getView()->getScriptPath();
        
        //banner广告
        $banner = $this->getAdv('banner',false);
        
        
        $topArticle = $this->pluginTopRead();
  
        $params = [
            'type'=>$type,
            'list'=>$list,
            'tag'=>$tag,
            'ulist'=>$ulist,
            'link'=>$link, 
            'seo'=>$seo,
            'banner'=>$banner, 
            'topArticle'=>$topArticle,
            'viewPath'=>$viewPath, 
            'prePageLink'=>$prePageLink,
            'nextPageLink'=>$nextPageLink,
            'soul'=>$soul
        ]; 
        $this->getView()->assign($params);
    }
    
    
    
    private function defaultAction() {   
         //分类
        $objType = new TypeModel();
        $type = $objType->select([
            'hot'=>1,
            'ORDER'=>['rise'=>'ASC']
        ],[
            'id','url','typename'
        ]);
        
        //文章
        $objArticle = new ArticleModel();
        $list = $objArticle->selectRelate('index',1,8); 
      
      
        //标签
        $objTag = new TagModel();
        $tag = $objTag->select([
            'ORDER'=>['num'=>"DESC"],
            'LIMIT'=>15
        ],'tagname');
        
        //最新加入用户
        $userObj = new UserModel();
        $ulist = $userObj->select([
            'ORDER'=>['reg_time'=>'DESC'],
            'LIMIT'=>12
        ],[
            'id','face','nickname','sex'
        ]);
        
        
        //友链
        $linkObj = new LinkModel();
        $link = $linkObj->select([
            'status'=>1,
            'index'=>1,
            'ORDER'=>['rise'=>'ASC'],
            'LIMIT'=>6
        ],[
            'url','title'
        ]);
        
        $seo = $this->getSeo('index');  
        $adv = $this->getAdv('slideAdv');
        
        $viewPath = $this->getView()->getScriptPath();
        
        //banner广告
        $banner = $this->getAdv('banner',false);
         
        $params = [
            'type'=>$type,
            'list'=>$list,
            'tag'=>$tag,
            'ulist'=>$ulist,
            'link'=>$link,
            'adv'=>$adv,
            'seo'=>$seo,
            'banner'=>$banner,
            'viewPath'=>$viewPath,
            'css'=>'<link rel="stylesheet" href="/'.$this->theme.'/css/slide.css"> ',
            'js'=>'<script src="/'.$this->theme.'/js/swiper.min.js" type="text/javascript"></script><script src="/'.$this->theme.'/js/apple.js" type="text/javascript"></script>'
        ];
        $this->getView()->assign($params);
    }
}
