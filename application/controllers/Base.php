<?php

class BaseController extends Yaf\Controller_Abstract {
    
    protected $theme = '';
    protected $isMobile = false;
    protected $setting;
    protected $user;
    protected $user_id;


    public function init(){
        $this->isMobile = isMobile();
        $currUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $this->theme = \Yaf\Registry::get('config')->theme; 
        $loginUrl =  \Yaf\Registry::get('config')->ucenter.'login?backurl='. urlencode($currUrl); 
        $regUrl =  \Yaf\Registry::get('config')->ucenter.'reg?backurl='. urlencode($currUrl);
        if(!empty($this->isMobile)){
            $this->theme = 'mobile';
        }
        $this->setViewPath(APP_PATH."/application/views/".$this->theme);
        $menu = $this->getMenu();
        $fmenu = $this->getPage();
        $this->setting = $this->getConfig();
        
        $notice = $this->getNotice();
        $loginUrl = '/login.html';
        $regUrl = '/reg.html';
        
        $viewPath = $this->getView()->getScriptPath();
        
        //检测用户是否登录
        $this->user = checkLogin();
        if(!empty($this->user)){
            $this->user_id = $this->user['user_id'];
        }
        
        $this->getView()->assign([
            'menu'=>$menu,
            'fmenu'=>$fmenu,
            'config'=>$this->setting,
            'theme'=>$this->theme,
            'notice'=>$notice,
            'loginUrl'=>$loginUrl,
            'regUrl'=>$regUrl,
            'viewPath'=>$viewPath,
            'user'=> $this->user,
            'actionName'=>$this->getRequest()->getActionName()
        ]);  
    }
    
    protected function error($msg){
        
    }

    protected function getConfig(){
        $obj = new ConfigModel();
        $rs = $obj->select();
        $data = [];
        if($rs){
            foreach ($rs as $vo) {
                $data[$vo['key']] = $vo['val'];
            }
        }
        return $data;
    }
    
    protected function getSeo($page,$replace=[],$default=[],$p=0){
        $obj = new SeoModel();
        $row = $obj->get([
            'page'=>$page
        ],[
            'seo_title','seo_key','seo_desc','seo_h1'
        ]);
       
        if(empty($row)){
            return $default;
        }
        if(!empty($replace)){
            foreach ($row as &$vo) {
                foreach ($replace as $key => $val) {
                    $vo = str_replace($key, $val, $vo);
                }
            }
        }
        if(empty($row['seo_title']) && !empty($default['seo_title'])){
            $row['seo_title'] = $default['seo_title'];
        }
        if(empty($row['seo_key']) && !empty($default['seo_key'])){
            $row['seo_key'] = $default['seo_key'];
        }
        if(empty($default['seo_desc']) && !empty($default['seo_desc'])){
            $row['seo_desc'] = $default['seo_desc'];
        }
        if($p>1){
            $row['seo_title'].="_第{$p}页";
        }
        return $row;
    }
    
    
    protected function getMenu(){
        $obj = new MenuModel();
        return $obj->select();
    }
    
    protected function getPage(){
        $obj = new PageModel();
        return $obj->select();
    }
    
    
    //读取广告
    protected function getAdv($flag,$format=true){
//        $obj = new AdvModel();
//        return $obj->($flag,$format);
    }
    
    
    
    protected function getNotice(){
        $obj = new NoticeModel();
        $list = $obj->select([
            'status'=>1,
            'ORDER'=>[
                'id'=>'DESC'
            ],
            'LIMIT'=>1
        ], ['id','title']);
        return $list;
    }
    
    
    
    //阅读排行
    protected function pluginTopRead($num=10){
        $obj = new ArticleModel();
        return $obj->select([
            'status'=>1,
            'ORDER'=>[
                'view_num'=>'DESC',
                'id'=>'DESC'
            ],
            'LIMIT'=>[0,$num]
        ], ['uuid','title']);
    }
    
    
    //文章分类列表
    public function pluginTypeList(){
        $objType = new TypeModel();
        $type = $objType->select([
            'status'=>1,
            'type'=>1,
            'ORDER'=>['rise'=>'ASC']
        ]);
        return $type;
    }
    
    
    /**
    * 获取当前完整URL 包括QUERY_STRING
    * access public
    * return string
    */
   public function url(){
        $server = $this->getRequest()->getServer();
        $uri = '';
        if (!empty($server['HTTP_X_REWRITE_URL'])) {
            $uri = $server['HTTP_X_REWRITE_URL'];
        } elseif (!empty($server['REQUEST_URI'])) {
            $uri = $server['REQUEST_URI'];
        } elseif (!empty($server['ORIG_PATH_INFO'])) {
            $uri = $server['ORIG_PATH_INFO'] . (!empty($server['QUERY_STRING']) ? '?' . $server['QUERY_STRING'] : '');
        }
        $url = $server['REQUEST_SCHEME'].'://' . $server['HTTP_HOST'].$uri;
        return urlencode($url) ;
    }
}
