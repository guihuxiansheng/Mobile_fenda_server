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
			$this->login = Session::get('user')?Session::get('user'):'';
		}
	}
 ?>