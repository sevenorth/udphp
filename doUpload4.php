<?php 
/**
 * 多文件上传
 */
header("Content-type:text/html;charset=utf-8");
require_once 'upload.fun1.php';
require_once 'common.fun.php';
$files = getFile();

foreach ($files as $fileInfo) {
	$res = uploadFile($fileInfo);
	echo $res['msg'].'<br/>';
	if(isset($res['dest'])){
		$uploadFiles[] = $res['dest'];
	}	
}
$uploadFiles = array_values(array_filter($uploadFiles));
print_r($uploadFiles);