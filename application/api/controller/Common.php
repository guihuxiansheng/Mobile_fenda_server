<?php 
	namespace app\api\controller;
	use \think\captcha\Captcha;
	/**
	* 
	*/
	class Common
	{
		public static function getRandom($param=32){
		    $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		    $key = "";
		    for($i=0;$i<$param;$i++)
		     {
		         $key .= $str{mt_rand(0,32)};    //生成php随机数
		     }
		     return $key;
		 }
		 public static function check_verify($code, $id=''){
		 	$captcha = new Captcha();
		 	return $captcha->check($code, $id);
		 }
		 public static function create_verify($id=''){
		 	$captcha = new Captcha();
		 	$captcha->useCurve = false;
		 	if(empty($id)){
		 		return $captcha->entry();
		 	}
			return $captcha->entry($id);
		 }
	}
 ?>