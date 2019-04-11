<?php 

class upload{
	protected $fileName;
	protected $maxSize;
	protected $allowMime;
	protected $allowExt;
	protected $uploadPath;
	protected $imgFlag;
	protected $fileInfo;
	protected $error;
	protected $uniName;
	protected $destination;
	protected $ext;


	public function __construct($fileName='myFile',$uploadPath='uploads',$imgFlag=true,$maxSize=2097152,$allowExt=array('jpeg','jpg','png'),$allowMime=array('image/jepg','image/png','image/jpg')){
		$this->fileName = $fileName;
		$this->maxSize = $maxSize;
		$this->allowMime=$allowMime;
		$this->allowExt = $allowExt;
		$this->uploadPath=$uploadPath;
		$this->imgFlag=$imgFlag;
		$this->fileInfo=$_FILES[$this->fileName];
	}
	protected function checkError(){
		if(is_null($this->fileInfo)){
			$this->error = '文件上传出错';
			return false;
		}
		if($this->fileInfo['error']>0){
			switch ($this->fileInfo['error']) {
				case 1:
					$this->error = "上传文件超过了PHP配置文件中upload_max_filesize选项的值";
					break;
				case 2:
					$this->error = "上传文件超过了表单MAX_FILE_SIZE限制的大小";
					break;
				case 3:
					$this->error = "文件被部分上传";
					break;
				case 4:
					$this->error = "没有选择上传文件";
					break;
				case 5:			
					break;
				case 6:
					$this->error = "没有找到临时目录";
					break;
				case 7:
					$this->error = '文件不可写';
					break;
				case 8:
					$this->error = "由于PHP扩展中断上传";
					break;
				default:
					
					break;
			}
			return false;
		}
		return true;
	}
	protected function checkSize(){
		if($this->fileInfo['size']>$this->maxSize){
			$this->error = '文件过大';
			return false;
		}
		return true;

	}
	protected function checkExt(){
		$this->ext = strtolower(pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION));
		if(!in_array($this->ext, $this->allowExt)){
			$this->error = '不允许扩展名';
			return false;
		}
		return true;

	}	
	protected function checkMime(){
		if(!in_array($this->fileInfo['type'], $this->allowMime)){
			$this->error = '不允许的文件类型';
			return false;
		}	
		return true;

	}
	protected function checkTrueImg(){
		if($this->imgFlag){
			if(!@getimagesize($this->fileInfo['tmp_name'])){
				$this->error = '不是真实的图片类型';
				return false;
			}
		}
		return true;

	}
	protected function checkHttpPost(){
		if(!is_uploaded_file($this->fileInfo['tmp_name'])){
			$this->error = '文件不是通过HTTP POST方式上传';
			return false;
		}
		return true;

	}
	protected function showError(){
		exit("<span style='color:red;'>".$this->error."</span>");
	}
	protected function checkUploadPath(){
		if(!file_exists($this->uploadPath)){
			mkdir($this->uploadPath,0777,true);
			chmod($this->uploadPath, 0777);
		}
		return true;

	}
	protected function getUniName(){
		return md5(uniqid(microtime(true),true));
	}	
	public function uploadFile(){
		if($this->checkError()&&$this->checkSize()&&$this->checkExt()&&$this->checkMime()&&$this->checkTrueImg()&&$this->checkHttpPost()){
			$this->checkUploadPath();
			$this->uniName = $this->getUniName();
			$this->ext = strtolower(pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION));
			$this->destination = $this->uploadPath.'/'.$this->uniName.'.'.$this->ext;
			if(move_uploaded_file($this->fileInfo['tmp_name'], $this->destination)){
				return $this->destination;
			}else{
				$this->error='文件上传失败';
				$this->showError();
			}
		}else{
			$this->showError();
		}
	}
}