<?php
require './include/common.inc.php';
define('TABLE_NEWS',1);
require WEB_ROOT.'./include/chkuser.inc.php';
$table = $showname = 'order';
$map = array();
if(isset($_GET['order_status'])){
    $order_status=$_GET['order_status'];
    $map['order_status']=$order_status;
}
if(isset($_GET['shipping_status'])){
    $shipping_status=$_GET['shipping_status'];
    $map['shipping_status']=$shipping_status;
}

if($order_status==1&&$shipping_status==1){
    $
}elseif($order_status==0&&$shipping_status==1){
}else{
}
//条件

###########################筛选开始
$order_no    =   I('get.order_no','','trim');if(!empty($order_no))$map['order_no'] =$order_no;

//$title =   I('get.title','','trim');if(!empty($title))$map['title'] = array('like',"%$title%");
###########################筛选开始
########################分页配置开始
$psize   =   I('get.psize',30,'intval');
$pageConfig = array(
    /*条件*/'where' => $map,
    /*排序*/'order' => 'order_status asc,shipping_status asc,id desc',
    /*条数*/'psize' => $psize,
    /*表  */'table' => $table,
    );

list($data,$pagestr) = Page::paging($pageConfig);

########################分页配置结束
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<?php include('js/head'); ?>
</head>
<body>
	<div class="content clr">
        <div class="right clr">
          <form class="" id="jsSoForm">
            <b>显示</b><input style="width:50px;" name="psize" type="text" class="dfinput" value="<?=$psize?>"/>条
            订单号<input name="order_no" type="text" class="dfinput" value="<?=$order_no?>"/>
            <input name="search" type="submit" class="btn" value="搜索"/></td>
          </form>
          <div class="zhengwen clr">
             <div class="zhixin clr">
                <a href="?<?=queryString()?>" class="zhixin_a2 fl"></a>
             </div>
          </div>
          <div class="neirong clr">
    <table cellpadding="0" cellspacing="0" class="table clr">
       <tr class="first">
        <td width="24px">编号</td>
        <td width="45px"> 订单号 </td>
        <td> 买家会员名称</td>
        <td> 买家要求配送时间 </td>
        <td> 收货人姓名 </td>
        <td> 收货人手机号 </td>
        <td> 收货地址 </td>
        <td> 定单总价 </td>
        <td> 定单详情 </td>
        <td>订单状态(点击可改变状态不可逆)</td>
    <td width="135px">创建订单时间</td>
</tr>
<?php
    foreach ($data as $key => $bd) : extract($bd);
    if($order_status==1&&$shipping_status==1){
        $xorder_status="<a style='color:white;display: block;cursor:pointer;background: green;width: 70%;margin: 0 auto;text-align: center'>已完成</a>";
    }elseif($order_status==0&&$shipping_status==1){
        $xorder_status='<a style="color:white;background: rebeccapurple;width: 70%;margin: 0 auto;display: block;cursor: pointer;text-align: center" id="wc" title="点击完成订单">未完成已配送</a>';
    }else{
        $xorder_status='<a style="color:white;background: red;width: 70%;margin: 0 auto;display: block;cursor: pointer;text-align: center" id="ps" title="点击配送">未配送</a>';
    }
?>
<tbody>
    <tr>
        <td><?=$key+1?></td>
        <td><?=$order_no?></td>
        <td><?=$user_name?></td>
        <td><?=$shipping_time?></td>
        <td><?=$receiver_name?></td>
        <td><?=$receiver_mobile?></td>
        <td><?=$receiver_pcd?>-<?=$receiver_address?></td>
        <td><?=$goods_money?></td>
        <td><a href="order_detail.php?id=<?php echo $id;?>" target="righthtml">订单详情</a></td>
        <td><?=$xorder_status?></td>
        <td><?=$create_time?></td>
 </tr>
    <script type="text/javascript">
        $("#wc").click(function(){

        })
    </script>
<?php
    endforeach;
    define('DEL_TIME_SORT',1);
    include('js/foot');
 ?>


