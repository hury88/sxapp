<?php
class TplParser {

    // 字段，接收模版文件内容
    private $_tpl;

    // 构造方法，获取模版文件内容
    public function __construct($_tplFile)
    {
      if (! $this->_tpl = file_get_contents($_tplFile)) {
        exit('ERROR:模版文件读取错误');
      }
    }

    // 解析普通变量
    private function parvar()
    {
      $_patten_const = '/\{\{([\w]+)\}\}/';
      $_patten_var = '/\{\{\$([\w]+)(.*?)\}\}/';
      $_patten_vars = '/\{\{\$([\w]+)[\.]([\w]+)\}\}/';
      $_patten_global = '/\{\{global \$([\w]+)(->[\w]+)?\}\}/';
      // $_patten_config = '/\{\{config\(\$(.+?)\)\}\}/';
      if (preg_match($_patten_global,$this->_tpl)) {
        $this->_tpl = preg_replace($_patten_global, "<?php echo \$GLOBALS['$1']$2;?>",$this->_tpl);
      }
      if (preg_match($_patten_const,$this->_tpl)) {
        $this->_tpl = preg_replace($_patten_var, "<?php echo \$$1;?>",$this->_tpl);
      }
      if (preg_match($_patten_var,$this->_tpl)) {
        $this->_tpl = preg_replace($_patten_var, "<?php echo \$this->_vars['$1']$2;?>",$this->_tpl);
      }
      if (preg_match($_patten_vars,$this->_tpl)) {
        $this->_tpl = preg_replace($_patten_vars, "<?php echo \$this->_vars['$1']['$2'];?>",$this->_tpl);
      }
      /*// 解析config变量 兼容二维调用
      if (preg_match($_patten_config,$this->_tpl)) {
        $this->_tpl = preg_replace($_patten_config, "<?php echo config('$1');?>",$this->_tpl);
      }*/
    }

    // 解析普通变量
    private function parfunc()
    {
      $_patten = '/\{\{(.*?\))\}\}/';
      if (preg_match($_patten,$this->_tpl)) {
        $this->_tpl = preg_replace($_patten, "<?php echo $1;?>",$this->_tpl);
      }
    }

    //解析IF语句
    private function parif(){
      $_pattenif = '/\{\{if\s+([!]?)\$([\w]+)\}\}/';
      $_pattenElse = '/\{\{else\}\}/';
      $_pattenEndif = '/\{\{\/if\}\}/';
      if (preg_match($_pattenif,$this->_tpl)) {
        if (preg_match($_pattenEndif,$this->_tpl)) {
          $this->_tpl = preg_replace($_pattenif,"<?php if ($1\$this->_vars['$2']){?>",$this->_tpl);
          $this->_tpl = preg_replace($_pattenEndif,"<?php } ?>",$this->_tpl);
          if (preg_match($_pattenElse,$this->_tpl)) {
            $this->_tpl = preg_replace($_pattenElse,"<?php }else{?>",$this->_tpl);
          }
        }else{
          echo 'ERROR:IF语句没有关闭！';
        }
      }
    }

    //PHP注释解析

    private function parCommon(){
      $_pattenCommon = '/\{\{#\}(.*)\{#\}\}/';
      if (preg_match($_pattenCommon,$this->_tpl)) {
        $this->_tpl = preg_replace($_pattenCommon,"<?php /* $1 */ ?>",$this->_tpl);
      }
    }

    //解析foreach语句
    private function parForeach(){
      $_pattenForeach = '/\{\{foreach\s+\$([\w]+)\(([\w]+),([\w]+)\)\}\}/';
      $_pattenForeachEnd = '/\{\{\/foreach\}\}/';
      $_pattenForeachValue = '/\{\{@([\w]+)(.*?)\}\}/';
      $_pattenForeachValue2 = '/\{\{(.*?)@([\w]+)(.*?\))\}\}/';
      if (preg_match($_pattenForeach,$this->_tpl)) {
        if (preg_match($_pattenForeachEnd,$this->_tpl)) {
          $this->_tpl = preg_replace($_pattenForeach, "<?php foreach (\$this->_vars['$1'] as \$$2=>\$$3) {@extract(\$$3);?>", $this->_tpl);
          $this->_tpl = preg_replace($_pattenForeachEnd, "<?php }?>", $this->_tpl);
          if (preg_match($_pattenForeachValue2, $this->_tpl)) {
            $this->_tpl = preg_replace($_pattenForeachValue2,'{{$1$$2$3}}',$this->_tpl);
          }
          if (preg_match($_pattenForeachValue, $this->_tpl)) {
            $this->_tpl = preg_replace($_pattenForeachValue,"<?php echo \$$1$2;?>",$this->_tpl);
          }
        }else{
          echo 'ERROR:Foreach语句没有关闭！';
        }
      }
    }

    //解析include方法
    private function parInclude(){
      $_pattenInclude = '/\{\{include\s+file=\"([\w\.\-]+)\"\}\}/';
      if (preg_match($_pattenInclude,$this->_tpl,$_file,$_file)) {
        if (!file_exists($_file[1])||empty($_file)) {
          echo 'ERROR:包含文件出错！';
        }
        $this->_tpl = preg_replace($_pattenInclude,"<?php include $1;?>",$this->_tpl);
      }
    }

    //解析replace方法
    private function parReplace(){
      $_pattenInclude = '/\{\{replace\s+file=\"(.+?)\"\}\}/';
      if (preg_match_all($_pattenInclude,$this->_tpl,$_file,$_file)) {
        foreach ($_file[0] as $key => $search) {
              eval("\$rplfile={$_file[1][$key]};");
          if (file_exists($rplfile)) {
              $this->_tpl = str_replace($search, file_get_contents($rplfile), $this->_tpl);
          } else {
            exit('ERROR:包含文件出错！');
          }
        }
      }
    }

    //解析系统变量方法
    private function parConfig(){
      $_pattenConfig = '/\{\{([\w]+)\}\}/';
      if (preg_match($_pattenConfig,$this->_tpl)) {
        $this->_tpl = preg_replace($_pattenConfig,"<?php echo config('$1');?>",$this->_tpl);
      }
    }
    // 对外公共方法
    public function compile($_path)
    {
      // 解析模版文件
      $this->parReplace();
      $this->parForeach();
      $this->parif();
      $this->parfunc();
      $this->parvar();
      $this->parInclude();
      $this->parCommon();
      $this->parConfig();
      // 生成编译文件
      if (! file_put_contents($_path, $this->_tpl)) {
        exit('ERROR:编译文件生成错误！');
      }
    }

}
