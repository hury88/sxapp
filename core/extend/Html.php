<?php
/**
  功能：生成静态页面
  日期：2013-2-16
*/
class Html{
	var $dir; //dir for the htmls(without/)
	var $rootdir; //root of html files(without/):html
	var $name; //html文件存放路径
	var $dirname; //指定的文件夹名称
	var $url; //获取html文件信息的来源网页地址
	var $time; //html文件信息填加时的时间
	var $dirtype; //目录存放方式:year,month,,,,
	var $nametype; //html文件命名方式:name
	public $array   = array(); //数组
	public $strings = ''; //临时内容

	public function __construct($nametype='name',$dirtype='year',$rootdir='html'){
		$this->rootdir=$rootdir;
		$this->dirtype=$dirtype;
		$this->nametype=$nametype;
	}

	function getdir($dirname='',$time=0)
	{
		$this->time=$time?$time:$this->time;
		$this->dirname=$dirname?$dirname:$this->dirname;
		switch($this->dirtype)
		{
			case 'name':
			if(empty($this->dirname))
				$this->dir=$this->rootdir;
			else
				$this->dir=$this->rootdir.'/'.$this->dirname;
			break;
			case 'year':
			$this->dir=$this->rootdir.'/'.date("Y",$this->time);
			break;
			case 'month':
			$this->dir=$this->rootdir.'/'.date("Y-m",$this->time);
			break;
			case 'day':
			$this->dir=$this->rootdir.'/'.date("Y-m-d",$this->time);
			break;
		}
		$this->createdir();
		return $this->dir;
	}

	function geturlname($url='')
	{
		$this->url=$url?$url:$this->url;
		$filename=basename($this->url);
		$filename=explode(".",$filename);
		return $filename[0];
	}

	function geturlquery($url='')
	{
		$this->url=$url?$url:$this->url;
		$durl=parse_url($this->url);
		$durl=explode("&",$durl[query]);
		foreach($durl as $surl)
		{
			$gurl=explode("=",$surl);
			$eurl[]=$gurl[1];
		}
		return join("_",$eurl);
	}

	function getname($url='',$time=0,$dirname='')
	{
		$this->url=$url?$url:$this->url;
		$this->dirname=$dirname?$dirname:$this->dirname;
		$this->time=$time?$time:$this->time;
		$this->getdir();
		switch($this->nametype)
		{
			case 'name':
			$filename=$this->geturlname().'.htm';
			$this->name=$this->dir.'/'.$filename;
			break;
			case 'time':
			$this->name=$this->dir.'/'.$this->time.'.htm';
			break;
			case 'query':
			$this->name=$this->dir.'/'.$this->geturlquery().'.htm';
			break;
			case 'namequery':
			$this->name=$this->dir.'/'.$this->geturlname().'-'.$this->geturlquery().'.htm';
			break;
			case 'nametime':
			$this->name=$this->dir.'/'.$this->geturlname().'-'.$this->time.'.htm';
			break;
		}
		return $this->name;
	}

	function createhtml($url='',$time=0,$dirname='',$htmlname='')
	{
		$this->url=$url?$url:$this->url;
		$this->dirname=$dirname?$dirname:$this->dirname;
		$this->time=$time?$time:$this->time;
	//上面保证不重复地把变量赋予该类成员
		if(empty($htmlname))
			$this->getname();
		else
	$this->name=$dirname.'/'.$htmlname; //得到name
	$content=file($this->url) or die("Failed to open the url ".$this->url." !");;
	///////////////关键步---用file读取$this->url
	$content=join("",$content);
	$fp=@fopen($this->name,"w") or die("Failed to open the file ".$this->name." !");
	if(@fwrite($fp,$content))
		return true;
	else
		return false;
	fclose($fp);
	}
	/////////////////以name为名字生成html
	function deletehtml($url='',$time=0,$dirname='')
	{
		$this->url=$url?$url:$this->url;
		$this->time=$time?$time:$this->time;
		$this->getname();
		if(@unlink($this->name))
			return true;
		else
			return false;
	}
	/**
	* function::deletedir()
	* 删除目录
	* @param $file 目录名(不带/)
	* @return
	*/
	function deletedir($file)
	{
		if(file_exists($file))
		{
			if(is_dir($file))
			{
				$handle =opendir($file);
				while(false!==($filename=readdir($handle)))
				{
					if($filename!='.'&&$filename!='..')
						$this->deletedir($file."/".$filename);
				}
				closedir($handle);
				rmdir($file);
				return true;
			}else{
				unlink($file);
			}
		}
	}


	public function open($url){
		$this->strings = file_get_contents($url);
		return $this;
	}
	public function string($string){
		$this->strings = $string;
		return $this;
	}
	//保存
	public function save($save=''){
		if (empty($save)) {
			$save = $this->dir;
		}
		$result = file_put_contents($save,$this->strings);
		$this->strings = '';
		return $result ? true : false;
	}
	//保存
	public function saftSave($save=''){
		if (empty($save)) {
			$save = $this->dir;
		}
		$result = false;
		if (! is_file($save)) {
			$result = file_put_contents($save,$this->strings);
		}
		$this->strings = '';
		return $result ? true : false;
	}
	//创建目录
	public function createdir($dir='')
	{
		$this->dir = $dir;
		$dir = dirname($dir);
		if (!is_dir($dir))
		{
			mkdir($dir,0777,true);
		}
		return $this;
	}

	public function creatFile($save = '../index.html'){
		$result = $this->save($save);
		/*if($result){
			self::echoString($word . '生成成功');
		}else{
			self::echoString($word . '生成失败!');
		}*/
	}


	//获取栏目列表
	public function getClassListPid($where='pid=0 and isstate=1 and catname<>"辅助栏目"'){//11,35
		?>
	<select name="ClassID[]" size="10" multiple style="width:260px;height:auto">
		<?php

		$pdata = M('news_cats')->where($where)->order('disorder asc,id asc')->getField('id,catname');

		foreach ($pdata as $pid => $pname) {
				?>
					<optgroup label="<?=$pname?>"></optgroup>
					<!-- <option value="<?=$pid?>">&nbsp;&nbsp;├<?=$pname?></option> -->
				<?php
				$data = M('news_cats')->where("pid = $pid")->getField('id,catname');
				foreach ($data as $ty => $tyname) {
					// if(in_array($ty, [9,32,31]))continue;
					?>
						<option value="<?=$ty?>">&nbsp;&nbsp;├<?=$tyname?></option>
					<?php
				}
	 	}
	 	?>
	 </select>
	 	<?php
		unset($pdata,$pid,$pname,$data,$ty,$tyname);
	}

	//获取内容列表
	public function getClassList($where='pid=0 and isstate=1 and showtype<>2 and catname<>"辅助栏目"'){
		?>
	<select name="ClassID[]" size="10" multiple style="width:260px;height:300">
		<?php

		$pdata = M('news_cats')->where($where)->order('disorder desc,id asc')->getField('id,catname');

		foreach ($pdata as $pid => $pname) {
			?>
				<optgroup label="<?=$pname?>"></optgroup>
			<?php
			$data = M('news_cats')->where("pid = $pid")->order('disorder desc,id asc')->getField('id,catname');
			foreach ($data as $ty => $tyname) {
				// if(in_array($ty, [9,32,31]))continue;
				?>
					<option value="<?=$ty?>">&nbsp;&nbsp;├<?=$tyname?></option>
				<?php
			}
	 	}
	 	?>
	 </select>
	 	<?php
		unset($pdata,$pid,$pname,$data,$ty,$tyname);
	}


	public static function echoString($string){
		echo $string;
		ob_flush();
		flush();
	}
}
?>