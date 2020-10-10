<?php

class AuthController extends BaseController {
    
    
    protected $leftMenu = [
        '/member/setting/'=>[
            'title'=>'基本设置',
            'child'=>[
                'profile'=>[
                    'title'=>'个人资料',
                    'icon'=>'user'
                ],
                'home'=>[
                    'title'=>'主页设置',
                    'icon'=>'home'
                ],
                'passwd'=>[
                    'title'=>'修改密码',
                    'icon'=>'lock'
                ],
                'open'=>[
                    'title'=>'社交账号',
                    'icon'=>'weibo'
                ]
            ]
        ],
//        '/member/order/'=>[
//            'title'=>'订单中心',
//            'child'=>[
//                'index'=>[
//                    'title'=>'我的订单',
//                    'icon'=>'shopping-cart'
//                ]
//            ]
//        ],
        '/member/contents/'=>[
            'title'=>'内容管理',
            'child'=>[
                'article'=>[
                    'title'=>'文章',
                    'icon'=>'file-text-o'
                ],
                'comments'=>[
                    'title'=>'评论',
                    'icon'=>'commenting-o'
                ],
                'follow'=>[
                    'title'=>'关注',
                    'icon'=>'feed'
                ],
                'fav'=>[
                    'title'=>'收藏',
                    'icon'=>'bookmark'
                ],
                'love'=>[
                    'title'=>'喜欢',
                    'icon'=>'heart-o'
                ],
            ]
        ],
        '/member/assets/'=>[
            'title'=>'资产管理',
            'child'=>[
                'coin'=>[
                    'title'=>'桃核',
                    'icon'=>'diamond'
                ],
                'score'=>[
                    'title'=>'积分',
                    'icon'=>'gift'
                ] 
            ]
        ]
    ];




    public function init() { 
        parent::init();
        $url = $this->url();
        if(empty($this->user)){
            if($this->getRequest()->isXmlHttpRequest()){
                finish(2000);
            }else{
                $this->redirect("/login.html?backurl=".$url);
            }
             
        } 
    }
    
    
    
    public function isAjax() {
        if(!$this->getRequest()->isXmlHttpRequest()){
            finish(1);
        }
        \Yaf\Dispatcher::getInstance()->autoRender(FALSE);
    }
}
