<?php

/**
 * 通用的网络调用方法封装
 *
 */
class Network {

    /**
     * 执行一个GET请求
     *
     * @param string $url
     * @param array $headers
     * @param int $timeout
     *
     * @return string|null
     */
    public static function get($url, array $headers = array(), $timeout = 5) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $content = curl_exec($ch);
        $response = curl_getinfo($ch);
        curl_close($ch);
        if ($response['http_code'] == 200) {
            return $content;
        }
        return null;
    }

    /**
     * 执行一个POST请求
     *
     * @param string $url
     * @param array $fields
     * @param array $headers
     * @param int $timeout
     *
     * @return string|null
     */
    public static function post($url, array $fields, array $headers = array(), $timeout = 5) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers + array('Expect:'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $content = curl_exec($ch);
        $response = curl_getinfo($ch);
        curl_close($ch);
        if ($response['http_code'] == 200) {
            return $content;
        }
        return null;
    }

    public static function head($url, $timeout = 5) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    public static function request($url, $mode, $params = '', $needHeader = false, $timeout = 10, $header = array(), $headerOnly = false) {
        $begin = microtime(true);
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        if ($needHeader) {
            curl_setopt($curlHandle, CURLOPT_HEADER, true);
            curl_setopt($curlHandle, CURLINFO_HEADER_OUT, true);
            if ($headerOnly) {
                curl_setopt($curlHandle, CURLOPT_NOBODY, 1); //不需要body
            }
        }
        if ($mode == 'POST') {
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $header + array('Expect:'));
            curl_setopt($curlHandle, CURLOPT_POST, true);
            if (is_array($params)) {
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($params));
            } else {
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $params);
            }
        } else {
            if ($header) {
                curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $header);
            }
            if (is_array($params)) {
                $url .= (strpos($url, '?') === false ? '?' : '&') . http_build_query($params);
            } else {
                $url .= (strpos($url, '?') === false ? '?' : '&') . $params;
            }
        }
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, false);
        }
        $result = curl_exec($curlHandle);
        if ($needHeader) {
            $tmp = $result;
            $result = array();
            $info = curl_getinfo($curlHandle);
            $result['header'] = substr($tmp, 0, $info['header_size']);
            $result['body'] = trim(substr($tmp, $info['header_size'])); //直接从header之后开始截取，因为 1.body可能为空   2.下载可能不全
        }
        $errno = curl_errno($curlHandle);
        if ($errno) {
            //$record = array('url'=>$url,'request_data'=>$params,'errno'=>$errno);
            //日志参数
            if (is_array($params)) {
                $params = http_build_query($params);
            }
            $url .= (strpos($url, '?') === false ? '?' : '&') . $params;
            $errMsg = curl_error($curlHandle) . '[' . curl_errno($curlHandle) . ']';
            Utility::errorlog($errMsg);
        }
        curl_close($curlHandle);
        return $result;
    }

    public static function download($url) {
        $tmp_dir = APP_PATH.'/runtime/tmp/';
        if (!is_dir($tmp_dir)) {
            mkdir($tmp_dir, 0777, true);
        }
        try {
            $curl = curl_init($url);
            $filename = $tmp_dir. basename($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($curl);
            curl_close($curl);
            $tp = fopen($filename, 'a');
            fwrite($tp, $data);
            fclose($tp);
            return $filename;
        } catch (Exception $e) {
            return false;
        }
    }

}
