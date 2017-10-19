<?php

/**

* 通用的树型类，可以生成任何树型结构

*/



class tree{

	/**

	* 生成树型结构所需要的2维数组

	*/

	var $arr = array();



	/**

	* 生成树型结构所需修饰符号，可以换成图片

	*/

	var $icon = array('│','├','└');



	/**

	* @access private

	*/

	var $ret = '';



	/**

	* 构造函数，初始化类

	* @param array 2维数组，例如：

	* array(

	*      1 => array('id'=>'1','pid'=>0,'Art'=>'一级栏目一'),

	*      2 => array('id'=>'2','pid'=>0,'Art'=>'一级栏目二'),

	*      3 => array('id'=>'3','pid'=>1,'Art'=>'二级栏目一'),

	*      4 => array('id'=>'4','pid'=>1,'Art'=>'二级栏目二'),

	*      5 => array('id'=>'5','pid'=>2,'Art'=>'二级栏目三'),

	*      6 => array('id'=>'6','pid'=>3,'Art'=>'三级栏目一'),

	*      7 => array('id'=>'7','pid'=>3,'Art'=>'三级栏目二')

	*      )

	*/

	function get_tree($pid,$categorys,$str){

		$this->tree($categorys);

		$categorys=$this->get_show($pid,$str);

		return $categorys;

	}



	function tree($arr=array()){

       $this->arr = $arr;

	   $this->ret = "";

	   return is_array($arr);

	}



    /**

	* 得到父级数组

	*/

	function get_parent($myid){

		$newarr = array();

		if(!isset($this->arr[$myid])) return false;

		$pid = $this->arr[$myid]['pid'];

		$pid = $this->arr[$pid]['pid'];

		if(is_array($this->arr)){

			foreach($this->arr as $id => $a){

				if($a['pid'] == $pid) $newarr[$id] = $a;

			}

		}

		return $newarr;

	}



    /**

	* 得到子级数组

	*/

	function get_child($myid){

		$a = $newarr = array();

		if(is_array($this->arr)){

			$i=0;

			foreach($this->arr as $id => $a){

				if($a['pid'] == $myid){

					$newarr[$i] = $a;

					$i++;

				}

			}

		}

		return $newarr ? $newarr : false;

	}



    /**

	* 得到当前位置数组

	*/

	function get_pos($myid,&$newarr){

		$a = array();

		if(!isset($this->arr[$myid])) return false;

        $newarr[] = $this->arr[$myid];

		$pid = $this->arr[$myid]['pid'];

		if(isset($this->arr[$pid])){

		    $this->get_pos($pid,$newarr);

		}

		if(is_array($newarr)){

			krsort($newarr);

			foreach($newarr as $v){

				$a[$v['id']] = $v;

			}

		}

		return $a;

	}



    /**

	* 得到树型结构

	* @param int id，表示获得这个id下的所有子级

	* @param string 生成树型结构的基本代码，例如："<option value=\$id \$selected>\$spacer\$name</option>"

	* @param int 被选中的id，比如在做树型下拉框的时候需要用到

	*/

	function get_show($myid,$str,$sid=0,$adds=''){

		$number=1;

		$child = $this->get_child($myid);

		if(is_array($child)){

		    $total = count($child);

			foreach($child as $id=>$a){

				$j=$k='';

				if($number==$total){

					$j .= $this->icon[2];

				}else{

					$j .= $this->icon[1];

					$k = $adds ? $this->icon[0] : '';

				}

				$spacer = $adds ? $adds.$j : '';

				//$selected = $id==$sid ? "selected" : '';

				@extract($a);

				eval("\$nstr = \"$str\";");

				$this->ret .= $nstr;

				$this->get_show($a['id'],$str,$sid,$adds.$k.'&nbsp;&nbsp;&nbsp;');

				$number++;

			}

		}

		return $this->ret;

	}

}

?>