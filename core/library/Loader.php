<?php
class Loader
{
    protected static $instance = [];
    // 类名映射
    protected static $map = [];
    // 类名关联
    protected static $relative = [];

    // TXLoader
    private static $loaders;
    // PSR-4
    private static $prefixLengthsPsr4 = [];
    private static $prefixDirsPsr4    = [];
    private static $fallbackDirsPsr4  = [];

    // 自动加载的文件
    private static $autoloadFiles = [];

    // 自动加载
    public static function autoload($class)
    {
        if ($file = self::findFile($class)) {

            // Win环境严格区分大小写
            if (IS_WIN && pathinfo($file, PATHINFO_FILENAME) != pathinfo(realpath($file), PATHINFO_FILENAME)) {
                return false;
            }

            __include_file($file);
            return true;
        }
    }

    /**
     * 查找文件
     * @param $class
     * @return bool
     */
    private static function findFile($class)
    {
        if (!empty(self::$map[$class])) {
            // 类库映射
            return self::$map[$class];
        }
        if (!empty(self::$relative[$class])) {
            // 类库关联
            return self::$relative[$class] . $class . EXT;
        }

        if (isset(self::$loaders[$class])) {
            return self::$loaders[$class];
        }

        // 查找 PSR-4
        foreach (self::$prefixDirsPsr4 as $dir) {
            if (is_file($file = $dir . $class . EXT)) {
                return $file;
            }
        }
        // return isset()
        return self::$map[$class] = false;
    }

    // 注册classmap
    public static function addClassMap($class, $map = '')
    {
        if (is_array($class)) {
            self::$map = array_merge(self::$map, $class);
        } else {
            self::$map[$class] = $map;
        }
    }
    // 注册classrelavtive
    public static function addClassRelative($class, $relative = '')
    {
        if (is_array($class)) {
            self::$relative = array_merge(self::$relative, $class);
        } else {
            self::$relative[$class] = $relative;
        }
    }

    // 注册命名空间
    public static function addNamespace($namespace, $path = '')
    {
        if (is_array($namespace)) {
            // self::addPsr4($namespace . '\\', rtrim($path, DS), true);
         self::$prefixDirsPsr4 = array_merge($namespace, self::$fallbackDirsPsr4 );
         foreach ($namespace as $path) {
            self::getLoads($path);
         }
     } else {
         self::$prefixDirsPsr4[$namespace] = $path;
     }
 }

    /**
     * 获取所有类文件
     * @param $path
     * @return array
     */
    private static function getLoads($path)
    {
        foreach (glob($path . DS.'*') as $file) {
            if (is_dir($file)) {
                self::getLoads($file);
            } else {
                $name = explode(DS, $file);
                $class = str_replace('.php', '', end($name));
                self::$loaders[$class] = $file;
            }
        }
    }

    // 添加Psr4空间
 private static function addPsr4($prefix, $paths, $prepend = false)
 {
    if (!$prefix) {
            // Register directories for the root namespace.
        if ($prepend) {
            self::$fallbackDirsPsr4 = array_merge(
                (array) $paths,
                self::$fallbackDirsPsr4
                );
        } else {
            self::$fallbackDirsPsr4 = array_merge(
                self::$fallbackDirsPsr4,
                (array) $paths
                );
        }
    } elseif (!isset(self::$prefixDirsPsr4[$prefix])) {
            // Register directories for a new namespace.
        $length = strlen($prefix);
        if ('\\' !== $prefix[$length - 1]) {
            throw new InvalidArgumentException("A non-empty PSR-4 prefix must end with a namespace separator.");
        }
        self::$prefixLengthsPsr4[$prefix[0]][$prefix] = $length;
        self::$prefixDirsPsr4[$prefix]                = (array) $paths;
    } elseif ($prepend) {
            // Prepend directories for an already registered namespace.
        self::$prefixDirsPsr4[$prefix] = array_merge(
            (array) $paths,
            self::$prefixDirsPsr4[$prefix]
            );
    } else {
            // Append directories for an already registered namespace.
        self::$prefixDirsPsr4[$prefix] = array_merge(
            self::$prefixDirsPsr4[$prefix],
            (array) $paths
            );
    }
}

    // 注册自动加载机制
public static function register($autoload = '')
{
        // 注册系统自动加载
    spl_autoload_register($autoload ?: 'Loader::autoload', true, true);
        // 注册命名空间定义
    self::addNamespace([
        'library'  => LIB_PATH,
        'vendor'   => VENDOR_PATH,
        'extend'   => EXTEND_PATH,
        'controller' => APP_PATH . 'controller' .DS,
        'model'    => APP_PATH . 'model' .DS,
        'applib'   => APP_PATH . 'library' .DS,
        ]);
        // 加载类库映射文件
    if (is_file(RUNNEED_PATH . 'classmap' . EXT)) {
        self::addClassMap(__include_file(RUNNEED_PATH . 'classmap' . EXT));
    }
        // 加载类库关联文件
    if (is_file(RUNNEED_PATH . 'classrelative' . EXT)) {
        self::addClassRelative(__include_file(RUNNEED_PATH . 'classrelative' . EXT));
    }

    // 自动加载extend目录
    self::$fallbackDirsPsr4[] = rtrim(EXTEND_PATH, DS);
}

    /**
     * 导入所需的类库 同java的Import 本函数有缓存功能
     * @param string $class   类库命名空间字符串
     * @param string $baseUrl 起始路径
     * @param string $ext     导入的文件扩展名
     * @return boolean
     */
    public static function import($class, $baseUrl = '', $ext = EXT)
    {
        static $_file = [];
        $key          = $class . $baseUrl;
        $class        = str_replace(['.', '#'], [DS, '.'], $class);
        if (isset($_file[$key])) {
            return true;
        }

        if (empty($baseUrl)) {
            list($name, $class) = explode(DS, $class, 2);

            if (isset(self::$prefixDirsPsr4[$name . '\\'])) {
                // 注册的命名空间
                $baseUrl = self::$prefixDirsPsr4[$name . '\\'];
            } elseif ('@' == $name) {
                //加载当前模块应用类库
                $baseUrl = App::$modulePath;
            } elseif (is_dir(EXTEND_PATH . $name)) {
                $baseUrl = EXTEND_PATH . $name . DS;
            } else {
                // 加载其它模块的类库
                $baseUrl = APP_PATH . $name . DS;
            }
        } elseif (substr($baseUrl, -1) != DS) {
            $baseUrl .= DS;
        }
        // 如果类存在 则导入类库文件
        if (is_array($baseUrl)) {
            foreach ($baseUrl as $path) {
                $filename = $path . DS . $class . $ext;
                if (is_file($filename)) {
                    break;
                }
            }
        } else {
            $filename = $baseUrl . $class . $ext;
        }

        if (!empty($filename) && is_file($filename)) {
            // 开启调试模式Win环境严格区分大小写
            if (IS_WIN && pathinfo($filename, PATHINFO_FILENAME) != pathinfo(realpath($filename), PATHINFO_FILENAME)) {
                return false;
            }
            __include_file($filename);
            $_file[$key] = true;
            return true;
        }
        return false;
    }

    /**
     * 字符串命名风格转换
     * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
     * @param string  $name 字符串
     * @param integer $type 转换类型
     * @param bool    $ucfirst 首字母是否大写（驼峰规则）
     * @return string
     */
    public static function parseName($name, $type = 0, $ucfirst = true)
    {
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);
            return $ucfirst ? ucfirst($name) : lcfirst($name);
        } else {
            return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
        }
    }

    /**
     * 解析应用类的类名
     * @param string $module 模块名
     * @param string $layer  层名 controller model ...
     * @param string $name   类名
     * @param bool   $appendSuffix
     * @return string
     */
    public static function parseClass($module, $layer, $name, $appendSuffix = false)
    {
        $name  = str_replace(['/', '.'], '\\', $name);
        $array = explode('\\', $name);
        $class = self::parseName(array_pop($array), 1) . (App::$suffix || $appendSuffix ? ucfirst($layer) : '');
        $path  = $array ? implode('\\', $array) . '\\' : '';
        return App::$namespace . '\\' . ($module ? $module . '\\' : '') . $layer . '\\' . $path . $class;
    }

    /**
     * 初始化类的实例
     * @return void
     */
    public static function clearInstance()
    {
        self::$instance = [];
    }
}

/**
 * 作用范围隔离
 *
 * @param $file
 * @return mixed
 */
function __include_file($file)
{
    return include $file;
}

function __require_file($file)
{
    return require $file;
}
