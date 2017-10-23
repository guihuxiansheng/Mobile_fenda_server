<?php
	namespace app\api\controller;
	use app\api\common\Common;
	use app\api\validate;
	use \think\Session;
	/**
	* 
	*/
	class Login extends Islogin
	{
		
		function index(){
			return json($this->login);
		}
		function login(){
			$user = input('phone');
			$code = input('code');
			$login_user = [
				'phone_number' => $user,
				'captcha' => $code
			];
			// 验证输入
			$result = $this->validate($login_user,'User');
			if($result !== true){
				return json([
					'status'=> 1,
					'message'=> $result
				]);
			}
			// 获取用户信息和短信验证码信息
			$db_user = model('login')->getLogin($user);
			$check_code = Common::check_phoneCode(empty($db_user)?0: $db_user['id'], $user, $code);
			if($check_code['status'] === 0){
				if(empty($db_user)){
					$register = model('login')->register($user);
					if($register['status'] !== 0){
						return json($register);
					}
				}
			}else{
				return json($check_code);
			}
			Session::set('user',$db_user);
			return json([
				'status'=> 0,
				'message'=> '登录成功！'
			]);
		}
		function logout(){
			Session::delete('user');
			return json([
				'status'=> 0,
				'message'=> '退出登录成功！'
			]);
		}
		function register(){

		}
		function phone(){
			if(!preg_match_all('/^1[34578]\d{9}$/', input('phone'))){
				return json([
					'status' => 1,
					'message' => '号码错误！'
				]);
			}
			$user = Common::findUser(input('phone'));
			if($user){
				return json(Common::create_phoneCode($user['id'],input('phone')));
			}else{
				return json(Common::create_phoneCode(0,input('phone')));
			}
			
		}
	}
?>