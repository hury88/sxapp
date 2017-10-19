<?php
/**
 * App 应用管理
 */
class App
{
    /**
     * @var bool 是否初始化过
     */
    protected static $init = false;

    /**
     * @var string 当前模块路径
     */
    public static $modulePath;

    /**
     * @var bool 应用调试模式
     */
    public static $debug = true;

    /**
     * @var string 应用类库命名空间
     */
    public static $namespace = 'app';

    /**
     * @var bool 应用类库后缀
     */
    public static $suffix = false;

    /**
     * @var bool 应用路由检测
     */
    protected static $routeCheck;

    /**
     * @var bool 严格路由检测
     */
    protected static $routeMust;

    protected static $dispatch;
    protected static $file = [];

    /**
     * 执行应用程序
     * @access public
     * @param Request $request Request对象
     * @return Response
     * @throws Exception
     */
    public static function run(Request $request = null)
    {
        is_null($request) && $request = Request::instance();

            $config = Config::get();


        if (empty(self::$init)) {
            // 初始化应用

            // 应用调试模式
            self::$debug = $config['app_debug'];
            if (!self::$debug) {
                ini_set('display_errors', 'Off');
            } elseif (!IS_CLI) {
                //重新申请一块比较大的buffer
                if (ob_get_level() > 0) {
                    $output = ob_get_clean();
                }
                ob_start();
                if (!empty($output)) {
                    echo $output;
                }
            }

            // 加载额外文件
            if (!empty($config['extra_file_list'])) {
                foreach ($config['extra_file_list'] as $prefix => $file) {
                    $file = strpos($file, '.') ? $file : APP_PATH . $file . EXT;
                    if (is_file($file) && !isset(self::$file[$file])) {
                        if(!is_numeric($prefix)){
                            defined(rtrim($prefix,'2')) && include $file;
                        }else{
                            include $file;
                        }
                        self::$file[$file] = true;
                    }
                }
            }

            // 设置系统时区
            date_default_timezone_set($config['default_timezone']);

            /**
             * date_default_timezone_set("Etc/GMT");//这是格林威治标准时间,得到的时间和默认时区是一样的
             * date_default_timezone_set("Etc/GMT+8");//这里比林威治标准时间慢8小时
             * date_default_timezone_set("Etc/GMT-8");//这里比林威治标准时间快8小时
             * date_default_timezone_set('PRC'); //设置中国时区
             */

            // 监听app_init
            //Hook::listen('app_init');

            self::$init = true;
            // if(M()->db()->)
        }
        if(C('REQUEST_VARS_FILTER')){
            // 全局安全过滤
            array_walk_recursive($_GET,     'sql_filter');
            array_walk_recursive($_POST,    'sql_filter');
            if(isset($_REQUEST) && is_array($_REQUEST)){
                array_walk_recursive($_REQUEST, 'sql_filter');
            }
        }

        define('REQUEST_METHOD',$_SERVER['REQUEST_METHOD']);
        define('IS_GET',        REQUEST_METHOD =='GET' ? true : false);
        define('IS_POST',       REQUEST_METHOD =='POST' ? true : false);
        define('IS_PUT',        REQUEST_METHOD =='PUT' ? true : false);
        // define('IS_INDEX',      substr(basename($_SERVER['PHP_SELF']),0,5) =='index' ? true : false);
        define('IS_DELETE',     REQUEST_METHOD =='DELETE' ? true : false);


        $request->filter($config['default_filter']);
    }

    /**
     * 初始化应用
     */
    public static function initCommon()
    {
        if (empty(self::$init)) {
            // 初始化应用
            $config       = Config::get();

            // 应用调试模式
            self::$debug = $config['app_debug'];
            if (!self::$debug) {
                ini_set('display_errors', 'Off');
            } elseif (!IS_CLI) {
                //重新申请一块比较大的buffer
                if (ob_get_level() > 0) {
                    $output = ob_get_clean();
                }
                ob_start();
                if (!empty($output)) {
                    echo $output;
                }
            }

            // 加载额外文件
            if (!empty($config['extra_file_list'])) {
                foreach ($config['extra_file_list'] as $prefix => $file) {
                    $file = strpos($file, '.') ? $file : APP_PATH . $file . EXT;
                    if (is_file($file) && !isset(self::$file[$file])) {
                        if(!is_numeric($prefix)){
                            defined(rtrim($prefix,'2')) && include $file;
                        }else{
                            include $file;
                        }
                        self::$file[$file] = true;
                    }
                }
            }

            // 设置系统时区
            date_default_timezone_set($config['default_timezone']);

            /**
             * date_default_timezone_set("Etc/GMT");//这是格林威治标准时间,得到的时间和默认时区是一样的
             * date_default_timezone_set("Etc/GMT+8");//这里比林威治标准时间慢8小时
             * date_default_timezone_set("Etc/GMT-8");//这里比林威治标准时间快8小时
             * date_default_timezone_set('PRC'); //设置中国时区
             */

            // 监听app_init
            //Hook::listen('app_init');

            self::$init = true;
        }
        return Config::get();
    }

    /**
     * URL路由检测（根据PATH_INFO)
     * @access public
     * @param  \think\Request $request
     * @param  array          $config
     * @return array
     * @throws \think\Exception
     */
    public static function routeCheck($request, array $config)
    {
        $path   = $request->path();
        $depr   = $config['pathinfo_depr'];
        $result = false;
        // 路由检测
        $check = !is_null(self::$routeCheck) ? self::$routeCheck : $config['url_route_on'];
        if ($check) {
            // 开启路由
            if (is_file(RUNTIME_PATH . 'route.php')) {
                // 读取路由缓存
                $rules = include RUNTIME_PATH . 'route.php';
                if (is_array($rules)) {
                    Route::rules($rules);
                }
            } else {
                $files = $config['route_config_file'];
                foreach ($files as $file) {
                    if (is_file(CONF_PATH . $file . CONF_EXT)) {
                        // 导入路由配置
                        $rules = include CONF_PATH . $file . CONF_EXT;
                        if (is_array($rules)) {
                            Route::import($rules);
                        }
                    }
                }
            }

            // 路由检测（根据路由定义返回不同的URL调度）
            $result = Route::check($request, $path, $depr, $config['url_domain_deploy']);
            $must   = !is_null(self::$routeMust) ? self::$routeMust : $config['url_route_must'];
            if ($must && false === $result) {
                // 路由无效
                throw new RouteNotFoundException();
            }
        }
        if (false === $result) {
            // 路由无效 解析模块/控制器/操作/参数... 支持控制器自动搜索
            $result = Route::parseUrl($path, $depr, $config['controller_auto_search']);
        }
        return $result;
    }

    /**
     * 设置应用的路由检测机制
     * @access public
     * @param  bool $route 是否需要检测路由
     * @param  bool $must  是否强制检测路由
     * @return void
     */
    public static function route($route, $must = false)
    {
        self::$routeCheck = $route;
        self::$routeMust  = $must;
    }
}
