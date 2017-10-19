<?php
/* +----------------------------------------------------------------------
*  hury 2017年5月7日14:28:38
*  +----------------------------------------------------------------------
*  后端打印html标签类 打印表单 编辑器 上传文件
*  +----------------------------------------------------------------------
*/
class Style{

	public static function weizhi()
	{
		global $classname;
		if ($classname)
		echo '<div class="weizhi">
	            <p>位置：
	                <a href="mains.php">首页</a>
	                <span>></span>
	                ' . $classname . '
	            </p>
	        </div>';
	}

	public static function output()
	{
		echo <<<STYLE
		<style>
		/*textarea,input{color:#000; border-color:rgba(77,144,222,.5)!important; }*/
			/*textarea,input,select{color:#000; border-color:rgba(0,0,0,1)!important; }*/
			.site-demo-upload {
			    position: relative;
			    background: #e2e2e2;
			    margin-bottom: 50px;
			    /*overflow:hidden;*/
			}
			.site-demo-upload, .site-demo-upload img {
			    width: 200px;
			    height: 200px;
			    border-radius: 100%;
			    border:1px solid #000;
			}
			.site-demo-upload .site-demo-upbar {
			    position: absolute;
			    top: 50%;
			    left: 50%;
			    margin: -18px 0 0 -56px;
			}
			.site-demo-upload .layui-upload-button {
			    background-color: rgba(0,0,0,.2);
			    color: rgba(255,255,255,1);
			}
			.layui-upload-button {
			    position: relative;
			    display: inline-block;
			    vertical-align: middle;
			    min-width: 60px;
			    height: 38px;
			    line-height: 38px;
			    border: 1px solid #DFDFDF;
			    border-radius: 2px;
			    overflow: hidden;
			    background-color: #fff;
			    color: #666;
			}
			.layui-upload-button input {
			    position: absolute;
			    left: 0;
			    top: 0;
			    z-index: 10;
			    font-size: 100px;
			    width: 100%;
			    height: 100%;
			}
			.layui-upload-button input, .layui-upload-file {
			    opacity: .01;
			    filter: Alpha(opacity=1);
			    cursor: pointer;
			}
			b{display:inline-block;color: #ea2020; padding-left: 3px;}
		</style>
STYLE;
	}

	public static function submitButton()
    {
    	echo <<<STYLE
    	<div class="layui-form-item">
    		<div class="layui-input-block">
    			<button class="datasubmit layui-btn" style="background-color:#2964ad"  lay-submit="" lay-filter="demo1">立即提交</button>
    			<button type="reset" class="layui-btn layui-btn-primary">重置</button>
    			<a href="javascript:window.location.reload();" class="layui-btn layui-btn-primary"><i class="layui-icon"> ဂ</i></a>
    			<a href="javascript:history.go(-1);" class="layui-btn layui-btn-primary">←</a>
    			<a href="javascript:history.go(1);" class="layui-btn layui-btn-primary">→</a>
    		</div>
    	</div>
STYLE;
	}

	public static function moveback()
    {
    	echo <<<STYLE
<a style="margin-left:2px;width:30px;height:32px;background:none;border:1px solid rgba(0,0,0,.3);line-height:32px;text-align:center" href="javascript:history.go(-1)" class="fl">←</a>
<a style="width:30px;height:32px;background:none;border:1px solid rgba(0,0,0,.3);line-height:32px;text-align:center" href="javascript:history.go(1)" class="fl">→</a>
STYLE;
	}
}