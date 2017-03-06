<?php

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
