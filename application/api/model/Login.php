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
		function register($phone){
			try{
				db('user')->insert([
					'user_name' => $phone,
					'create_time' => time(),
					'phone_number' => $phone,
					'head_pic' => 'static\sundry\avatar.jpg',
					'income' => 0,
					'cents' => 0
				]);
				return [
					'status' => 0,
					'message' => '登录成功！'
				];
			}catch(\Exception $e){
				return [
					'status' => 1,
					'message' => '登录失败！'
				];
			}
		}
	}
 ?>