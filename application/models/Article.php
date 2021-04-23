<?php

class ArticleModel extends BaseModel{

    private $table = 'wt_news';
    private $type = 'wt_type';
    private $user = 'wt_user';


    public function select($condition='',$field="*"){ 
        return $this->db->select($this->table,$field,$condition); 
    }
    
    public function get($condition=[],$field="*"){
        return $this->db->get($this->table,$field,$condition);
    }
    
    
    public function update($data,$where){
        return $this->db->update($this->table,$data,$where);
    }

    
    public function getRelate($uuid){
        return $this->db->get($this->table."(a)",[
            '[>]'.$this->type.'(b)'=>['a.type_id'=>'id'],
            '[>]'.$this->user.'(c)'=>['a.user_id'=>'id']
        ],[
            'a.uuid','a.from_url','a.img','a.title','a.is_first','a.hot','a.create_time',
            'a.tags','a.shortdesc','a.contents','a.user_id','a.original','a.index',
            'b.typename','b.url','c.nickname','a.fck','a.markdown','a.type_id'
        ],[
            'AND'=>[
                'a.uuid'=>$uuid,
                'a.status'=>1
            ]
        ]);
    }

    
    public function selectRelateByKeyword($keyword,$p=1,$size=0){ 
        $start = ($p-1)*$size;
        $condition = [
            'AND'=>[
                'a.status'=>1,
                'OR'=>[
                    'a.title[~]'=>$keyword,
                    'a.shortdesc[~]'=>$keyword
                ] 
            ],
            'ORDER'=>['a.rise'=>'ASC']
        ]; 
        if($size){
            $condition['LIMIT']=[$start,$size];
        } 
        return $this->db->select($this->table.'(a)',[
            "[>]".$this->type."(b)"=>['a.type_id'=>'id'],
            "[>]".$this->user."(c)"=>['a.user_id'=>'id'],
        ],[
            'a.id','a.uuid','a.title','a.img','a.shortdesc','a.create_time','a.tags','a.view_num',
            'a.type_id','a.original','a.index','a.user_id','b.typename','b.url','c.nickname','c.face'
        ],$condition);
    }
    

    public function selectRelate($type='index',$p=1,$size=0,$type_id=0,$ids=[]){ 
        $start = ($p-1)*$size;
        if($type=="index"){
            $condition = [
                'AND'=>[
                    'a.status'=>1,
                    'a.index'=>1
                ],
                'ORDER'=>[
                    'a.rise'=>'ASC',
                    'a.id'=>'DESC'
                ],
            ];
        }elseif($type=='list'){
           
            $condition = [
                'AND'=>[
                    'a.status'=>1,
                ],
                'ORDER'=>['a.rise'=>'ASC']
            ];
            if(!empty($type_id)){
                $condition['AND']['a.type_id']=$type_id;
            }
        } 
        if($size){
            $condition['LIMIT']=[$start,$size];
        }
        if(!empty($ids)){
            $condition['AND']['a.id']=$ids;
        }
        return $this->db->select($this->table.'(a)',[
            "[>]".$this->type."(b)"=>['a.type_id'=>'id'],
            "[>]".$this->user."(c)"=>['a.user_id'=>'user_id'],
        ],[
            'a.id','a.uuid','a.title','a.img','a.shortdesc','a.create_time','a.tags','a.view_num',
            'a.type_id','a.original','a.index','a.user_id','b.typename','b.url','c.nickname','c.face'
        ],$condition);
    }
    
    
    
    public function selectRelateByZhuanti($zhuanti_id){ 
        $condition = [
            'AND'=>[
                'a.status'=>1,
                'a.zhuanti_id'=>$zhuanti_id
            ],
            'ORDER'=>[
                'a.step'=>'ASC',
            ]
        ]; 
        return $this->db->select($this->table.'(a)',[
            "[>]".$this->type."(b)"=>['a.type_id'=>'id'],
        ],[
            'a.id','a.uuid','a.title','a.img','a.step','a.create_time','a.view_num',
            'a.type_id','a.original','a.index','a.user_id','b.typename','b.url'
        ],$condition);
    }
    
    
    public function count($condition=[]){
        return $this->db->count($this->table,$condition);
    }
    
   
    
}
