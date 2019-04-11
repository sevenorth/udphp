<?php	

//$_FILES	文件上传变量
header("Content-type:text/html;charset=utf-8");

$fileInfo = $_FILES['myFile'];
$filename = $fileInfo['name'];
$type = $fileInfo['type'];
$tmp_name = $fileInfo['tmp_name'];
$size = $fileInfo['size'];
$error = $fileInfo['error'];

//判断错误号，只为0或者UPLOAD_ERR_OK才上传成功
if($error==UPLOAD_ERR_OK){
	if(move_uploaded_file($tmp_name, "./".$filename)){
		echo "文件".$filename.'上传成功';
	}else{
		echo "文件".$filename.'上传失败';
	}
}else{
	//匹配错误信息
	switch ($error) {
		case 1:
			echo "上传文件超过了PHP配置文件中upload_max_filesize选项的值";
			break;
		case 2:
			echo "上传文件超过了表单MAX_FILE_SIZE限制的大小";
			break;
		case 3:
			echo "文件被部分上传";
			break;
		case 4:
			echo "没有选择上传文件";
			break;
		case 5:			
			break;
		case 6:
			echo "没有找到临时目录";
			break;
		case 7:
		case 8:
			echo "系统错误";
			break;
		default:
			
			break;
	}
}
