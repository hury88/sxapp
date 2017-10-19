<?php

//树型  适用于 下拉,面包屑
//$tree = new Tree($data);
//下拉实例
/*
+   $cate = $tree->spanning();
+   $dropdown =  '<select name="" id="">%s</select>';
+   while( list(,$v) = each($cate) ){
+   	$pre = str_repeat('∞', $v['level']);
+   	$option .= '<option value="'.$v['id'].'">'.$pre.$v['cat'].'</option>';
+   }
+   echo sprintf($dropdown,$option);

//面包屑实例
-   $cate = $tree->getParent(9);
-   while($arr = each($cate)){
-    	$nav .=  $arr['value']['cat'].' > '; }
-   echo trim($nav,'> ');
 */
class Tree{

	public  $arr = array();

	public static $flag = true;//用于在递归中执行一次

	public function __construct($arr){
		if(!is_array($arr))return;
		$this->arr = $arr;
	}


	/**
	 * [spanning 生成树,整理成有序 如 下拉菜单的显示]
	 * @param  [type]  $data   [description]
	 * @param  integer $pid    [description]
	 * @param  array   $resort [description]
	 * @return [type]          [description]
	 */
	public function spanning($pid=0,$level=0,$resort=array()){
		$arr = $this->arr;
		foreach ($arr as $v) {
			if( $v['pid'] == $pid ){
				$v['level'] = $level;
				$resort[] = $v;
				$resort = @array_merge($this->spanning($v['id'],$level+1,$resort));
			}
		};return $resort;

	}

	/**
	 * [getSon 获取当前的所有子类]
	 * @param  [type] $arr [description]
	 * @param  [type] $id  [当前id]
	 * @param  array  $son [description]
	 * @return [type]      [description]
	 */
	function getSon($id='',$son=array()){
		if(self::$flag){
			$son[] = $this->getRow($id,'array');
			self::$flag = false;
		}
		$arr = $this->arr;
		foreach ($arr as $v) {
			if($v['pid'] == $id){
				$son[] = $v;
				$son   = @array_merge($this->getSon($v['id'],$son));
			}
		};return $son;
	}

	/**
	 * [getParent 获取族谱]
	 * @param  [type] $pid    [当前id]
	 * @param  [type] $parent [description]
	 * @return [type]         [$parent]
	 */
	function getParent($id,$parent=array()){
		$arr = $this->arr;
		foreach ($arr as $v) {
			if($v['id'] == $id){
				$parent[] = $v;
				$parent = @array_merge($this->getParent($v['pid'],$parent));
			}
		};return $parent;
	}

	private function getRow($id,$a='array'){
		$arr = $this->arr;
		foreach ($arr as $index => $v) {
			if($v['id'] = $id){
				switch ($a) {
					case 'pid':
						return $v['pid'];
						break;
					default:
						return $v;
						break;
				}
			}
		}return false;
	}

}


?>