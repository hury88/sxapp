<?php
require './include/common.inc.php';
require WEB_ROOT.'./include/chkuser.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>网站信息</title>
  <link href="images/common.css" rel="stylesheet" type="text/css" />
  <link href="images/style.css" rel="stylesheet" type="text/css" />
  <script src="/public/tools/js/jquery.js" language="javascript"></script>
  <script src="js/js.js" language="javascript"></script>
  <script src="js/checkform.js" language="javascript"></script>
  <link rel="stylesheet" href="/public/ui/layui/css/layui.css"  media="all">
  <script src="/public/ui/layer/layer.js" language="javascript"></script>
</head>

<body  style="background-color:#f1f9ff;">

  <ul class="yiji clr">

    <?php if ($_SESSION['Admin_BigMyMenu']=="guwen"){?>
    <li class="yiji_li">
      <a href="javascript:void(0);" class="yiji_a">评论</a>
      <ul class="erji clr">
        <li ><a data-index="0" class="menua" href="pinglun.php?id=<?php echo $_SESSION['Admin_UserID']?>" target="righthtml">评论</a></li>
      </ul>
    </li>
    <?php }else {
      if ($_SESSION['Admin_BigMyMenu']=="super")
        $data1 = M('news_cats')->where('pid=0 AND isstate=1')->order('disorder desc,id asc')->select();
      else
        $data1 = M('news_cats')->where(array('pid'=>0,'isstate'=>1,'id'=>array('in',$_SESSION['Admin_BigMyMenu'])))->order('disorder desc,id asc')->select();

              //循环一级分类
      foreach ($data1 as $key1 => $bd1) {
        $pid=$bd1['id'];
        ?>
        <li class="yiji_li">
          <a href="javascript:void(0);" class="yiji_a"><?php echo cutstr($bd1['catname'],12,'')?></a>
          <ul class="erji clr" style="display:none">
            <?php
            ////循环二级分类
            if ($_SESSION['Admin_BigMyMenu']=="super"){
              $data2 = M('news_cats')->where(array('pid'=>$pid,'isstate'=>1))->order('disorder desc,id asc')->select();
            }else{
              $data2 = M('news_cats')->where(array('pid'=>$pid,'isstate'=>1,'id'=>array('in',$_SESSION['Admin_SmallMyMenu'])))->order('disorder desc,id asc')->select();
            }
            $m=0;
            foreach ($data2 as $key2 => $bd2) {
              $m++;
                //echo $showtype;
              $ppid=$bd2['id'];
              $showtype=$bd2['showtype'];
              if(!empty($bd2['linkurl']))
                $linkurl = $bd2['linkurl'];
              else
                $linkurl = getUrl(array('pid'=>$bd2['pid'],'ty'=>$bd2['id']),Config::get('webarr.showtype2')[$showtype]);


              // $counts=get_son_count($ppid);
              $counts=M('news_cats')->where("pid=$ppid and isstate=1")->count();
              if ($counts>0) $linkurl="javascript:void(0);"; else $linkurl=$linkurl;
              ?>
              <li ><a data-index="0" class="menua" href="<?php echo $linkurl?>" title="<?php echo $bd2['catname'],'-',$bd2['pid'],':',$bd2['id'] ?>" target="righthtml"><?php echo cutstr($bd2['catname'],20,'')?></a></li>

              <?php
                  //////循环三级分类
              if ($_SESSION['Admin_BigMyMenu']=="super")
                $data3 = M('news_cats')->where(array('pid'=>$ppid,'isstate'=>1))->order('disorder desc,id asc')->select();
              else
                $data3 = M('news_cats')->where(array('pid'=>$ppid,'showtype'=>array('neq',5),'isstate'=>1,'id'=>array('in',$_SESSION['Admin_SmallMyMenu'])))->order('disorder desc,id asc')->select();
              foreach ($data3 as $key3 => $bd3) {
                $showtype2=$bd3['showtype'];
                if(!empty($bd3['linkurl']))
                  $linkurl2=$bd3['linkurl'];
                else
                  $linkurl2 = getUrl(array('pid'=>$pid,'ty'=>$ppid,'tty'=>$bd3['id']),Config::get('webarr.showtype2')[$showtype]);
                ?>
                <li class="pro_type2" style="padding-left:20px;"><a href="<?php echo $linkurl2?>" target="righthtml"><?php echo $bd3['catname']?></a></li>
                <?php }//三级循环结束?>
                <?php }//二级循环结束?>

              </ul>
            </li>
            <?php }//一级循环结束?>

            <?php if (false): //是否为纯静态?>
           <li class="yiji_li">
             <a href="javascript:void()" class="yiji_a">PC纯静态入口</a>
             <ul class="erji clr">
               <li><a href="../make_html_index.php" target="righthtml">首页生成</a><i></i></li>
               <li><a href="../make_controller.php?action=2" target="righthtml">栏目生成</a><i></i></li>
               <li><a href="../make_controller.php?action=3" target="righthtml">内容生成</a><i></i></li>
             </ul>
           </li>
            <!-- <li class="yiji_li">
                <a href="javascript:void()" class="yiji_a">WAP纯静态入口</a>
                <ul class="erji clr">
                  <li><a href="../m/static/make_html_index.php" target="righthtml">首页生成</a><i></i></li>
                  <li><a href="../m/static/make_xml.php" target="righthtml">XML生成</a><i></i></li>
                  <li><a href="../m/static/controller.php?action=2" target="righthtml">栏目生成</a><i></i></li>
                  <li><a href="../m/static/controller.php?action=3" target="righthtml">内容生成</a><i></i></li>
                </ul>
            </li> -->
          <?php endif ?>

          <?php if($_SESSION['is_hidden']==true){?>
          <li class="yiji_li">
            <a href="javascript:void(0);" class="yiji_a">系统功能</a>
            <ul class="erji clr tt">
              <li><a href="class_cat.php" target="righthtml">栏目管理</a></li>
              <li><a href="manager.php" target="righthtml">管理员信息</a></li>
              <?php if (! cookie('web_manage_init1')): ?>
                <li><a href="tool/insert.php" target="righthtml">1.批量添加二级</a></li>
              <?php endif ?>
              <?php if (! cookie('web_manage_init2')): ?>
                <li><a href="tool/ControllerGeneration.php" target="righthtml">2.初始化</a></li>
              <?php endif ?>
              <li><a href="tool/codeCreate.php" target="righthtml">3.代码生成</a></li>
              <li><a href="/public/yesfinder/fullscreen.html" target="righthtml">图片管理</a></li>
              <li><a href="cankao.php" target="righthtml">参考写法</a></li>
              <li><a href="log.php" target="righthtml">操作日志</a></li>
              <li><a href="delete.php" target="righthtml">信息删除</a></li>
            </ul>
          </li>
          <?php }?>
          <?php } ?>
        </ul>
      </div>
      <input id="zIndexOffset" type="hidden" value="19891093">
      <script type="text/javascript" src="/public/ui/layer/layerSilica.js"></script>
      <script>
        var _ls = layerSilica;
        $('.tt a').click(function(){
            // $('li.erji_hover').removeClass('erji_hover');
            // $(this).parent('li').addClass('erji_hover');
            href = this.href;
            text = $(this).text();
            right = _ls.getFrameWinBy('righthtml', top);
            layerIndexDomName = 'layui-layer'+$(this).data('layerid');
            zIndexOffset = $('#zIndexOffset').val();
            zIndexOffset++;
            $('#zIndexOffset').val(zIndexOffset)
            // console.log(window.parent.document.getElementsByTagName('frame')[2].getElementsByTagName('div'));
            var theIndex = right.layer.open({
                  type: 2,
                  title: text,
                  shadeClose: true,
                  anim: 1,
                  resize: true,
                  shade: false,
                  moveOut: true,
                  maxmin: true, //开启最大化最小化按钮
                  area: ['100%', '100%'],
                  content: href
                });
              $(this).data('layerid',theIndex);
                return false;
        })
      </script>


    </body>
    </html>
