<?php
class KWAction {
    /**
     * @var string 视图名称
     */
    private $view;
    private $params;
    private $objects;
    private $_vars = [];
    protected $_data;

    private $config;

    /**
     * @param $view
     * @param array $params
     * @param array $objects 直接引用对象
     */
    public function __construct(/*$view, $params=[], $objects=[]*/)
    {/*
        $this->view = $view;
        $this->params = $params;
        $this->objects = $objects;*/
    }

    /**
     * 获取Service|DAO
     * @param $obj
     * @return TXService | TXDAO
     */
    public function __get($obj)
    {
        if (substr($obj, -5) == 'Model') {
            $class = substr($obj, 0, -5);
            if (defined("$class::TABLE")) {
              return M($class::TABLE);
            } elseif(table_exists(lcfirst($class))) {
              return M(lcfirst($class));
            } else {
              E("`$class`类未定义表名称");
            }
        } else {
          return isset($this->_data[$obj]) ? $this->_data[$obj] : null;
        }
    }

    //assign()方法，用于注入变量
    protected function assign($_var,$_value=null){
      //$_var用于同步模版里的变量名
      //$_value表示值
      if (is_array($_var)) {
        $this->_vars = array_merge($this->_vars, $_var);
      } elseif (isset($_var)&&!empty($_var)) {
        $this->_vars[$_var] = $_value;
      }else{
        exit('ERROR:设置模版变量！');
      }

    }

    //display()方法
    protected function display($_file)
    {
        //include template
        $_tplFile = TPL_PATH . $_file .'.html';
        // 判断文件是否存在
        if (! file_exists($_tplFile)) {
           exit('ERROR:模版文件不存在！');
        }
        //生成编译文件
        $_path = RUN_PATH . strtr($_file, '/', '_').'-'.md5($_file).'.php';
        //缓存文件
        // $_cacheFile = CACHE.md5($_file).'-'.$_file.'.html';
        //当第二次运行相同文件，直接载入缓存文件
        if ( config('app_debug') || !file_exists($_path) ) {
            $_parser = new TplParser($_tplFile);
            $_parser->compile($_path);
        }
        include $_path;
    }

    public function redirect($route, $arg=[])
    {
        header('Location:' . U($route, $arg));
        exit();
    }
}
