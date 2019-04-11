<?php 
header("Content-type:text/html;charset=utf-8");
include_once 'upload.fun.php';
$fileInfo = $_FILES['myFile'];
$res = uploadFile($fileInfo);
echo $res;