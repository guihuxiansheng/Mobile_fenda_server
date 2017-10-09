<?php 
	namespace app\admin\controller;
	use \think\Session;
	/**
	* 
	*/
	class Islogin extends \think\Controller
	{
		protected $login;
		function __construct()
		{
			parent::__construct();
			$this->login = Session::get('user');
			$request=  \think\Request::instance();
			if($this->login == null && $request->controller() != 'Login'){
				$this->redirect('./login');
			}
		}
	}
 ?>