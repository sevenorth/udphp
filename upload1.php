<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>多个单文件上传</title>
</head>
<body>
	<form action="doUpload4.php" method="post" enctype="multipart/form-data">
		请选择文件<input type="file" name="myFile[]"><br />
		请选择文件<input type="file" name="myFile[]"><br />
		请选择文件<input type="file" name="myFile[]"><br />
		请选择文件<input type="file" name="myFile[]" multiple="multiple"><br />
		<input type="submit" name="上传">
	</form>
</body>
</html>