<?php


//额外需要的配置

return array(

		'REQUEST_VARS_FILTER' => 1//开启全局安全过滤
		,'ROOT_PATH' => dirname(dirname(dirname(dirname(__FILE__))))
		,'DEBUG'     => 1//开启调试模式 上线后关闭
		,'IS_STATE'  => 1
		,'UPLOAD'	=> '/uploadfile/upload/'

		,'NOPIC'     => 'nopic.jpg'//图片不存在时显示
		,'WATERMARK' => dirname(dirname(dirname(dirname(__FILE__)))).'/uploadfile/upload/water.png'//水印图

		//日志配置
		,'LOG_PATH'  => '/include/Common/Logs/'
		,'LOG_RECORD'=>  true  // 进行日志记录
		,'LOG_FILE_SIZE'     =>  2097152
		//数据库配置信息
		,'HR' => null// 数据库实例

		//全局函数中的配置
		,'VAR_AUTO_STRING' => true // 大 I函数 默认强转的类型 (string)

		,'DEFAULT_FILTER'  =>  'htmlspecialchars' // 默认参数过滤方法 用于I函数...

		,'REWRITE' => false //重写


		//一些插件
		,"VENDER"=> "include/Common/Vender/"//插件地址

		,"URL_MD5" => '-hury-88-' //地址参数加密 可以更换为其它的加密标记，可以自由发挥
		,

		);
