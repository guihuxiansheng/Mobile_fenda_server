<?php 
	namespace app\api\model;
	/**
	* 
	*/
	class Login extends \think\Model
	{
		
		function getLogin($user){
			return db('user')->where(['phone_number'=>$user])->find();
		}
	}
 ?>