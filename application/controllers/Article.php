<?php

class ArticleController extends BaseController {

  
    
    public function listAction() {   
        $url = $this->getRequest()->getParam('url');
        $p = $this->getRequest()->getParam('p');
        
        //分类
        $obj = new TypeModel();
        $row = $obj->get([
            'url'=>$url
        ],[
            'id','typename','url','seo_title','seo_key','seo_desc'
        ]);
        if(!$row){
            throw new \Yaf\Exception('分类已经不存在');
        }
        
        //分类列表  
        $type = $this->pluginTypeList();
        
        
        //获取文章
        $objArticle = new ArticleModel();
        $list = $objArticle->selectRelate('list',1,10,$row['id']);
        
        //分页处理
        $total = $objArticle->count([
            'AND'=>[
                'status'=>1,
                'type_id'=>$row['id']
            ]
        ]);
        $pageObj = new Pager($total, 10, 5, 'p', [
            'first'=>$url.'/',
            'end'=>'',
            'firstpage'=>'/'.$url
        ]);
        $page = $pageObj->show();
        $seo = $this->getSeo('type',[
            '{val}'=>$row['typename']
        ],$row); 
        
       
        
        //标签
        $objTag = new TagModel();
        $tag = $objTag->select([
            'ORDER'=>['num'=>"DESC"],
            'LIMIT'=>15
        ],['num','tagname']);
        
        
        //阅读排行
        $topArticle = $this->pluginTopRead();
        
        $params = [  
            'seo'=>$seo,
            'url'=>$url,
            'list'=>$list,
            'type'=>$type,
            'page'=>$page,
            'row'=>$row,
            'topArticle'=>$topArticle,
            'tag'=>$tag,
        ];
        $this->getView()->assign($params);
    }
    
    
    public function detailAction() { 
        
        
        $uuid = $this->getRequest()->getParam('uuid');
        $obj = new ArticleModel();
        $row = $obj->getRelate($uuid);
        if(!$row){
            throw new \Yaf\Exception('文章已经不存在');
        } 
        $seo = $this->getSeo('article',[
            '{val}'=>$row['title']
        ]);  
        $crumb = crumb('文章详情', [
            '/cate/'.$row['url']=>$row['typename']
        ]);
        
        
        //分类
        $type = $this->pluginTypeList();
        
        //标签
        $objTag = new TagModel();
        $tag = $objTag->select([
            'ORDER'=>['num'=>"DESC"],
            'LIMIT'=>15
        ],['num','tagname']);
        
        $css = $js = '';
        
        
        list($txt_num,$read_time) = getReadParam($row['contents']);
        
        
        //获取作者详情 
        $userObj = new UserModel();
        $author = $userObj->getUserByUserId($row['user_id']);
        
        
        //获取作者其他的文章
        $authorAritcle = $obj->select([
            'AND'=>[
                'user_id'=>$row['user_id'],
                'uuid[!]'=>$row['uuid']
            ],
            'ORDER'=>['id'=>'DESC'],
            'LIMIT'=>5
        ], [
            'uuid','title','view_num','create_time'
        ]);
    
        
        //推荐阅读，获取该分类下的文章
        $recomAritcle = $obj->select([
            'AND'=>[
                'type_id'=>$row['type_id'],
                'uuid[!]'=>$row['uuid']
            ],
            'ORDER'=>['id'=>'DESC'],
            'LIMIT'=>5
        ], [
            'uuid','title','view_num','create_time'
        ]); 
        
        if($row['fck']==2 || $row['fck']==3){ 
            $css = load('editormd.preview.min','css','libs/editormd/css');
            
            if($row['fck']==3){
                $js = load([
                    'marked.min','prettify.min','raphael.min',
                    'underscore.min','sequence-diagram.min',
                    'flowchart.min','jquery.flowchart.min'
                ],'js','libs/editormd/lib');
                $js.= load('editormd.min','js','libs/editormd');
            }
        } 
        $css.=load('comment','css');
        
        
        $face = array ( 'zy_thumb' => '[挤眼]', 'qq_thumb' => '[亲亲]', 'nm_thumb' => '[怒骂]', 'mb_thumb' => '[太开心]', 'ldln_thumb' => '[懒得理你]', 'k_thumb' => '[打哈气]', 'sb_thumb' => '[生病]', 'sdz_thumb' => '[书呆子]', 'sw_thumb' => '[失望]', 'kl_thumb' => '[可怜]', 'h_thumb' => '[黑线]', 't_thumb' => '[吐]', 'wq_thumb' => '[委屈]', 'sk_thumb' => '[思考]', 'laugh' => '[哈哈]', 'x_thumb' => '[嘘]', 'yhh_thumb' => '[右哼哼]', 'zhh_thumb' => '[左哼哼]', 'yw_thumb' => '[疑问]', 'yx_thumb' => '[阴险]', 'd_thumb' => '[顶]', 'money_thumb' => '[钱]', 'bs_thumb' => '[悲伤]', 'bs2_thumb' => '[鄙视]', '88_thumb' => '[拜拜]', 'cj_thumb' => '[吃惊]', 'bz_thumb' => '[闭嘴]', 'cry' => '[衰]', 'fn_thumb' => '[愤怒]', 'gm_thumb' => '[感冒]', 'cool_thumb' => '[酷]', 'come_thumb' => '[来]', 'good_thumb' => '[good]', 'ha_thumb' => '[haha]', 'no_thumb' => '[不要]', 'ok_thumb' => '[ok]', 'o_thumb' => '[拳头]', 'sad_thumb' => '[弱]', 'ws_thumb' => '[握手]', 'z2_thumb' => '[赞]', 'ye_thumb' => '[耶]', 'bad_thumb' => '[最差]', 'tza_thumb' => '[可爱]', 'tootha_thumb' => '[嘻嘻]', 'sweata_thumb' => '[汗]', 'smilea_thumb' => '[呵呵]', 'sleepya_thumb' => '[困]', 'sleepa_thumb' => '[睡觉]', 'shamea_thumb' => '[害羞]', 'sada_thumb' => '[泪]', 'lovea_thumb' => '[爱你]', 'kbsa_thumb' => '[挖鼻屎]', 'hsa_thumb' => '[花心]', 'heia_thumb' => '[偷笑]', 'hearta_thumb' => '[心]', 'hatea_thumb' => '[哼]', 'gza_thumb' => '[鼓掌]', 'dizzya_thumb' => '[晕]', 'cza_thumb' => '[馋嘴]', 'crazya_thumb' => '[抓狂]', 'bba_thumb' => '[抱抱]', 'angrya_thumb' => '[怒]', 'right_thumb' => '[右抱抱]', 'left_thumb' => '[左抱抱]'); 
        
        $params = [ 
            'type'=>$type,
            'tag'=>$tag,
            'row'=>$row,
            'seo'=>$seo,
            'crumb'=>$crumb,
            'css'=>$css,
            'js'=>$js,
            'face'=>$face,
            'author'=>$author,
            'authorAritcle'=>$authorAritcle,
            'recomAritcle'=>$recomAritcle,
            'txt_num'=>$txt_num,
            'read_time'=>$read_time,
            'url'=> $this->url()
        ];
        $this->getView()->assign($params);
    }
 
  
}
