<?php

namespace Storage;

/**
 * File 文件存取类 
 * Function list:
 * - set()
 * - get()
 * - delete()
 * - flush()
 */
class File {

    protected static $umask = false;  //文件权限过滤
    protected $_dir = null;  //文件目录
    protected $_serialized = false; //是否序列化存取

    /**
     * @param string $dir        [存储目录]
     * @param bool   $serialized [是否序列化，用于记录缓存]
     */ 
    public function __construct($dir='', $serialized = true) { 
        if (false === self::$umask) {
            $umask = \Yaf\Registry::get("config")->sys->umask; 
            umask(intval($umask?$umask:0077, 8));
            self::$umask = true;
        }
        $this->_dir = $dir?$dir:\Yaf\Registry::get("config")->sys->runtime.'cache'.DIRECTORY_SEPARATOR;
        if (!is_dir($this->_dir)) {
            mkdir($this->_dir, 0777, true);
        } 
        $this->_serialized = $serialized;
    }

    
    /**
     * 保存数据 
     * @param string $name   键
     * @param mxied  $value  值
     * @param int    $expire [有效时间]
     */
    public function set($name, $value, $expire = 0) {
        if ($this->_serialized) {
            //序列化写入文件
            $expire = $expire > 0 ? $_SERVER['REQUEST_TIME'] + $expire : 0;
            $value = serialize(array($value, $expire));
        }
        assert('is_scalar($value)||is_null($value)', '保存的数据应该是基本类型');
        $filename = $this->_dir . $name . '.php';
        return file_put_contents($filename, '<?php //' . $value) > 0;
    }

    /**
     * 批量保存数据 
     * @param array $data   [数据(键值对)]
     * @param int   $expire [有效时间]
     */
    public function mset(array $data, $expire = 0) {
        $dir = $this->_dir;
        $result = true;
        if ($this->_serialized) {
            //序列化写入文件
            $expire = $expire > 0 ? $_SERVER['REQUEST_TIME'] + $expire : 0;
            foreach ($data as $key => &$value) {
                $result = $result && file_put_contents($dir . $key . '.php', '<?php //' . serialize(array($value, $expire)));
            }
        } else {
            foreach ($data as $key => &$value) {
                $result = $result && file_put_contents($dir . $key . '.php', '<?php //' . $value);
            }
        }
        return $result;
    }

    /**
     * 读取数据
     *
     * @param string $name 名称
     *
     * @return mixed
     */
    public function get($name) {
        $filename = $this->_dir . $name . '.php';
        if (is_file($filename)) {
            $content = substr(file_get_contents($filename), 8);
        } else {
            return false; /* 不存在返回null */
        }

        if ($this->_serialized) {
            /* 反序列化的文件 */
            $content = unserialize($content);
            if ($content[1] && $_SERVER['REQUEST_TIME'] > $content[1]) {
                @unlink($filename);
                return false;
            }
            return $content[0];
        }
        return $content;
    }

    /**
     * 批量读取数据
     *
     * @param array $data [数据(键值对)]
     */
    public function mget(array $data) {
        $result = array();
        foreach ($data as &$k) {
            $result[$k] = $this->get($k);
        }
        unset($k);
        return $result;
    }

    /**
     * 删除数据
     *
     * @param string $name 数据文件名称
     *
     * @return bool 操作结果
     */
    public function delete($name) {
        $filename = $this->_dir . $name . '.php';
        return is_file($filename) ? unlink($filename) : false;
    }

    /**
     * 删除全部缓存数据 
     * @return File 返回自身
     */
    public function flush() {
        clean_dir($this->_dir); 
        return $this;
    }

    

}
