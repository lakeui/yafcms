<?php

class MenuModel extends BaseModel{

    private $table = 'wt_menu';
    
    
    public function select(){ 
        return $this->db->select($this->table,[
            'title','url','hot'
        ],[
            'status'=>1,
            'ORDER'=>[
                'rise'=>'ASC',
                'id'=>'ASC'
            ]
        ]); 
    }
    
}
