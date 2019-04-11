<?php 
//单文件上传
function uploadFile($fileInfo,$flag=true){
	$filename = $fileInfo['name'];
	$type = $fileInfo['type'];
	$tmp_name = $fileInfo['tmp_name'];
	$size = $fileInfo['size'];
	$error = $fileInfo['error'];

	$maxSize = 1024 * 1024 * 2;

	//判断错误号
	if($error > 0){
		switch ($error) {
			case 1:
				$msg = "上传文件超过了PHP配置文件中upload_max_filesize选项的值";
				break;
			case 2:
				$msg = "上传文件超过了表单MAX_FILE_SIZE限制的大小";
				break;
			case 3:
				$msg = "文件被部分上传";
				break;
			case 4:
				$msg = "没有选择上传文件";
				break;
			case 5:			
				break;
			case 6:
				$msg = "没有找到临时目录";
				break;
			case 7:
			case 8:
				$msg = "系统错误";
				break;
			default:
				
				break;
		}
		exit($msg);
	}
	$ext = pathinfo($filename,PATHINFO_EXTENSION);
	$allowext=array('jepg','jpg','png','gif','wbmp');
	//检测上传文件类型
	if(!in_array($ext, $allowext)){
		exit('非法文件类型');
	}
	//检测文件大小是否符合规范
	if($size>$maxSize){
		exit("上传文件过大");
	}
	//检测是否真实文件类型
	if($flag){
		if(!getimagesize($tmp_name)){
			exit('不是真实的图片类型');
		}
	}
	//检测文件是否通过http post上传的
	if(!is_uploaded_file($tmp_name)){
		exit('文件不是用POST上传的');
	}
	$uploadPath = 'uploads';
	if(!file_exists($uploadPath)){
		mkdir($uploadPath,0777,true);
		chmod($uploadPath, 0777);
	}
	$uniName = md5(uniqid(microtime(true),true)).'.'.$ext;
	$destination = $uploadPath.'/'.$uniName;
	if(!@move_uploaded_file($tmp_name, $destination)){
		exit('文件上传失败');
	}
	echo "文件上传成功";
}