<?php 
/**
 * 得到文件扩展名
 */
function getExt($filename){
	return strtolower(pathinfo($filename,PATHINFO_EXTENSION));
}
/**
 * 唯一文件名
 */
function getUniName(){
	return md5(uniqid(microtime(true),true));
}