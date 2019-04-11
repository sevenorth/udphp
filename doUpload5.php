<?php 

header('content-type:text/html;charset=utf-8');
require_once 'upload.class.php';
$upload = new upload('myFile','imooc');
$dest = $upload->uploadFile();
echo $dest;