<?php
require '../core/run.php';
//获取表的名称
function list_tables($database)
{
    $tables = M()->query('SHOW TABLES FROM '.$database);
    $tables = array_merge_values($tables);
    return $tables;
}

/**
 * [array_merge_values 数组降维 : 将二维数组合并为一维]
 * @param  [type] $hay [description]
 * @return [type]      [返回值数组]
 */
/*function array_merge_values($hay){
    $newArr = array();
    foreach ($hay as $key => $value) {
        $newArr[] = current($value);
    }
    return $newArr;

}*/
//导出数据库
function dump_table($table, $fp = null)
{
    $need_close = false;
    if (is_null($fp)) {
        $fp = fopen($table . '.sql', 'w');
        $need_close = true;
    }
    // $a=mysql_query("show create table `{$table}`");
    $a = M()->query("show create table `{$table}`");
    fwrite($fp,$a[0]['Create Table'].';');//导出表结构
    $rs = M()->query("SELECT * FROM `{$table}`");
    foreach ($rs as $key => $row) {
        fwrite($fp, get_insert_sql($table, $row));
    }
    if ($need_close) {
        fclose($fp);
    }
}
//导出表数据
function get_insert_sql($table, $row)
{
    $sql = "INSERT INTO `{$table}` VALUES (";
    $values = array();
    foreach ($row as $value) {
        $values[] = "'".htmlspecialchars($value,ENT_QUOTES)."'";
    }
    $sql .= implode(', ', $values) . ");";
    return $sql;
}
///////************************///////下面正式开始//////***************************///////
$database=Config::get('database.database');//数据库名

//设置日期为备份文件名
date_default_timezone_set('PRC');
$t_name = date("Ymd_His");

/*$options=array(
    'hostname' => $dbhost,//ip地址
    'charset' => 'utf8',//编码
    'filename' => "".$database.$t_name.'.sql',//文件名
    'username' => $dbuser,
    'password' => $dbpw
);*/
$filename = ROOT_PATH . Config::get('pic.upload').'../dbbackup/'.$database.$t_name.'.sql';
$tables = list_tables($database);
$fp = fopen($filename, 'w');
foreach ($tables as $table) {
    dump_table($table, $fp);
}
fclose($fp);
//下载sql文件
header("Content-type:application/octet-stream");
header("Content-Disposition:attachment;filename=" . Request::instance()->domain());
readfile($filename);
//删除服务器上的sql文件
// unlink($filename);
// exit("备份成功,请到根目录的uploadfile/dbakup文件夹下取备份！");
?>
