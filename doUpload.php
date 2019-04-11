<?php	
//$_FILES	文件上传变量

print_r($_FILES);
$filename = $_FILES['myFile']['name'];
$type = $_FILES['myFile']['type'];
$tmp_name = $_FILES['myFile']['tmp_name'];
$size = $_FILES['myFile']['size'];
$error = $_FILES['myFile']['error'];


/**方法一**/


//将服务器上的临时文件移动到指定目录下
//move_uploaded_file($tmp_name,$dir):将服务器的临时文件移动到$dir目录下
//叫什么名字，成功返回true,失败返回false

// move_uploaded_file($tmp_name, "./".$filename);

/**方法二**/


//copy($src,$dir):将文件拷贝到指定目录下，成功返回true,失败返回false

// copy($tmp_name, "./".$filename);

