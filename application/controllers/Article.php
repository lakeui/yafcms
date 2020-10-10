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
        
         
        
        $params = [ 
            'type'=>$type,
            'tag'=>$tag,
            'row'=>$row,
            'seo'=>$seo,
            'crumb'=>$crumb,
            'css'=>$css,
            'js'=>$js,
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
