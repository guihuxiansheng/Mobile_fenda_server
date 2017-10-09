<?php
	namespace app\api\controller;
	use app\api\validate;
	use \think\Session;
	/**
	* 
	*/
	class Login extends Islogin
	{
		
		function index(){
			var_dump(Session::get('user'));
			return $this->login;
		}
		function login(){
			$user = input('phone');
			$pwd = input('pwd');
			$login_user = [
				'phone_number' => $user,
				'captcha' => $pwd
			];
			$result = $this->validate($login_user,'User');
			if($result !== true){
				return json([
					'status'=> 1,
					'message'=> $result
				]);
			}
			$db_user = model('login')->getLogin($user);
			if(empty($db_user)){
				return json([
					'status'=> 2,
					'message'=> '用户不存在！'
				]);
			}
			if($db_user['user_pwd'] === md5($pwd)){
				Session::set('user',$db_user);
				return json([
					'status'=> 0,
					'message'=> '登录成功！'
				]);
			}else{
				return json([
					'status'=> 3,
					'message'=> '密码不正确！'
				]);
			}
		}
		function register(){

		}
	}
?>