<?php

class AdvModel extends BaseModel{

    private $table = 'wt_adv';
    
    
    /***
     * {
	"text": "",
	"url": "http:\/\/www.baidu.com\/",
	"size": "",
	"link": "0",
	"bold": "0",
	"img": "da58a9afb04b3e76ed2b95adbfabea69",
	"width": "",
	"height": "",
	"alt": "测试",
	"code": "",
	"open": "0"
}
     */
    public function get($flag,$format = true){
        $row = $this->db->get($this->table,'*',[
            'AND'=>[
                'status'=>1,
                'flag'=>$flag,
            ] 
        ]);
        if(empty($row)) {
            return;
        }
        if(empty($format)){
            return $row; 
        }
        $contents = json_decode($row['contents'],true);
        $target = '';
        if($row['open']==1){
            $target=' target="_blank" ';
        }
        
        if($row['type']==1){ //文字广告
            $data = '<a href="'.$contents['link'].'" ';
            if($row['open']==1){
                $data.=$target;
            }
            $style = '';
            if(!empty($contents['size'])){ //大小
                $style.=' font-size:'.$contents['size'].'px;';
            }
            if(!empty($contents['bold'])){ //加粗
                $style.=' font-weight:bolder;';
            }
            if(!empty($contents['line'])){ //下划线
                $style.=' text-decoration: underline;';
            }
            if(!empty($contents['color'])){ //颜色
                $style.=' color: '.$contents['color'].';';
            }
            if(!empty($style)){
                $data.= ' style="'.$style.'" ';
            }
            $data.='>'.$contents['text'].'</a>';
        }elseif($row['type']==2){ //2=图片
            $img = handle_img($contents['img'],2,$contents['width'],$contents['height']);
            $data = '<a href="'.$contents['url'].'" '.$target.'><img src="'.$img.'" alt="'.$contents['alt'].'" /></a>';
        }elseif($row['type']==3){ //3=百度联盟 
            $data=$contents['code'];
        }
        return $data;
    }
    
    
    public function select($flag,$format = true){
        $list = $this->db->select($this->table,[
            'alt','img','url','iscode','rise','title','bgcolor'
        ],[
            'AND'=>[
                'status'=>1,
                'flag'=>$flag,
            ] 
        ]);
        if(empty($list)) return;
        if(empty($format)){
            return $list; 
        }
        if($row['iscode']){
            return $row['url'];
        }
        if(!$row['img']){
            return;
        } 
        $data =  [];
        $img = explode(',', $row['img']);
        if(count($img)==1){
            return '<a href="'.$row['url'].'"><img alt="'.$row['alt'].'" src="'.$row['img'].'" /></a>';
        }
        $url = explode(',', $row['url']);
        $alt = explode(',', $row['alt']);
        $rise = explode(',', $row['rise']);
        foreach ($img as $i=>$vo) {
            $num = isset($rise[$i])?$rise[$i]:$i;
            $data[$num] = [
                'img'=>$vo,
                'url'=>  isset($url[$i])?$url[$i]:'',
                'alt'=>  isset($alt[$i])?$alt[$i]:''
            ];
        }
        ksort($data);
        return $data;
    }
}

