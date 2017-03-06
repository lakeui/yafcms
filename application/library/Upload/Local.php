<?php
/**
 * 本地文件上传
 */
namespace Upload;
class Local {

    /**
     * 上传文件根目录
     * @var string
     */
    private $rootPath;

    /**
     * 本地上传错误信息
     * @var string
     */
    private $error = ''; //上传错误信息

    
    /**
     * 构造函数，用于设置上传根路径
     */
    public function __construct($config = null) {
         if($config && isset($config['rootPath']) && $config['rootPath']){
             $this->rootPath = $config['rootPath'];
         }else{
             $this->rootPath = \Yaf\Registry::get('config')->upload->path;
         }
    } 
    
    /**
     * 检测上传根目录
     * @param string $rootpath   根目录
     * @return boolean true-检测通过，false-检测失败
     */
    private function checkRootPath() {
        if (!(is_dir($this->rootPath) && is_writable($this->rootPath))) {
            $this->error = '上传根目录不存在！请手动创建:' . $this->rootPath;
            return false;
        } 
        return true;
    }

    /**
     * 检测上传目录
     * @param  string $savepath 上传目录
     * @return boolean          检测结果，true-通过，false-失败
     */
    private function checkSavePath($savepath) { 
        if (!$this->mkdir($savepath)) {
            return false;
        } 
        if (!is_writable($this->rootPath . $savepath)) {
            $this->error = '上传目录 ' . $savepath . ' 不可写！';
            return false;
        }
        return true; 
    }

    /**
     * 保存指定文件
     * @param  array   $file    保存的文件信息
     * @param  boolean $replace 同名文件是否覆盖
     * @return boolean          保存状态，true-成功，false-失败
     */
    public function save($file, $replace = true) {  
        if(!$this->checkRootPath()){
            return false;
        }
        if($file['savepath'] && !$this->checkSavePath($file['savepath'])){
           return false;
        }
        
        $filename = $this->rootPath . $file['savepath'] . $file['savename'];
        /* 不覆盖同名文件 */
        if (!$replace && is_file($filename)) {
            $this->error = '存在同名文件' . $file['savename'];
            return false;
        }
        /* 移动文件 */
        if (!move_uploaded_file($file['tmp_name'], $filename)) {
            $this->error = '文件上传保存错误！';
            return false;
        } 
        return true;
    }

    /**
     * 创建目录
     * @param  string $savepath 要创建的穆里
     * @return boolean          创建状态，true-成功，false-失败
     */
    public function mkdir($savepath) {
        $dir = $this->rootPath . $savepath;
        if (is_dir($dir)) {
            return true;
        }
        if (mkdir($dir, 0777, true)) {
            return true;
        }  
        $this->error = "目录 {$savepath} 创建失败！";
        return false; 
    }

    /**
     * 获取最后一次上传错误信息
     * @return string 错误信息
     */
    public function getError() {
        return $this->error;
    }

}
