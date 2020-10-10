<?php

/**
 * 工具类
 *
 * @author zhangheng
 */
class Tool {

    /**
     * 用正则表达式验证手机号码(中国大陆区)
     * @param integer $num    所要验证的手机号
     * @return boolean
     */
    public static function isMobile($num) {
        if (!$num) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$#', $num) ? true : false;
    }

    /**
     * 正则表达式验证email格式 
     * @param string $str    所要验证的邮箱地址
     * @return boolean
     */
    public static function isEmail($str) {
        if (!$str) {
            return false;
        }
        return preg_match('#[a-z0-9&\-_.]+@[\w\-_]+([\w\-.]+)?\.[\w\-]+#is', $str) ? true : false;
    }

    /**
     * 验证字符串中是否含有汉字
     *
     * @param integer $string    所要验证的字符串。注：字符串编码仅支持UTF-8
     * @return boolean
     */
    public static function isChineseCharacter($string) {
        if (!$string) {
            return false;
        }
        return preg_match('~[\x{4e00}-\x{9fa5}]+~u', $string) ? true : false;
    }

    /**
     * 验证字符串中是否含有非法字符
     *
     * @param string $string    待验证的字符串
     * @return boolean
     */
    public static function isInvalidStr($string) {
        if (!$string) {
            return false;
        }
        return preg_match('#[!#$%^&*(){}~`"\';:?+=<>/\[\]]+#', $string) ? true : false;
    }

    /**
     * 正则表达式验证身份证号码
     *
     * @param integer $num    所要验证的身份证号码
     * @return boolean
     */
    public static function isPersonalCard($num) {
        if (!$num) {
            return false;
        }
        return preg_match('#^[\d]{15}$|^[\d]{18}$#', $num) ? true : false;
    }

    /**
     * 检查字符串长度
     *
     * @access public
     * @param string $string 字符串内容
     * @param integer $min 最小的字符串数
     * @param integer $max 最大的字符串数
     */
    public static function isLength($string = null, $min = 0, $max = 255) {
        //参数分析
        if (is_null($string)) {
            return false;
        }
        //获取字符串长度
        $length = strlen(trim($string));
        return (($length >= (int) $min) && ($length <= (int) $max)) ? true : false;
    }
    
   
    public static function getTimes($mark) {
        if ($mark == 'yesterday') {
            $start_time = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
            $end_time = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
        } else if ($mark == 'today') {
            $start_time = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $end_time = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        } else if ($mark == 'toweek') {
            $start_time = mktime(0, 0, 0, date('m'), date('d') - date('w') + 1, date('Y'));
            $end_time = mktime(23, 59, 59, date('m'), date('d') - date('w') + 7, date('Y'));
        } else if ($mark == 'tomonth') {
            $start_time = mktime(0, 0, 0, date('m'), 1, date('Y'));
            $end_time = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
        }
        $arr['s'] = $start_time;
        $arr['e'] = $end_time;
        return $arr;
    }
    
    

}
