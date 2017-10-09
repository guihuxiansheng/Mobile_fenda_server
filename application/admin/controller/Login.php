<?php 
	namespace app\admin\controller;
	use \think\Loader;
	use \think\Session;
	/**
	* 
	*/
	class Login extends Islogin
	{
		function __construct(){
			parent::__construct();
			if($this->login != null){
				$this->redirect('./index');
			}
		}
		function index(){
			return $this->fetch();
		}
		function login(){
			$admin = input('admin');
			$pwd = input('pwd');
			$user = [
				'admin' => $admin,
				'password'=> $pwd
			];
			$admin_vali = Loader::validate('User');
			if(!$admin_vali->check($user)){
				return json([
					'status' => 1,
					'message' => $admin_vali->getError()
				]);
			}
			$admin_find = db('admin')->where([
				'name' => $admin,
				// 'password' => $pwd
			])->find();
			if($admin_find == null){
				return json([
					'status' => 2,
					'message' => '用户不存在！'
				]);
			}
			if($admin_find['password'] === md5($pwd)){
				Session::set('user', $admin_find);
				return json([
					'status' => 0,
					'message' => '登录成功！'
				]);
			}else{
				return json([
					'status' => 1,
					'message' => '密码不正确！'
				]);
			}
		}
	}
 ?>