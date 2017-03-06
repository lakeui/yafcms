<?php           
/**
 * 
 * 缓存类 Cache 
 * @author lakeui
 */
            
class Cache {

    private static $type = null;
    private static $_handler = null; //处理方式

    /**
     * 初始化缓存
     * @return objecct $_handler
     */
    public static function handler() {
        if ($handler = &self::$_handler) {
            return $handler;
        } 
        self::$type = \Yaf\Registry::get("config")->cache->type;
        switch (self::$type) {
            case 'memcached': //memcached 存储  
                $config = \Yaf\Registry::get("config")->memcached->toArray(); 
                if ($config['mcid']) {
                    //共享长连接
                    $handler = new \Memcached($config['mcid']);
                    if (!count($handler->getServerList())) {
                        //无可用服务器时建立连接
                        $handler->addServer($config['host'], $config['port']);
                    }
                } else {
                    $handler = new \Memcached();
                    $handler->addServer($config['host'], $config['port']);
                }
                break; 
            case 'redis': //redis 存储
                $config = \Yaf\Registry::get("config")->redis->toArray();  
                $handler = new \Redis();
                $handler->connect($config['host'], $config['port']); 
                if($config['auth']){//密码验证
                    $handler->auth($config['auth']);
                } 
                if($config['db']){//限定数据库
                    $handler->select($config['db']);
                } 
                break; 
            case 'file': //文件存储
                $handler = new \Storage\File();
                break; 
            case 'memcache': // memcahe 
                $config = \Yaf\Registry::get("config")->memcahe->toArray();  
                $handler = new \Memcache;
                $handler->addServer($config['host'], $config['port']);
                break; 
            default:
                Logger::write('缓存初始化失败[cache init failed]' . self::$type, 'ALERT');
                throw new \Yaf\Exception('未知缓存方式' . self::$type);
        }   
        return $handler;
    }
    
    /**
     * 设置缓存 
     * @param string|array $name   键
     * @param mixed        $value  值
     * @param int          $expire [缓存时间]
     */ 
    public static function set($name, $value = 0, $expire = 0) {
        $handler = self::handler(); 
        if (is_array($name)) {
            //数组批量设置
            //$value is $expire
            assert(func_num_args() < 3, '[Cache::set]第一个参数为数组时(批量设置)，最多两个参数');
            assert('is_numeric($value)', '[Cache::set]批量设置时，第二个参数时间必须为数字');

            switch (self::$type) {
                case 'memcached':
                    return $handler->setMulti($name, $value);

                case 'redis':
                    $result = true;
                    if ($value) {
                        foreach ($name as $k => &$v) {
                            $result = $result && $handler->setEx($k, $value, serialize($v)); 
                        }
                    } else {
                        foreach ($name as $k => &$v) {
                            $result = $result && $handler->set($k, serialize($v)); 
                        }
                    }
                    return $result;

                case 'file':
                    return $handler->mset($name, $value);

                case 'memcache':
                    $result = true;
                    foreach ($name as $k => &$v) {
                        $result = $result && $handler->set($k, $v, null, $value); //memcache 原始时间
                    }
                    return $result;
            }
        } else {
            //单条设置
            assert(func_num_args() > 1, '[Cache::set]第一个参数为数组时(批量设置)，最多两个参数');
            if ('memcached' === self::$type || 'file' === self::$type) {
                return $handler->set($name, $value, $expire);
            } elseif ('redis' === self::$type) {
                $value = serialize($value);
                return $expire ? $handler->setEx($name, $expire, $value) : $handler->set($name, $value);
            }
            assert('"memcache" ===self::$type', '缓存驱动不支持');
            return $handler->set($name, $value, null, $expire);
        }
    }

    /**
     * 读取缓存数据
     *
     * @param string|array $name    键
     * @param mixed        $default [默认值false]
     *
     * @return mixed 获取结果
     */
    public static function get($name, $default = false) {
        $handler = self::handler();
        if (is_array($name)) {
            //数组批量获取
            assert(func_num_args() === 1, '[Cache::get]参数为数组时(批量设置)，只能有一个参数');
            switch (self::$type) {
                case 'memcached':
                    $default = $handler->getMulti($name);
                    if (count($default) === count($name)) {
                        return $default;
                    }
                    return array_merge(array_fill_keys($name, false), $default);

                case 'file':
                    return $handler->mget($name);

                case 'redis':
                    if ($value = $handler->mget($name)) {
                        return array_combine($name, array_map('unserialize', $value));
                    }
                    return array_fill_keys($name, $default);

                case 'memcache':
                    $result = array();
                    foreach ($name as &$key) {
                        $result[$key] = $handler->get($key); //memcache 原始时间
                    }
                    return $result;
            }
        } else {
            $value = $handler->get($name);
            return false === $value ? $default : ('redis' === self::$type ? unserialize($value) : $value);
        }
    }

    /**
     * 删除缓存数据
     *
     * @param string $name 键值
     *
     * @return bool
     */
    public static function del($name) {
        return self::handler()->delete($name);
    }

    /**
     * 清空缓存
     *
     * @return bool 操作结果
     */
    public static function flush() {
        $handler = self::handler();
        if ('redis' === self::$type) {
            return $handler->flushDB();
        }
        return $handler->flush();
    }

    

}
