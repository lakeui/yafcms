<?php

function error_code($error_num = null) {
    $data = [
        1 => "非法操作",
        2 => "参数不匹配",
        3 => '操作太频繁，稍后再试',
        4 => '操作失败',
        10 => '自定义消息',
        
        1000 => '手机号已经被注册',
        1001 => '获取验证码次数已用完',
        1002 => '发送失败',
        1003 => '请输入正确的验证码',
        1004 => '请输入合法的手机号',
        1005 => '密码格式不正确',
        1006 => '验证码已过期',
        1007 => '注册失败',
        1008 => '账号密码错误',
        1009 => '异常账号',
        1010 => '手机号未注册',
        1011=>'请选择上传的文件',
        1012=>'上传失败',
        1013=>'请输入正确的密码',
        1014=>'原始密码不正确',
        
        
        2000=>'请先登录',
        2001=>'用户不存在',
        2002=>'您已经关注过该用户',
        2003=>'不能关注自己',
        2004=>'你没有关注该用户',
        
        2005=>'你已经收藏过文章',
        2006=>'你未收藏过文章',

        
        3000=>'积分不够',
        
        3001=>'文章已经不存在'
    ];
    return isset($data[$error_num]) ? $data[$error_num] : '';
}

/**
 * json 
 * @param $status  错误代码
 * @param $info  提示信息
 * @param $data  返回数据
 * @return  json;
 */
function finish($status, $info = "", $data = null) {
    $result ['status'] = $status;
    if (empty($info)) {
        $info = error_code($status);
    }
    $result ['info'] = $info;
    if (!is_null($data))
        $result ['data'] = $data;
    exit(json_encode($result));
}

/**
 * 清空目录 
 * @param string $dir [存储目录]
 */
function clean_dir($dir) {
    if (!is_dir($dir)) {
        return true;
    }
    $files = scandir($dir);
    unset($files[0], $files[1]);
    $result = 0;
    foreach ($files as &$f) {
        $result += @unlink($dir . $f);
    }
    unset($files);
    return $result;
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0, $adv = false) {
    $type = $type ? 1 : 0;
    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos)
                unset($arr[$pos]);
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($ip == '127.0.0.1') {
            $ip = get_client_ip(0, true);
        }
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}




/**
 * Cookie 设置、获取、删除
 * @param string $name cookie名称
 * @param mixed $value cookie值
 * @param mixed $options cookie参数
 * @return mixed
 */
function cookie($name='', $value='', $option=null) {
    $config = \Yaf\Registry::get('config')->cookie->toArray(); 
    // 参数设置(会覆盖黙认设置)
    if (!is_null($option)) {
        if (is_numeric($option))
            $option = array('expire' => $option);
        elseif (is_string($option))
            parse_str($option, $option);
        $config     = array_merge($config, array_change_key_case($option));
    }
    if(!empty($config['httponly'])){
        ini_set("session.cookie_httponly", 1);
    }
    // 清除指定前缀的所有cookie
    if (is_null($name)) {
        if (empty($_COOKIE))
            return;
        // 要删除的cookie前缀，不指定则删除config设置的指定前缀
        $prefix = empty($value) ? $config['prefix'] : $value;
        if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
            foreach ($_COOKIE as $key => $val) {
                if (0 === stripos($key, $prefix)) {
                    setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
                    unset($_COOKIE[$key]);
                }
            }
        }
        return;
    }elseif('' === $name){
        // 获取全部的cookie
        return $_COOKIE;
    }
    $name = $config['prefix'] . str_replace('.', '_', $name);
    if ('' === $value) {
        if(isset($_COOKIE[$name])){
            $value =    $_COOKIE[$name];
            if(0===strpos($value,'think:')){
                $value  =   substr($value,6);
                return array_map('urldecode',json_decode(MAGIC_QUOTES_GPC?stripslashes($value):$value,true));
            }else{
                return $value;
            }
        }else{
            return null;
        }
    } else {
        if (is_null($value)) {
            setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
            unset($_COOKIE[$name]); // 删除指定cookie
        } else {
            // 设置cookie
            if(is_array($value)){
                $value  = 'think:'.json_encode(array_map('urlencode',$value));
            }
            $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0; 
            setcookie($name, $value, $expire, $config['path'], $config['domain']);
            $_COOKIE[$name] = $value; 
        }
    }
}

function dump($var, $echo = true, $label = null, $flags = ENT_SUBSTITUTE) {
    $label = (null === $label) ? '' : rtrim($label) . ':';
    ob_start();
    var_dump($var);
    $output = ob_get_clean();
    $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
    if (!extension_loaded('xdebug')) {
        $output = htmlspecialchars($output, $flags);
    }
    $output = '<pre>' . $label . $output . '</pre>';
    if ($echo) {
        echo ($output);
        return null;
    } else {
        return $output;
    }
}

//处理tag
function handle_tag($tag) {
    $str = '';
    if ($tag) {
        $list = explode(' ', $tag);
        foreach ($list as $vo) {
            if (empty($vo)) {
                continue;
            }
            $str .= '<a href="/tag/' . urlencode($vo) . '" class="label-item" target="_blank">' . $vo . '</a>';
        }
    }
    return $str;
}

//处理图片
function handle_img($url = '', $type = 0, $w = 0, $h = 0) {
    if (empty($url)) {
        $url = 'default';
    }
    $img = \Yaf\Registry::get('config')->sys->imgurl;
    if (strpos($url, 'http') === 0) {
        return $url;
    }
    $sufix = '';
    if ($url != 'default') {
        $wh = '';
        if (!empty($w)) {
            $wh .= "w/{$w}/";
        }
        if (!empty($h)) {
            $wh .= "h/{$h}/";
        }
        if ($type == 1) { //加水印
            $sufix = '?imageView2/2/' . $wh . 'interlace/1/q/100|watermark/2/text/bGFrZXVpLmNvbQ==/font/YXJpYWw=/fontsize/400/fill/IzAwMDAwMA==/dissolve/27/gravity/SouthEast/dx/10/dy/10|imageslim';
        } elseif ($type == 2) { //不加水印
            $sufix = '?imageView2/2/' . $wh . 'interlace/1/q/100|imageslim';
        }
    }
    return $img . $url . $sufix;
}

function crumb($curr, $data = []) {
    $html = '<div class="wrap crumb">
	<a href="/" class="home">首页</a><i class="fa fa-angle-right"></i>';
    if (!empty($data)) {
        foreach ($data as $key => $vo) {
            $html .= '<a href="' . $key . '">' . $vo . '</a><i class="fa fa-angle-right"></i>';
        }
    }
    $html .= '<span>' . $curr . '</span></div>';
    return $html;
}


//加密解密
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    $ckey_length = 4;
    $sysstr = \Yaf\Registry::get('config')->sys->key;
    $key = md5($key ? $key : $sysstr);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) :
            substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
            sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

/**
 * 组合图片和文字
 * @param type $img
 * @param type $text  如果为空则加图片水印
 * @param type $type  qrcode=二维码加logo water 加水印
 * @return type
 */
function makeImg($img, $text = '', $type = 'qrcode') {
    $logoFile = WEB_PATH . 'images/qrcode.png';
    $QR = imagecreatefromstring(file_get_contents($img));
    $logo = imagecreatefromstring(file_get_contents($logoFile));

    $QR_width = imagesx($QR); //二维码图片宽度 
    $QR_height = imagesy($QR); //二维码图片宽度 
    $logo_width = imagesx($logo); //logo图片宽度
    $logo_height = imagesy($logo); //logo图片高度
    //重新组合图片并调整大小
    imagecopyresampled($QR, $logo, ($QR_width - $logo_width) / 2, ($QR_height - $logo_height) / 2, 0, 0, $logo_width,
            $logo_height, $logo_width, $logo_height);

    imagepng($QR, $img);

//    $img = imagecreatefromstring(file_get_contents($file));
//    $font =  ROOT_PATH.'static/font/fzltch.TTF';
//    $fontSize = 58;   //字体大小  
//        
//    $fontBox = imagettfbbox($fontSize, 0, $font, $text);//文字水平居中实质
//    
//    if($type=='desk'){
//        $fontColor = imagecolorallocate($img, 53, 175, 86);
//        imagettftext ($img, $fontSize, 0, ceil(($QR_width - $fontBox[2]) / 2), 713, $fontColor, $font, $text );
//    }else{
//        $fontColor = imagecolorallocate($img, 255, 255, 255);
//        imagettftext ($img, $fontSize, 0, ceil(($QR_width - $fontBox[2]) / 2),170, $fontColor, $font, $text );
//    }
//    
//    imagepng($img,$file);
    return $img;
}

function handle_user($vo, $really = false) {
    $url = 'javascript:';
    if (empty($vo['user_id'])) {
        $vo['user_id'] = intval(rand(1, 30));
    }
    $img = $vo['user_id'];
    if ($vo['user_id'] > 30) {
        $img = $vo['user_id'] % 30;
    }
    if ($really) {
        $url = '/u/' . $vo['user_id'];
    }
    $img = handle_img($img, $type = 2, 100, 100);
    $html = '<a class="head-portrait" href="' . $url . '"><img src="' . $img . '" alt=""></a>';
    return $html;
}

/**
 * 加载静态资源
 * @param type $name
 * @param type $type
 * @return string
 */
function load($name, $type = 'css', $path = "") {
    $theme = \Yaf\Registry::get('config')->theme;
    if (!is_array($name)) {
        $name = explode(',', $name);
    }
    $html = '';
    foreach ($name as $vo) {
        if ($type == 'css') {
            $path = $path ? $path : $theme . '/css';
            $html .= '<link rel="stylesheet" href="/' . $path . '/' . $vo . '.css">';
        } elseif ($type == 'js') {
            $path = $path ? $path : $theme . '/js';
            $html .= '<script src="/' . $path . '/' . $vo . '.js" type="text/javascript"></script>';
        } elseif ($type == 'img') {
            
        }
    }
    return $html;
}

/**
 * 检测是否使用手机访问
 * @access public
 * @return bool
 */
function isMobile() {
    $mobile = array();
    static $mobilebrowser_list = 'Mobile|iPhone|Android|WAP|NetFront|JAVA|OperasMini|UCWEB|WindowssCE|Symbian|Series|webOS|SonyEricsson|Sony|BlackBerry|Cellphone|dopod|Nokia|samsung|PalmSource|Xphone|Xda|Smartphone|PIEPlus|MEIZU|MIDP|CLDC';
    //note 获取手机浏览器
    if (preg_match("/$mobilebrowser_list/i", $_SERVER['HTTP_USER_AGENT'], $mobile)) {
        return true;
    } else {
        if (preg_match('/(mozilla|chrome|safari|opera|m3gate|winwap|openwave)/i', $_SERVER['HTTP_USER_AGENT'])) {
            return false;
        } else {
            if (isset($_GET['mobile']) && $_GET['mobile'] === 'yes') {
                return true;
            } else {
                return false;
            }
        }
    }
}

/**
 * 设置用户登陆
 * @param type $user
 */
function setLogin($user,$remember=false) {
    $key = 'lakeui_login';
    $session = \Yaf\Session::getInstance();
    $session->set($key, json_encode($user));
    
    $cookieVal = authcode($user['user_id'],'ENCODE');
    if(!empty($remember)){ //记住登录
        cookie('sid',$cookieVal);
    }
}

//退出
function logout() {
    $key = 'lakeui_login';
    $session = \Yaf\Session::getInstance();
    $session->del($key);
    cookie('sid',null);
}

/**
 * 检测用户是否登录
 * @return type
 */
function checkLogin() {
    $key = 'lakeui_login';
    $session = \Yaf\Session::getInstance();
    $res = $session->get($key);
    if(!empty($res)){
        return json_decode($res, true);;
    }
    $cookieVal = cookie('sid');
    if (empty($cookieVal)) {
       return;
    } 
    $user_id = authcode($cookieVal,'DECODE');
    if(empty($user_id)){
        return;
    }
    $user = new UserModel();
    $userInfo = $user->getUserByUserId($user_id);
    if(empty($userInfo)){
        return;
    }
    setLogin($userInfo);
    return $userInfo;
}

//手机
function showPhoneStr($phone){
    return  preg_replace('/(\d{3})\d{4}(\d{4})/', '$1****$2', $phone);
}

//用户名显示
function showUserName($user){
    return $user['phone']?showPhoneStr($user['phone']):$user['nickname'];
}


//显示
function showImgStr($key,$type=1,$default=""){
    if(empty($default)){
        if($type==1){
            $default = '/common/img/face.png';
        }elseif($type==2){
            $default = '/common/img/qrcode.png';
        }
    }
    if(empty($key)){
        return $default;
    }
    $url = \Yaf\Registry::get('config')->sys->imgurl;
    return $url.$key;
}


//显示用状态
function showUserStatus($status){
    $arr = [
        -1=>'禁用',
        0=>'<span class="red">待审核</span>',
        1=>'正常'
    ];
    return $arr[$status];
}
    
/**
 * 构建插入数据
 * @param type $post
 * @param type $field
 * @return type
 */
function buildDatabaseData($post,$field){
    foreach ($post as $key => &$vo) { 
        $vo = htmlentities($vo);
        if(!in_array($key, $field)){
            unset($post[$key]);
        }
    }
    return $post;
}


/**
 * 获取阅读参数
 * @param type $content 内容
 */
function getReadParam($text){
    $text_num =  mb_strlen(preg_replace('/\s/', '', html_entity_decode(strip_tags($text))), 'UTF-8');
    $read_time = ceil($text_num/100);
    $txt = $read_time.'秒';
    if($read_time>=60){
        $minute = $read_time%60;
        $sec = $read_time-$minute*60;
        $txt = $minute.'分'.$sec.'秒';
    }
    return [$text_num,$txt];
}


/**
 * 获取资产数据
 * @param type $numStr
 * @return int
 */
function getAssetsNum($numStr){
    if(empty($numStr)){
        return 0;
    }
    $num = authcode($numStr,'DECODE');
    return empty($num)?0:$num;
}

