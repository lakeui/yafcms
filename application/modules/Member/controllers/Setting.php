<?php


class SettingController extends AuthController {
    
   
    //个人资料设置
    public function profileAction() {
        $css = load('member', 'css');
        $obj = new UserModel();
        $user = $obj->getUserByUserId($this->user['user_id'],'*');
        $params = [  
            'seo'=>[
                'seo_title'=>'个人资料设置'
            ],
            'css'=>$css,
            'hideFooter'=>true,
            'row'=>$user,
            'leftMenu'=> $this->leftMenu
        ];
        $this->getView()->assign($params);
    }
    
    
    //修改密码
    public function passwdAction() { 
        $css = load('member', 'css');
        $params = [  
            'seo'=>[
                'seo_title'=>'修改密码'
            ],
            'css'=>$css,
            'hideFooter'=>true,
            'leftMenu'=> $this->leftMenu
        ];
        $this->getView()->assign($params);
    }


    //主页设置
    public function homeAction() { 
        $obj = new UserModel();
        $user = $obj->getUserByUserId($this->user['user_id'],[
            'user_id','shortdesc','qrcode','home'
        ]);
        $css = load('member', 'css');
        $params = [  
            'seo'=>[
                'seo_title'=>'修改密码'
            ],
            'css'=>$css,
            'hideFooter'=>true,
            'row'=>$user,
            'leftMenu'=> $this->leftMenu
        ];
        $this->getView()->assign($params);
    }

    
    //社交账号设置
    public function openAction() { 
        
        $data = [
//            1=>[
//                'title'=>'微信',
//                'icon'=>'weixin',
//                'isbind'=>0,
//                'url'=>''
//            ],
            2=>[
                'title'=>'Github',
                'icon'=>'github',
                'isbind'=>0,
                'url'=> ''
            ],
            3=>[
                'title'=>'微博',
                'icon'=>'weibo',
                'isbind'=>0,
                'url'=>''
            ],
//            4=>[
//                'title'=>'QQ',
//                'icon'=>'qq',
//                'isbind'=>0,
//                'url'=>''
//            ]
        ];
        
        $obj = new UserModel();
        $bind = $obj->getUserBindList($this->user['user_id']);
        $html = '';
        foreach ($data as $key => $vo) {
            if(!empty($bind[$key])){
                $html.="<li id='{$vo['icon']}' class='{$vo['icon']}-item binded'><a  href='javascript:'><i class='fa fa-{$vo['icon']}'></i><br/>
	 		{$vo['title']} <br/> <span>{$bind[$key]['account']}</span>
	 		</a></li>";
            }else{
                $vo['url'] = $this->getOpenLoginUrl($vo['icon'],'bind');
                $html.="<li id='{$vo['icon']}' class='{$vo['icon']}-item'><a target='_blank' href='{$vo['url']}'><i class='fa fa-{$vo['icon']}'></i><br/>
	 		{$vo['title']} <br/> <span>未绑定</span>
	 		</a></li>";
            }
            
        }
        $css = load('member', 'css');
        $params = [  
            'seo'=>[
                'seo_title'=>'第三方账号关联'
            ],
            'css'=>$css,
            'hideFooter'=>true,
            'html'=>$html,
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
