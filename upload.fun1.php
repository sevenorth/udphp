<?php 
// include_once 'common.fun.php';
//多文件上传
function getFile(){
	$i = 0;
	foreach ($_FILES as $file) {
		if(is_string($file['name'])){
			$files[$i] = $file;
			$i++;
		}elseif(is_array($file['name'])){
			foreach ($file['name'] as $key => $value) {
				$files[$i]['name'] = $file['name'][$key];
				$files[$i]['type'] = $file['type'][$key];
				$files[$i]['tmp_name'] = $file['tmp_name'][$key];
				$files[$i]['error'] = $file['error'][$key];
				$files[$i]['size'] = $file['size'][$key];

				$i++;
			}
		}
	}
	return $files;
}
function uploadFile($fileInfo,$flag=true){
	$filename = $fileInfo['name'];
	$type = $fileInfo['type'];
	$tmp_name = $fileInfo['tmp_name'];
	$size = $fileInfo['size'];
	$error = $fileInfo['error'];

	$maxSize = 1024 * 1024 * 2;

	//判断错误号
	if($error==UPLOAD_ERR_OK){
		//检测上传文件大小
		if($size>$maxSize){
			$res['msg'] = $filename.'上传文件过大';
		}
		$ext = getExt($filename);
		$allowext=array('jepg','jpg','png','gif','wbmp');
		//检测上传文件类型
		if(!in_array($ext, $allowext)){
			$res['msg'] = $filename.'是非法文件类型';
		}
		//检测是否真实图片类型
		if($flag){
			if(!getimagesize($tmp_name)){
				$res['msg'] = $filename.'不是真实的图片类型';
			}
		}
		//检测文件是否通过http post上传的
		if(!is_uploaded_file($tmp_name)){
			$res['msg'] = $filename.'文件不是用HTTP POST上传的';
		}
		if(isset($res)){
			return $res;
		}
		$uploadPath = 'uploads';
		if(!file_exists($uploadPath)){
			mkdir($uploadPath,0777,true);
			chmod($uploadPath, 0777);
		}
		$uniName = getUniName();
		$destination = $uploadPath.'/'.$uniName.'.'.$ext;
		if(!@move_uploaded_file($tmp_name, $destination)){
			$res['msg'] = $filename.'文件上传失败';
		}else{
			$res['msg'] = $filename.'文件上传成功';
		}
		$res['dest']  = $destination;
		return $res;
	}else{
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
		$res['msg'] = $msg;
		return $res;
	}
}