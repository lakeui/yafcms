<?php

/**
 * 分页类
 * @author zh
 * @date 2012.11.12 
 * @version v1.0
 */
class Pager { 
    protected $firstRow; // 起始行数
    protected $listRows; // 每页显示数
    protected $totalPages; // 分页总页面数
    protected $totalRows; // 总数
    protected $nowPage; // 当前页数
    protected $coolPages; // 分页的栏的总页数
    protected $rollPage; // 分页栏每页显示的页数
    protected $jump = true; //是否显示输入页数跳转
    protected $type = "url"; //url 普通模式   ajax ajax方式   rewrite 重写模式
    protected $function = 'ajaxPage'; //JavaScript中使用的获取数据方法名
    protected $button = "btn"; //跳转按钮样式
    protected $text = "txt60"; //跳转框样式
    protected $curr = "active"; //当前选中样式
    protected $disable = "disabled"; //不可用样式
    protected $first = false;  //更改第一页链接方式
    protected $showNum = true; //   是否显示数字链接
    protected $param = 'p'; //参数名
    protected $rule = array(); //重写规则,重写参数array('first'=>'llk_ff_','end'=>'ddd','firstpage'=>'llk_ff');
    protected $split = true;  //省略显示
    protected $shenglv="...";
    protected $val = array();
    // 分页显示定制
    protected $config = array(
        'header' => '条记录',
        'prev' => '上一页',
        'next' => '下一页',
        'first' => '首页',
        'last' => '末页',
        'theme' => '共  %totalRow% %header% %nowPage%/%totalPage% 页 %first% %upPage%  %prePage%  %linkPage%  %nextPage% %downPage% %end% %jump%'
    );
    
    /**
     * @access public
     * @param  $totalRows  总的记录数
     * @param  $listRows  每页显示记录数
     * @param  $rollpage  是否显示linkpage条数
     * @param  $param url分页参数
     */
    public function __construct($totalRows, $listRows = 10, $rollpage = 5, $param = 'p', $rule = array()) {
        $this->totalRows = $totalRows;
        $this->listRows = $listRows;
        $this->rollPage = $rollpage;
        $this->param = $param;
        $this->listRows = !empty($listRows) ? $listRows : 10;
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
        $this->coolPages = ceil($this->totalPages / $this->rollPage);
        $this->nowPage = !empty($_REQUEST [$this->param]) ? $_REQUEST [$this->param] : 1;
        if (!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows * ($this->nowPage - 1);
        $this->rule = $rule;
    }

    /**
     * 参数设定
     * @param type $param
     */
    public function set($param) {
        foreach ($param as $key => $vo) {
            $this->$key = $vo;
        }
    } 
    /**
     * 设置显示样式
     * @access public
     */
    public function setConfig($name, $value = "") {
        if (is_array($name)) {
            foreach ($name as $key => $vo) {
                $this->setConfig($key, $vo);
            }
        } else {
            if (isset($this->config [$name])) {
                $this->config [$name] = $value;
            }
        }
    } 

    /**
     * 分页显示输出
     * @access public
     */
    public function show() { 
        $prePage=$nextPage=$upPage=$downPage=$jump="";
        if ($this->totalRows == 0)
            return '';
        $p = $this->param;
        $nowCoolPage = ceil($this->nowPage / $this->rollPage); 
        $request_url = $_SERVER ['REQUEST_URI'];
        $split = "&";
        $parse = parse_url($request_url);
        if (isset($parse ['query'])) {
            $temp = explode("&", $parse ['query']);
            $arr = array();
            foreach ($temp as $value) {
                if ($value) {
                    $rs = explode("=", $value);
                    $arr[$rs[0]] = $rs[1];
                }
            }
            unset($arr[$p]);
            if ($arr) {
                $temp = array();
                foreach ($arr as $key => $vo) {
                    $temp[] = $key . "=" . $vo;
                }
                $url = $parse ['path'] . '?' . implode("&", $temp);
            } else {
                $url = $parse['path'];
                $split = "?";
            }
        } else {
            $url = $parse['path'];
            $split = "?";
        }
        //上下翻页字符串
        $upRow = $this->nowPage - 1;
        $downRow = $this->nowPage + 1;
        if ($upRow > 0) {
            if ($this->type == "ajax") {
                $upPage = '<a href=javascript:' . $this->function . '(' . $upRow . ');>' . $this->config ['prev'] . '</a>'; //ajax方式
            } else if ($this->type == "rewrite") {
                if ($upRow == 1) {
                    $upPage = '<a  href="' . $this->rule['firstpage'] . '">' . $this->config ['prev'] . '</a>';
                } else {
                    $upPage = '<a  href="' . $this->rule['first'] . $upRow . $this->rule['end'] . '">' . $this->config ['prev'] . '</a>';
                }
            } else if ($this->type == "url") {
                $upPage = '<a  href="' . $url . $split . $p . '=' . $upRow . '">' . $this->config ['prev'] . '</a>';
            }
        } else {
            if($this->totalPages!=1){
                $upPage = '<a  class="' . $this->disable . '" href="javascript:void(0)">' . $this->config ['prev'] . '</a>';
            }
        }

        if ($downRow <= $this->totalPages) {
            if ($this->type == "ajax") {
                $downPage = '<a href=javascript:' . $this->function . '(' . $downRow . ');>' . $this->config ['next'] . '</a>'; //ajax方式
            } else if ($this->type == "rewrite") {
                $downPage = '<a  href="' . $this->rule['first'] . $downRow . $this->rule['end'] . '">' . $this->config ['next'] . '</a>';
            } else if ($this->type == "url") {
                $downPage = '<a  href="' . $url . $split . $p . '=' . $downRow . '">' . $this->config ['next'] . '</a>';
            }
        } else {
            if($this->totalPages!=1){
                $downPage = '<a  class="' . $this->disable . '" href="javascript:void(0)">' . $this->config ['next'] . '</a>';
            }
        }
        // << < > >>
        if ($this->nowPage == $this->totalPages && $this->totalPages == 1) {
                $theFirst = '';
                $prePage = '';
        } else {
            //$preRow = $this->nowPage - $this->rollPage;
            if ($this->type == "ajax") {
                $theFirst = '<a href=javascript:' . $this->function . '(1);>' . $this->config ['first'] . '</a>'; //ajax方式
            } else if ($this->type == "rewrite") {  
                if (!$this->first) { 
                    if($this->nowPage==1){
                        $theFirst = '<a  href="javascript:void(0);" class="' . $this->disable . '">' . $this->config ['first'] . '</a>';
                    }else{
                        $theFirst = '<a  href="' . $this->rule['firstpage'] . '">' . $this->config ['first'] . '</a>';
                    } 
                } else {
                    $theFirst = '<a  href="' . $url . '">' . $this->config ['first'] . '</a>';
                }
            } else if ($this->type == "url") {
                if ($this->first) {
                    $theFirst = '<a  href="' . $url . $split . $p . '=1" >' . $this->config ['first'] . '</a>';
                } else {
                    $theFirst = '<a  href="' . $url . '" >' . $this->config ['first'] . '</a>';
                }
            }
        }
        if ($this->nowPage == $this->totalPages) {
            if ($this->totalPages == 1) {
                $nextPage = '';
                $theEnd = '';
            } else {
                $theEnd = '<a  class="' . $this->disable . '" href="javascript:void(0)">' . $this->config ['last'] . '</a>';
            }
        } else {
            //$nextRow = $this->nowPage + $this->rollPage;
            $theEndRow = $this->totalPages;
            if ($this->type == "ajax") {
                $theEnd = '<a href=javascript:' . $this->function . '(' . $theEndRow . ');>' . $this->config ['last'] . '</a>'; //ajax方式
            } else if ($this->type == "rewrite") {
                $theEnd = '<a  href="' . $this->rule['first'] . $theEndRow . $this->rule['end'] . '">' . $this->config ['last'] . '</a>';
            } else if ($this->type == "url") {
                $theEnd = '<a  href="' . $url . $split . $p . '=' . $theEndRow . '" >' . $this->config ['last'] . '</a>';
            }
        }


        // 1 2 3 4 5
        if ($this->showNum) {
            $linkPage = ''; 
            for ($i = 1; $i <= $this->rollPage; $i++) {
                $page = ($nowCoolPage - 1) * $this->rollPage + $i;
                //保证linkpage保持当前页不是最后一个
//                if ($this->nowPage % $this->rollPage == 0) {
//                    $page = ($nowCoolPage - 1) * $this->rollPage + $i + $this->rollPage - 1;
//                } 
                if ($page != $this->nowPage) {
                    if ($page <= $this->totalPages) {
                        if ($this->type == "ajax") {//ajax方式
                            $linkPage .= '<a href=javascript:' . $this->function . '(' . $page . ');>' . $page . '</a>';
                        } else if ($this->type == "rewrite") {
                            if ($this->first) {
                                $linkPage .= '<a  href="' . $this->rule['first'] . $page . $this->rule['end'] . '">' . $page . '</a>';
                            } else {
                                if ($page == 1) {
                                    $linkPage .= '<a  href="' . $this->rule['firstpage'] . '">' . $page . '</a>';
                                } else {
                                    $linkPage .= '<a  href="' . $this->rule['first'] . $page . $this->rule['end'] . '">' . $page . '</a>';
                                }
                            }
                        } else if ($this->type == "url") {
                            if ($this->first) {
                                $linkPage .= '<a  href="' . $url . $split . $p . '=' . $page . '">' . $page . '</a>';
                            } else {
                                if ($page == 1) {
                                    $linkPage .= '<a  href="' . $url . '">' . $page . '</a>';
                                } else {
                                    $linkPage .= '<a  href="' . $url . $split . $p . '=' . $page . '">' . $page . '</a>';
                                }
                            }
                        }
                    } else {
                        break;
                    }
                } else {
                    if ($this->totalPages != 1) {
                        $linkPage .= '<a class="' . $this->curr . '">' . $page . '</a>';
                    }
                }
            }
            if ($this->split) { 
                if ($page < $this->totalPages) {
                    $linkPage.=$this->shenglv;
                    if ($this->type == "ajax") {
                        $theEndNum = '<a href=javascript:' . $this->function . '(' . $this->totalPages . ');>' . $this->totalPages . '</a>'; //ajax方式
                    } else if ($this->type == "rewrite") {
                        $theEndNum = '<a  href="' . $this->rule['first'] . $this->totalPages . $this->rule['end'] . '">' . $this->totalPages . '</a>';
                    } else if ($this->type == "url") {
                        $theEndNum = '<a  href="' . $url . $split . $p . '=' . $this->totalPages . '" >' . $this->totalPages . '</a>';
                    }
                    $linkPage.=$theEndNum;
                }
            }
        }

        //jump page
        if ($this->jump) {
            if ($this->nowPage != 1 || $this->nowPage != $this->totalPages) {
                $jump = "<input type='text' id='jumpTxt' class='$this->text' value='$this->nowPage' />";
                $jump.="<input type='button' id='jumpBtn' class='$this->button' value='跳转' onclick='jumpPage($this->nowPage)' />";
                $jump.='<script type="text/javascript">';
                $jump.="function jumpPage(page){";
                $jump.='var jumptopage = document.getElementById("jumpTxt").value;';
                $jump.="var topage;";
                $jump.="if(jumptopage==page||isNaN(jumptopage)){";
                $jump.="return false;";
                $jump.="}else{";
                $jump.="if(jumptopage>$this->totalPages){";
                $jump.="topage = $this->totalPages;";
                $jump.="}else if(jumptopage<1){";
                $jump.="topage = 1;";
                $jump.="}else{";
                $jump.="topage = jumptopage;";
                $jump.="}";
                if ($this->type == "ajax") {
                    $jump.= $this->function . "(topage);";
                } else if ($this->type == "rewrite") {
                    $jurl = $this->rule['first'];
                    $jump.="window.location.href ='$jurl'+topage" . $this->rule['end'];
                } else if ($this->type == "url") {
                    $jurl = $url . $split . $p;
                    $jump.="window.location.href ='$jurl='+topage";
                }
                $jump.="}}</script>";
            } else {
                $this->setConfig(array(
                    "theme" => "<span class='round'>共  %totalRow% %header% %nowPage%/%totalPage% 页</span> %first% %upPage%  %prePage%  %linkPage%  %nextPage% %downPage% %end% %jump%",
                ));
            }
        }
        $pageStr = str_replace(array('%header%', '%nowPage%', '%totalRow%', '%totalPage%', '%upPage%', '%downPage%', '%first%', '%prePage%', '%linkPage%', '%nextPage%', '%end%', '%jump%'), array($this->config ['header'], $this->nowPage, $this->totalRows, $this->totalPages, $upPage, $downPage, $theFirst, $prePage, $linkPage, $nextPage, $theEnd, $jump), $this->config ['theme']);

        return $pageStr;
    }

}

?>