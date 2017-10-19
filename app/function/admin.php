<?php
//这里放后台的函数

/**
 * [uppro 上传文件及图片]
 * @return [type] [description]
 */
function uppro($name,&$arr,$style='img',$water_path=''){

    $path = ROOT_PATH . Config::get('pic.upload');
    $delimg=isset($_POST[$name]) ? $_POST[$name] : '';
    if(!isset($_FILES[$name]))return '';
    $img_name = $_FILES[$name]['name'];
    $imgtype = explode(".", basename($img_name));
    $imgtype = end($imgtype);
    if($img_name){
        if (file_exists($path.$delimg)) @unlink($path.$delimg);
        $imgnewname=date("YmdHis").mt_rand(10,99).".".$imgtype;
        switch ($style) {
            case 'file':
                uploadfile($name,$path,$imgnewname);
                break;
            case 'water'://上传水印图片
                uploadwaterimg($name,$path,$imgnewname,$water_path);
                break;
            case 'ajax':
                uploadimgAjax($name,$path,$imgnewname);
                break;
            default:
                uploadimg($name,$path,$imgnewname);
                break;
        }
       return  $arr[$name]=$imgnewname;
    }
}

//图片上传
function uploadimgAjax($obj,$path,$name){
    global $system_pictype,$system_picsize;
    $picsAllowExt  = $system_pictype;                               //允许上传图片类型
    $picmax_thumbs_size=$system_picsize;                            //允许上传图片大小
    $picaExt = explode("|",$picsAllowExt);                          //图片文件
    $uppic=$_FILES[$obj]['name'];                                   //文件名称
    $thumbs_type=strtolower(substr($uppic,strrpos($uppic,".")+1));  //上传类型
    $thumbs_file=$_FILES[$obj]['tmp_name'];                         //临时文件
    $thumbs_size=$_FILES[$obj]['size'];                             //文件大小
    $imageinfo = getimagesize($thumbs_file);


    $upfile=$path.$name;
    if(in_array($thumbs_type,$picaExt)&&$thumbs_size>intval($picmax_thumbs_size)*1024){
        ajaxReturn(0,"图片上传大小超过上限:".ceil($picmax_thumbs_size/1024)."M！");
    }

    if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png' && $imageinfo['mime'] != 'image/bmp') {
        ajaxReturn(0,"非法图像文件！");
    }

    if(!in_array($thumbs_type,$picaExt)){
        ajaxReturn(0,"上传图片格式不对，请上传".$system_pictype."格式的图片！");
    }
    if (!is_writable($path)){
        //修改文件夹权限
        $oldumask = umask(0);
        mkdir($path,0777);
        umask($oldumask);
        ajaxReturn(0,"请确保文件夹的存在或文件夹有写入权限");
    }

    $imgsize = I('post.imgsize_' . $obj, '', 'trim');
    if($imgsize && strpos($imgsize, '*')) {
        list($w, $h) = explode('*', $imgsize, 2);
        $image = new Image();
        $result = $image->open($thumbs_file)->thumb($w, $h)->save($upfile);
    } else {
        $result = copy($thumbs_file,$upfile);
    }

    if(!$result){
        ajaxReturn(0,"上传失败!");
    }
}


//图片上传
function uploadimg($obj,$path,$name){
   global $system_pictype,$system_picsize;
   $picsAllowExt  = $system_pictype;                               //允许上传图片类型
   $picmax_thumbs_size=$system_picsize;                            //允许上传图片大小
   $picaExt = explode("|",$picsAllowExt);                          //图片文件
   $uppic=$_FILES[$obj]['name'];                                   //文件名称
   $thumbs_type=strtolower(substr($uppic,strrpos($uppic,".")+1));  //上传类型
   $thumbs_file=$_FILES[$obj]['tmp_name'];                         //临时文件
   $thumbs_size=$_FILES[$obj]['size'];                             //文件大小
   $imageinfo = getimagesize($thumbs_file);

    $upfile=$path.$name;
    if(in_array($thumbs_type,$picaExt)&&$thumbs_size>intval($picmax_thumbs_size)*1024){
        JsError("图片上传大小超过上限:".ceil($picmax_thumbs_size/1024)."M！");
        exit();
    }

    if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png' && $imageinfo['mime'] != 'image/bmp') {
        JsError("非法图像文件！");
        exit();
    }

    if(!in_array($thumbs_type,$picaExt)){
        JsError("上传图片格式不对，请上传".$System_Pictype."格式的图片！");
        exit();
    }
    if (!is_writable($path)){
        //修改文件夹权限
        $oldumask = umask(0);
        mkdir($path,0777);
        umask($oldumask);
        if(C('DEBUG'))$rePath=$path;
        JsError('请确保文件夹的存在或文件夹有写入权限!'.$rePath);
        exit();
    }
    if(!copy($thumbs_file,$upfile)){
        JsError('上传失败!');
        exit();
    };
}



//文件上传
function uploadfile($obj,$path,$name)
{
    global $system_filetype,$system_filesize;
    $filesAllowExt  = $system_filetype;                             //文件后缀
    $filemax_thumbs_size= $system_filesize;                         //文件大小
    $fileaExt = explode("|",$filesAllowExt);                        //图片文件
    $uppic=$_FILES[$obj]['name'];                                   //文件名称
    $thumbs_type=strtolower(substr($uppic,strrpos($uppic,".")+1));  //上传类型
    $thumbs_file=$_FILES[$obj]['tmp_name'];                         //临时文件
    $thumbs_size=$_FILES[$obj]['size'];                             //文件大小
    $imageinfo = getimagesize($thumbs_file);


    $upfile=$path.$name;
    if(in_array($thumbs_type,$fileaExt)&&$thumbs_size>intval($filemax_thumbs_size)*1024){
        ajaxReturn(0,"附件上传大小超过上限:".ceil($filemax_thumbs_size/1024)."M！");
    }
    /*
    if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png' && $imageinfo['mime'] != 'image/bmp') {
        ajaxReturn(0,"非法图像文件！");
        exit();
    }*/

    if(!in_array($thumbs_type,$fileaExt)){
        ajaxReturn(0,"上传附件格式不对，请上传".$system_filetype."格式文件！");
    }
    if (!is_writable($path)){
        //修改文件夹权限
        $oldumask = umask(0);
        mkdir($path,0777);
        umask($oldumask);
        if(Config::get('app_debug'))$rePath=$path;
        ajaxReturn(0,'请确保文件夹的存在或文件夹有写入权限!'.$rePath);
    }
    if(!copy($thumbs_file,$upfile)){
        ajaxReturn(0,'上传失败!');
    }
}

//图片上传
function uploadwaterimg($obj,$path,$name,$water_path){
    global $system_pictype,$system_picsize;
    $picsAllowExt  = $system_pictype;                               //允许上传图片类型
    $picmax_thumbs_size=$system_picsize;                            //允许上传图片大小
    $picaExt = explode("|",$picsAllowExt);                          //图片文件
    $uppic=$_FILES[$obj]['name'];                                   //文件名称
    $thumbs_type=strtolower(substr($uppic,strrpos($uppic,".")+1));  //上传类型
    $thumbs_file=$_FILES[$obj]['tmp_name'];                         //临时文件
    $thumbs_size=$_FILES[$obj]['size'];                             //文件大小
    $imageinfo = getimagesize($thumbs_file);


    $upfile=$path.$name;
    if(in_array($thumbs_type,$picaExt)&&$thumbs_size>intval($picmax_thumbs_size)*1024){
        JsError("图片上传大小超过上限:".ceil($picmax_thumbs_size/1024)."M！");
        exit();
    }

    if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png' && $imageinfo['mime'] != 'image/bmp') {
        JsError("非法图像文件！");
        exit();
    }

    if(!in_array($thumbs_type,$picaExt)){
        JsError("上传图片格式不对，请上传".$System_Pictype."格式的图片！");
        exit();
    }
    if (!is_writable($path)){
        //修改文件夹权限
        $oldumask = umask(0);
        mkdir($path,0777);
        umask($oldumask);
        JsError('请确保文件夹的存在或文件夹有写入权限!');
        exit();
    }

    R('Image')->open($thumbs_file)->water($water_path)->save($upfile);
}


//生成
function printInputHtml($lablename,$inputname,$type=0,$width='',$height='',$b=''){
    global $$inputname;
if($type){//textarea

    $width = $width   ?$width : '520';
    $height = $height ?$height : '100';
    echo '<li class="fade"><label title="'.$inputname.'">'.$lablename.'<b>*</b></label><textarea id="'.$inputname.'" name="'.$inputname.'" style="width:'.$width.'px;height:'.$height.'px;" class="dfinput" placeholder="'.$lablename.'...">'.$$inputname.'</textarea>'.$b.'</li>';

}else{
    $style='';
    $width = $width   ? "width:{$width}px;" : '';
    $height = $height ? "heigth:{$height}px;" : '';
    if($width || $height){
        $style = 'style=" '.$width.$height.' "';
    }
    echo '<li class="fade"><label title="'.$inputname.'">'.$lablename.'<b>*</b></label><input '.$style.' name="'.$inputname.'" type="text" class="shurukuang" value="'.$$inputname.'"/>'.$b.'</li>';
}
    unset($lablename,$inputname,$width,$height,$style,$type);

}

//生成img表单
function printImgHtml($lablename,$imgname,$ty,$type=0){
    global $$imgname;
    if(!$lablename || !$imgname) exit('图片或路径字段名为空');
    if(is_numeric($ty)){
        $py = getFieldValue($ty,"imgsize","news_cats");
    }else{
        $py = $ty;
    }
    if($type){
        $px = '<b>文件大小:'.getConfig('filesize').'k内,文件类型：'.getConfig('filetype').'</b>';
    }else{
        $px = '<b>图片大小: '.getConfig('picsize').' K内,'.$py.'px</b>';
    }
    $template = '<li class="fade"><label title="'.$imgname.'">%s<b>*</b></label>%s'.$px;
    if ($type) {//文件
        if ($$imgname) {
            $IMG = '<input name="'.$imgname.'" type="file"> <a href="'.C('UPLOAD').$$imgname.'" target="_blank">查看文件</a>';
        }else{
            $IMG = '<input name="'.$imgname.'" type="file">';
        }
    }else{//图片
        if ($$imgname) {
            $thisimg = C('UPLOAD').$$imgname;
            $IMG = '<input name="'.$imgname.'" type="file"> <a target="_blank" href="'.$thisimg.'"><img src="'.$thisimg.'" height="40" /></a><a href="'.C('UPLOAD').$$imgname.'" target="_blank">查看图片</a>';
        }else{
            $IMG = '<input name="'.$imgname.'" type="file">';
        }
    }
    $IMG .= '<input type="hidden" name="'.$imgname.'" value="'.$$imgname.'">';
    printf($template,$lablename,$IMG);
    unset($imgname,$lablename,$IMG,$template,$px,$thisimg);
}



//编辑器调用
function initEditor($name='content',$width = '667', $height = '350'){
    global $$name;
    $val  = htmlspecialchars_decode($$name);
    $editor="<textarea class=\"editor_id\" name=\"{$name}\" style=\"width:{$width}px;height:{$height}px;\">{$val}</textarea>";
    return $editor;
}

//编辑器调用
function printEditor($lablename,$name='content',$width = '667', $height = '350'){
    global $$name;
    $val  = htmlspecialchars_decode($$name);
    ECHO '<li class="fade"><label style="font-size:10px">'.$lablename.'<b>*</b></label>'.initEditor($name,$width,$height).'</li>';
}
