<?php 
namespace Yaf {

    final class Application {
        /* properties */

        protected $config = NULL;
        protected $dispatcher = NULL;
        static protected $_app = NULL;
        protected $_modules = NULL;
        protected $_running = "";
        protected $_environ = "product";
        protected $_err_no = "0";
        protected $_err_msg = "";

        /* methods */

        public function __construct($config, $environ = NULL) {
            
        }

        public function run() {
            
        }

        public function execute($entry, $_ = "...") {
            
        }

        public static function app() {
            
        }

        public function environ() {
            
        }

        public function bootstrap($bootstrap = NULL) {
            
        }

        public function getConfig() {
            
        }

        public function getModules() {
            
        }

        public function getDispatcher() {
            
        }

        public function setAppDirectory($directory) {
            
        }

        public function getAppDirectory() {
            
        }

        public function getLastErrorNo() {
            
        }

        public function getLastErrorMsg() {
            
        }

        public function clearLastError() {
            
        }

        public function __destruct() {
            
        }

        private function __clone() {
            
        }

        private function __sleep() {
            
        }

        private function __wakeup() {
            
        }

    }

}

namespace Yaf {

    abstract class Bootstrap_Abstract {
        
    }

}

namespace Yaf {

    final class Dispatcher {
        /* properties */

        protected $_router = NULL;
        protected $_view = NULL;
        protected $_request = NULL;
        protected $_plugins = NULL;
        static protected $_instance = NULL;
        protected $_auto_render = "1";
        protected $_return_response = "";
        protected $_instantly_flush = "";
        protected $_default_module = NULL;
        protected $_default_controller = NULL;
        protected $_default_action = NULL;

        /* methods */

        private function __construct() {
            
        }

        private function __clone() {
            
        }

        private function __sleep() {
            
        }

        private function __wakeup() {
            
        }

        public function enableView() {
            
        }

        public function disableView() {
            
        }

        public function initView($templates_dir, array $options = NULL) {
            
        }

        public function setView($view) {
            
        }

        public function setRequest($request) {
            
        }

        public function getApplication() {
            
        }

        public function getRouter() {
            
        }

        public function getRequest() {
            
        }

        public function setErrorHandler($callback, $error_types) {
            
        }

        public function setDefaultModule($module) {
            
        }

        public function setDefaultController($controller) {
            
        }

        public function setDefaultAction($action) {
            
        }

        public function returnResponse($flag) {
            
        }

        public function autoRender($flag) {
            
        }

        public function flushInstantly($flag) {
            
        }

        public static function getInstance() {
            
        }

        public function dispatch($request) {
            
        }

        public function throwException($flag = NULL) {
            
        }

        public function catchException($flag = NULL) {
            
        }

        public function registerPlugin($plugin) {
            
        }

    }

}

namespace Yaf {

    final class Loader {
        /* properties */

        protected $_library = NULL;
        protected $_global_library = NULL;
        static protected $_instance = NULL;

        /* methods */

        private function __construct() {
            
        }

        private function __clone() {
            
        }

        private function __sleep() {
            
        }

        private function __wakeup() {
            
        }

        public function autoload($class_name) {
            
        }

        public static function getInstance($local_library_path = NULL, $global_library_path = NULL) {
            
        }

        public function registerLocalNamespace($name_prefix) {
            
        }

        public function getLocalNamespace() {
            
        }

        public function clearLocalNamespace() {
            
        }

        public function isLocalName($class_name) {
            
        }

        public static function import($file) {
            
        }

        public function setLibraryPath($library_path, $is_global = NULL) {
            
        }

        public function getLibraryPath($is_global = NULL) {
            
        }

    }

}

namespace Yaf {

    abstract class Request_Abstract {
        /* constants */

        const SCHEME_HTTP = "http";
        const SCHEME_HTTPS = "https";

        /* properties */

        public $module = NULL;
        public $controller = NULL;
        public $action = NULL;
        public $method = NULL;
        protected $params = NULL;
        protected $language = NULL;
        protected $_exception = NULL;
        protected $_base_uri = "";
        protected $uri = "";
        protected $dispatched = "";
        protected $routed = "";

        /* methods */

        public function isGet() {
            
        }

        public function isPost() {
            
        }

        public function isPut() {
            
        }

        public function isHead() {
            
        }

        public function isOptions() {
            
        }

        public function isCli() {
            
        }

        public function isXmlHttpRequest() {
            
        }

        public function getServer($name, $default = NULL) {
            
        }

        public function getEnv($name, $default = NULL) {
            
        }

        public function setParam($name, $value = NULL) {
            
        }

        public function getParam($name, $default = NULL) {
            
        }

        public function getParams() {
            
        }

        public function getException() {
            
        }

        public function getModuleName() {
            
        }

        public function getControllerName() {
            
        }

        public function getActionName() {
            
        }

        public function setModuleName($module) {
            
        }

        public function setControllerName($controller) {
            
        }

        public function setActionName($action) {
            
        }

        public function getMethod() {
            
        }

        public function getLanguage() {
            
        }

        public function setBaseUri($uri) {
            
        }

        public function getBaseUri() {
            
        }

        public function getRequestUri() {
            
        }

        public function setRequestUri($uri) {
            
        }

        public function isDispatched() {
            
        }

        public function setDispatched() {
            
        }

        public function isRouted() {
            
        }

        public function setRouted($flag = NULL) {
            
        }

    }

}

namespace Yaf\Request {

    class Http extends Yaf\Request_Abstract {
        /* properties */

        public $module = NULL;
        public $controller = NULL;
        public $action = NULL;
        public $method = NULL;
        protected $params = NULL;
        protected $language = NULL;
        protected $_exception = NULL;
        protected $_base_uri = "";
        protected $uri = "";
        protected $dispatched = "";
        protected $routed = "";

        /* methods */

        public function getQuery() {
            
        }

        public function getRequest() {
            
        }

        public function getPost() {
            
        }

        public function getCookie() {
            
        }

        public function getFiles() {
            
        }

        public function get() {
            
        }

        public function isXmlHttpRequest() {
            
        }

        public function __construct() {
            
        }

        private function __clone() {
            
        }

        public function isGet() {
            
        }

        public function isPost() {
            
        }

        public function isPut() {
            
        }

        public function isHead() {
            
        }

        public function isOptions() {
            
        }

        public function isCli() {
            
        }

        public function getServer($name, $default = NULL) {
            
        }

        public function getEnv($name, $default = NULL) {
            
        }

        public function setParam($name, $value = NULL) {
            
        }

        public function getParam($name, $default = NULL) {
            
        }

        public function getParams() {
            
        }

        public function getException() {
            
        }

        public function getModuleName() {
            
        }

        public function getControllerName() {
            
        }

        public function getActionName() {
            
        }

        public function setModuleName($module) {
            
        }

        public function setControllerName($controller) {
            
        }

        public function setActionName($action) {
            
        }

        public function getMethod() {
            
        }

        public function getLanguage() {
            
        }

        public function setBaseUri($uri) {
            
        }

        public function getBaseUri() {
            
        }

        public function getRequestUri() {
            
        }

        public function setRequestUri($uri) {
            
        }

        public function isDispatched() {
            
        }

        public function setDispatched() {
            
        }

        public function isRouted() {
            
        }

        public function setRouted($flag = NULL) {
            
        }

    }

}

namespace Yaf\Request {

    final class Simple extends Yaf\Request_Abstract {
        /* constants */

        const SCHEME_HTTP = "http";
        const SCHEME_HTTPS = "https";

        /* properties */

        public $module = NULL;
        public $controller = NULL;
        public $action = NULL;
        public $method = NULL;
        protected $params = NULL;
        protected $language = NULL;
        protected $_exception = NULL;
        protected $_base_uri = "";
        protected $uri = "";
        protected $dispatched = "";
        protected $routed = "";

        /* methods */

        public function __construct() {
            
        }

        private function __clone() {
            
        }

        public function getQuery() {
            
        }

        public function getRequest() {
            
        }

        public function getPost() {
            
        }

        public function getCookie() {
            
        }

        public function getFiles() {
            
        }

        public function get() {
            
        }

        public function isXmlHttpRequest() {
            
        }

        public function isGet() {
            
        }

        public function isPost() {
            
        }

        public function isPut() {
            
        }

        public function isHead() {
            
        }

        public function isOptions() {
            
        }

        public function isCli() {
            
        }

        public function getServer($name, $default = NULL) {
            
        }

        public function getEnv($name, $default = NULL) {
            
        }

        public function setParam($name, $value = NULL) {
            
        }

        public function getParam($name, $default = NULL) {
            
        }

        public function getParams() {
            
        }

        public function getException() {
            
        }

        public function getModuleName() {
            
        }

        public function getControllerName() {
            
        }

        public function getActionName() {
            
        }

        public function setModuleName($module) {
            
        }

        public function setControllerName($controller) {
            
        }

        public function setActionName($action) {
            
        }

        public function getMethod() {
            
        }

        public function getLanguage() {
            
        }

        public function setBaseUri($uri) {
            
        }

        public function getBaseUri() {
            
        }

        public function getRequestUri() {
            
        }

        public function setRequestUri($uri) {
            
        }

        public function isDispatched() {
            
        }

        public function setDispatched() {
            
        }

        public function isRouted() {
            
        }

        public function setRouted($flag = NULL) {
            
        }

    }

}

namespace Yaf {

    abstract class Response_Abstract {
        /* constants */

        const DEFAULT_BODY = "content";

        /* properties */

        protected $_header = NULL;
        protected $_body = NULL;
        protected $_sendheader = "";

        /* methods */

        public function __construct() {
            
        }

        public function __destruct() {
            
        }

        private function __clone() {
            
        }

        public function __toString() {
            
        }

        public function setBody($body, $name = NULL) {
            
        }

        public function appendBody($body, $name = NULL) {
            
        }

        public function prependBody($body, $name = NULL) {
            
        }

        public function clearBody($name = NULL) {
            
        }

        public function getBody($name = NULL) {
            
        }

        public function response() {
            
        }

    }

}

namespace Yaf\Response {

    class Http extends Yaf\Response_Abstract {
        /* constants */

        const DEFAULT_BODY = "content";

        /* properties */

        protected $_header = NULL;
        protected $_body = NULL;
        protected $_sendheader = "1";
        protected $_response_code = "0";

        /* methods */

        public function setHeader($name, $value, $rep = NULL, $response_code = NULL) {
            
        }

        public function setAllHeaders($headers) {
            
        }

        public function getHeader($name = NULL) {
            
        }

        public function clearHeaders() {
            
        }

        public function setRedirect($url) {
            
        }

        public function response() {
            
        }

        public function __construct() {
            
        }

        public function __destruct() {
            
        }

        private function __clone() {
            
        }

        public function __toString() {
            
        }

        public function setBody($body, $name = NULL) {
            
        }

        public function appendBody($body, $name = NULL) {
            
        }

        public function prependBody($body, $name = NULL) {
            
        }

        public function clearBody($name = NULL) {
            
        }

        public function getBody($name = NULL) {
            
        }

    }

}

namespace Yaf\Response {

    class Cli extends Yaf\Response_Abstract {
        /* constants */

        const DEFAULT_BODY = "content";

        /* properties */

        protected $_header = NULL;
        protected $_body = NULL;
        protected $_sendheader = "";

        /* methods */

        public function __construct() {
            
        }

        public function __destruct() {
            
        }

        private function __clone() {
            
        }

        public function __toString() {
            
        }

        public function setBody($body, $name = NULL) {
            
        }

        public function appendBody($body, $name = NULL) {
            
        }

        public function prependBody($body, $name = NULL) {
            
        }

        public function clearBody($name = NULL) {
            
        }

        public function getBody($name = NULL) {
            
        }

        public function response() {
            
        }

    }

}

namespace Yaf {

    abstract class Controller_Abstract {
        /* properties */

        public $actions = NULL;
        protected $_module = NULL;
        protected $_name = NULL;
        protected $_request = NULL;
        protected $_response = NULL;
        protected $_invoke_args = NULL;
        protected $_view = NULL;

        /* methods */

        protected function render($tpl, array $parameters = NULL) {
            
        }

        protected function display($tpl, array $parameters = NULL) {
            
        }

        public function getRequest() {
            
        }

        public function getResponse() {
            
        }

        public function getModuleName() {
            
        }

        public function getView() {
            
        }

        public function initView(array $options = NULL) {
            
        }

        public function setViewpath($view_directory) {
            
        }

        public function getViewpath() {
            
        }

        public function forward($module, $controller = NULL, $action = NULL, array $parameters = NULL) {
            
        }

        public function redirect($url) {
            
        }

        public function getInvokeArgs() {
            
        }

        public function getInvokeArg($name) {
            
        }

        final public function __construct() {
            
        }

        final private function __clone() {
            
        }

    }

}

namespace Yaf {

    abstract class Action_Abstract extends Yaf\Controller_Abstract {
        /* properties */

        public $actions = NULL;
        protected $_module = NULL;
        protected $_name = NULL;
        protected $_request = NULL;
        protected $_response = NULL;
        protected $_invoke_args = NULL;
        protected $_view = NULL;
        protected $_controller = NULL;

        /* methods */

        abstract public function execute();

        public function getController() {
            
        }

        protected function render($tpl, array $parameters = NULL) {
            
        }

        protected function display($tpl, array $parameters = NULL) {
            
        }

        public function getRequest() {
            
        }

        public function getResponse() {
            
        }

        public function getModuleName() {
            
        }

        public function getView() {
            
        }

        public function initView(array $options = NULL) {
            
        }

        public function setViewpath($view_directory) {
            
        }

        public function getViewpath() {
            
        }

        public function forward($module, $controller = NULL, $action = NULL, array $parameters = NULL) {
            
        }

        public function redirect($url) {
            
        }

        public function getInvokeArgs() {
            
        }

        public function getInvokeArg($name) {
            
        }

        final public function __construct() {
            
        }

        final private function __clone() {
            
        }

    }

}

namespace Yaf {

    abstract class Config_Abstract {
        /* properties */

        protected $_config = NULL;
        protected $_readonly = "1";

        /* methods */

        abstract public function get();

        abstract public function set();

        abstract public function readonly();

        abstract public function toArray();
    }

}

namespace Yaf\Config {

    final class Ini extends Yaf\Config_Abstract implements Iterator, Traversable, ArrayAccess, Countable {
        /* properties */

        protected $_config = NULL;
        protected $_readonly = "1";

        /* methods */

        public function __construct($config_file, $section = NULL) {
            
        }

        public function __isset($name) {
            
        }

        public function get($name = NULL) {
            
        }

        public function set($name, $value) {
            
        }

        public function count() {
            
        }

        public function rewind() {
            
        }

        public function current() {
            
        }

        public function next() {
            
        }

        public function valid() {
            
        }

        public function key() {
            
        }

        public function toArray() {
            
        }

        public function readonly() {
            
        }

        public function offsetUnset($name) {
            
        }

        public function offsetGet($name) {
            
        }

        public function offsetExists($name) {
            
        }

        public function offsetSet($name, $value) {
            
        }

        public function __get($name = NULL) {
            
        }

        public function __set($name, $value) {
            
        }

    }

}

namespace Yaf\Config {

    final class Simple extends Yaf\Config_Abstract implements Iterator, Traversable, ArrayAccess, Countable {
        /* properties */

        protected $_config = NULL;
        protected $_readonly = "";

        /* methods */

        public function __construct($config_file, $section = NULL) {
            
        }

        public function __isset($name) {
            
        }

        public function get($name = NULL) {
            
        }

        public function set($name, $value) {
            
        }

        public function count() {
            
        }

        public function offsetUnset($name) {
            
        }

        public function rewind() {
            
        }

        public function current() {
            
        }

        public function next() {
            
        }

        public function valid() {
            
        }

        public function key() {
            
        }

        public function readonly() {
            
        }

        public function toArray() {
            
        }

        public function __set($name, $value) {
            
        }

        public function __get($name = NULL) {
            
        }

        public function offsetGet($name) {
            
        }

        public function offsetExists($name) {
            
        }

        public function offsetSet($name, $value) {
            
        }

    }

}

namespace Yaf\View {

    class Simple implements Yaf\View_Interface {
        /* properties */

        protected $_tpl_vars = NULL;
        protected $_tpl_dir = NULL;
        protected $_options = NULL;

        /* methods */

        final public function __construct($template_dir, array $options = NULL) {
            
        }

        public function __isset($name) {
            
        }

        public function get($name = NULL) {
            
        }

        public function assign($name, $value = NULL) {
            
        }

        public function render($tpl, $tpl_vars = NULL) {
            
        }

        public function eval($tpl_str, $vars = NULL) {
        
    }

    public function display($tpl, $tpl_vars = NULL) {
        
    }

    public function assignRef($name, &$value) {
        
    }

    public function clear($name = NULL) {
        
    }

    public function setScriptPath($template_dir) {
        
    }

    public function getScriptPath() {
        
    }

    public function __get($name = NULL) {
        
    }

    public function __set($name, $value = NULL) {
        
    }

}

}

namespace Yaf {

final class Router {
    /* properties */

    protected $_routes = NULL;
    protected $_current = NULL;

    /* methods */

    public function __construct() {
        
    }

    public function addRoute() {
        
    }

    public function addConfig() {
        
    }

    public function route() {
        
    }

    public function getRoute() {
        
    }

    public function getRoutes() {
        
    }

    public function getCurrentRoute() {
        
    }

}

}

namespace Yaf {

class Route_Static implements Yaf\Route_Interface {
    /* methods */

    public function match($uri) {
        
    }

    public function route($request) {
        
    }

    public function assemble(array $info, array $query = NULL) {
        
    }

}

}

namespace Yaf\Route {

final class Simple implements Yaf\Route_Interface {
    /* properties */

    protected $controller = NULL;
    protected $module = NULL;
    protected $action = NULL;

    /* methods */

    public function __construct($module_name, $controller_name, $action_name) {
        
    }

    public function route($request) {
        
    }

    public function assemble(array $info, array $query = NULL) {
        
    }

}

}

namespace Yaf\Route {

final class Supervar implements Yaf\Route_Interface {
    /* properties */

    protected $_var_name = NULL;

    /* methods */

    public function __construct($supervar_name) {
        
    }

    public function route($request) {
        
    }

    public function assemble(array $info, array $query = NULL) {
        
    }

}

}

namespace Yaf\Route {

final class Rewrite implements Yaf\Route_Interface {
    /* properties */

    protected $_route = NULL;
    protected $_default = NULL;
    protected $_verify = NULL;

    /* methods */

    public function __construct($match, array $route, array $verify = NULL) {
        
    }

    public function route($request) {
        
    }

    public function assemble(array $info, array $query = NULL) {
        
    }

}

}

namespace Yaf\Route {

final class Regex implements Yaf\Route_Interface {
    /* properties */

    protected $_route = NULL;
    protected $_default = NULL;
    protected $_maps = NULL;
    protected $_verify = NULL;
    protected $_reverse = NULL;

    /* methods */

    public function __construct($match, array $route, array $map = NULL, array $verify = NULL, $reverse = NULL) {
        
    }

    public function route($request) {
        
    }

    public function assemble(array $info, array $query = NULL) {
        
    }

}

}

namespace Yaf\Route {

final class Map implements Yaf\Route_Interface {
    /* properties */

    protected $_ctl_router = "";
    protected $_delimiter = NULL;

    /* methods */

    public function __construct($controller_prefer = NULL, $delimiter = NULL) {
        
    }

    public function route($request) {
        
    }

    public function assemble(array $info, array $query = NULL) {
        
    }

}

}

namespace Yaf {

abstract class Plugin_Abstract {
    /* methods */

    public function routerStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
        
    }

    public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
        
    }

    public function dispatchLoopStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
        
    }

    public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
        
    }

    public function preDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
        
    }

    public function postDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
        
    }

    public function preResponse(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
        
    }

}

}

namespace Yaf {

final class Registry {
    /* properties */

    static protected $_instance = NULL;
    protected $_entries = NULL;

    /* methods */

    private function __construct() {
        
    }

    private function __clone() {
        
    }

    public static function get($name) {
        
    }

    public static function has($name) {
        
    }

    public static function set($name, $value) {
        
    }

    public static function del($name) {
        
    }

}

}

namespace Yaf {

final class Session implements Iterator, Traversable, ArrayAccess, Countable {
    /* properties */

    static protected $_instance = NULL;
    protected $_session = NULL;
    protected $_started = "";

    /* methods */

    private function __construct() {
        
    }

    private function __clone() {
        
    }

    private function __sleep() {
        
    }

    private function __wakeup() {
        
    }

    public static function getInstance() {
        
    }

    public function start() {
        
    }

    public function get($name) {
        
    }

    public function has($name) {
        
    }

    public function set($name, $value) {
        
    }

    public function del($name) {
        
    }

    public function count() {
        
    }

    public function rewind() {
        
    }

    public function next() {
        
    }

    public function current() {
        
    }

    public function key() {
        
    }

    public function valid() {
        
    }

    public function clear() {
        
    }

    public function offsetGet($name) {
        
    }

    public function offsetSet($name, $value) {
        
    }

    public function offsetExists($name) {
        
    }

    public function offsetUnset($name) {
        
    }

    public function __get($name) {
        
    }

    public function __isset($name) {
        
    }

    public function __set($name, $value) {
        
    }

    public function __unset($name) {
        
    }

}

}

namespace Yaf {

class Exception extends Exception implements Throwable {
    /* properties */

    protected $file = NULL;
    protected $line = NULL;
    protected $message = NULL;
    protected $code = "0";
    protected $previous = NULL;

    /* methods */

    final private function __clone() {
        
    }

    public function __construct($message = NULL, $code = NULL, $previous = NULL) {
        
    }

    public function __wakeup() {
        
    }

    final public function getMessage() {
        
    }

    final public function getCode() {
        
    }

    final public function getFile() {
        
    }

    final public function getLine() {
        
    }

    final public function getTrace() {
        
    }

    final public function getPrevious() {
        
    }

    final public function getTraceAsString() {
        
    }

    public function __toString() {
        
    }

}

}

namespace Yaf\Exception {

class StartupError extends Yaf\Exception implements Throwable {
    /* properties */

    protected $file = NULL;
    protected $line = NULL;
    protected $message = NULL;
    protected $code = "0";
    protected $previous = NULL;

    /* methods */

    final private function __clone() {
        
    }

    public function __construct($message = NULL, $code = NULL, $previous = NULL) {
        
    }

    public function __wakeup() {
        
    }

    final public function getMessage() {
        
    }

    final public function getCode() {
        
    }

    final public function getFile() {
        
    }

    final public function getLine() {
        
    }

    final public function getTrace() {
        
    }

    final public function getPrevious() {
        
    }

    final public function getTraceAsString() {
        
    }

    public function __toString() {
        
    }

}

}

namespace Yaf\Exception {

class RouterFailed extends Yaf\Exception implements Throwable {
    /* properties */

    protected $file = NULL;
    protected $line = NULL;
    protected $message = NULL;
    protected $code = "0";
    protected $previous = NULL;

    /* methods */

    final private function __clone() {
        
    }

    public function __construct($message = NULL, $code = NULL, $previous = NULL) {
        
    }

    public function __wakeup() {
        
    }

    final public function getMessage() {
        
    }

    final public function getCode() {
        
    }

    final public function getFile() {
        
    }

    final public function getLine() {
        
    }

    final public function getTrace() {
        
    }

    final public function getPrevious() {
        
    }

    final public function getTraceAsString() {
        
    }

    public function __toString() {
        
    }

}

}

namespace Yaf\Exception {

class DispatchFailed extends Yaf\Exception implements Throwable {
    /* properties */

    protected $file = NULL;
    protected $line = NULL;
    protected $message = NULL;
    protected $code = "0";
    protected $previous = NULL;

    /* methods */

    final private function __clone() {
        
    }

    public function __construct($message = NULL, $code = NULL, $previous = NULL) {
        
    }

    public function __wakeup() {
        
    }

    final public function getMessage() {
        
    }

    final public function getCode() {
        
    }

    final public function getFile() {
        
    }

    final public function getLine() {
        
    }

    final public function getTrace() {
        
    }

    final public function getPrevious() {
        
    }

    final public function getTraceAsString() {
        
    }

    public function __toString() {
        
    }

}

}

namespace Yaf\Exception {

class LoadFailed extends Yaf\Exception implements Throwable {
    /* properties */

    protected $file = NULL;
    protected $line = NULL;
    protected $message = NULL;
    protected $code = "0";
    protected $previous = NULL;

    /* methods */

    final private function __clone() {
        
    }

    public function __construct($message = NULL, $code = NULL, $previous = NULL) {
        
    }

    public function __wakeup() {
        
    }

    final public function getMessage() {
        
    }

    final public function getCode() {
        
    }

    final public function getFile() {
        
    }

    final public function getLine() {
        
    }

    final public function getTrace() {
        
    }

    final public function getPrevious() {
        
    }

    final public function getTraceAsString() {
        
    }

    public function __toString() {
        
    }

}

}

namespace Yaf\Exception\LoadFailed {

class Module extends Yaf\Exception\LoadFailed implements Throwable {
    /* properties */

    protected $file = NULL;
    protected $line = NULL;
    protected $message = NULL;
    protected $code = "0";
    protected $previous = NULL;

    /* methods */

    final private function __clone() {
        
    }

    public function __construct($message = NULL, $code = NULL, $previous = NULL) {
        
    }

    public function __wakeup() {
        
    }

    final public function getMessage() {
        
    }

    final public function getCode() {
        
    }

    final public function getFile() {
        
    }

    final public function getLine() {
        
    }

    final public function getTrace() {
        
    }

    final public function getPrevious() {
        
    }

    final public function getTraceAsString() {
        
    }

    public function __toString() {
        
    }

}

}

namespace Yaf\Exception\LoadFailed {

class Controller extends Yaf\Exception\LoadFailed implements Throwable {
    /* properties */

    protected $file = NULL;
    protected $line = NULL;
    protected $message = NULL;
    protected $code = "0";
    protected $previous = NULL;

    /* methods */

    final private function __clone() {
        
    }

    public function __construct($message = NULL, $code = NULL, $previous = NULL) {
        
    }

    public function __wakeup() {
        
    }

    final public function getMessage() {
        
    }

    final public function getCode() {
        
    }

    final public function getFile() {
        
    }

    final public function getLine() {
        
    }

    final public function getTrace() {
        
    }

    final public function getPrevious() {
        
    }

    final public function getTraceAsString() {
        
    }

    public function __toString() {
        
    }

}

}

namespace Yaf\Exception\LoadFailed {

class Action extends Yaf\Exception\LoadFailed implements Throwable {
    /* properties */

    protected $file = NULL;
    protected $line = NULL;
    protected $message = NULL;
    protected $code = "0";
    protected $previous = NULL;

    /* methods */

    final private function __clone() {
        
    }

    public function __construct($message = NULL, $code = NULL, $previous = NULL) {
        
    }

    public function __wakeup() {
        
    }

    final public function getMessage() {
        
    }

    final public function getCode() {
        
    }

    final public function getFile() {
        
    }

    final public function getLine() {
        
    }

    final public function getTrace() {
        
    }

    final public function getPrevious() {
        
    }

    final public function getTraceAsString() {
        
    }

    public function __toString() {
        
    }

}

}

namespace Yaf\Exception\LoadFailed {

class View extends Yaf\Exception\LoadFailed implements Throwable {
    /* properties */

    protected $file = NULL;
    protected $line = NULL;
    protected $message = NULL;
    protected $code = "0";
    protected $previous = NULL;

    /* methods */

    final private function __clone() {
        
    }

    public function __construct($message = NULL, $code = NULL, $previous = NULL) {
        
    }

    public function __wakeup() {
        
    }

    final public function getMessage() {
        
    }

    final public function getCode() {
        
    }

    final public function getFile() {
        
    }

    final public function getLine() {
        
    }

    final public function getTrace() {
        
    }

    final public function getPrevious() {
        
    }

    final public function getTraceAsString() {
        
    }

    public function __toString() {
        
    }

}

}

namespace Yaf\Exception {

class TypeError extends Yaf\Exception implements Throwable {
    /* properties */

    protected $file = NULL;
    protected $line = NULL;
    protected $message = NULL;
    protected $code = "0";
    protected $previous = NULL;

    /* methods */

    final private function __clone() {
        
    }

    public function __construct($message = NULL, $code = NULL, $previous = NULL) {
        
    }

    public function __wakeup() {
        
    }

    final public function getMessage() {
        
    }

    final public function getCode() {
        
    }

    final public function getFile() {
        
    }

    final public function getLine() {
        
    }

    final public function getTrace() {
        
    }

    final public function getPrevious() {
        
    }

    final public function getTraceAsString() {
        
    }

    public function __toString() {
        
    }

}

}

namespace Yaf {

interface View_Interface {
    /* methods */

    abstract public function assign();

    abstract public function display();

    abstract public function render();

    abstract public function setScriptPath();

    abstract public function getScriptPath();
}

}

namespace Yaf {

interface Route_Interface {
    /* methods */

    abstract public function route();

    abstract public function assemble();
}

}

