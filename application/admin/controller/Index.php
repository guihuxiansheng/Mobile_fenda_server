<?php
	namespace app\admin\controller;
	use \think\Session;
	/**
	* 
	*/
	class Index extends Islogin
	{
		function index(){
			return $this->fetch();
		}
		function logout(){
			Session::delete('user');
			$this->redirect('./login');
		}
	}
?>