<?php


class AssetsController extends AuthController {
    
   
    //我的桃币
    public function coinAction() {
        $css = load('member', 'css');
        $params = [  
            'seo'=>[
                'seo_title'=>'我的桃币'
            ],
            'css'=>$css,
            'hideFooter'=>true,
            'leftMenu'=> $this->leftMenu
        ];
        $this->getView()->assign($params);
    }
    
    
    //获取资产记录
    public function logsAction() {
        $p = $this->getRequest()->getPost("p");
        $type = $this->getRequest()->getPost("type");
        if(empty($type)){
            finish(2);
        }
        $obj = new UserAssetsModel();
        $list = $obj->getUserAssetsLogsList($this->user_id,$type, $p, 10, [
            'id','action','title','create_time','before_num','after_num','num'
        ]); 
        $data = [];
        if(!empty($list)){
            foreach ($list as $vo) {
                $data[] = [
                    'id'=>$vo['id'],
                    'title'=>$vo['title'],
                    'num'=>($vo['action']==1?'+':'-').$vo['num'],
                    'before_num'=>$vo['before_num'],
                    'after_num'=>$vo['after_num'],
                    'time'=>date('Y-m-d H:i:s',$vo['create_time'])
                ];
            }
        }
        
        finish(0,'',$data);
    }




    //我的积分
    public function scoreAction() {
        $obj = new UserAssetsModel();
         
        
        $css = load('member', 'css');
        $js = load('vue.min','js','libs/');
        $score = $obj->getUserAssets($this->user_id,'score_key');
        $total = $obj->countUserAssetsLogs($this->user_id, 1);
        
        $list = $obj->getTreeMonthScoreRank($this->user_id);
        $params = [  
            'seo'=>[
                'seo_title'=>'我的积分'
            ],
            'css'=>$css,
            'js'=>$js,
            'hideFooter'=>true,
            'leftMenu'=> $this->leftMenu,
            'score'=> $score,
            'total'=>$total,
            'list'=>$list
        ];
        $this->getView()->assign($params);
    }
      
     

}
