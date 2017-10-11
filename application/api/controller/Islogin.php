<?php
	namespace app\api\controller;
	use \think\Controller;
	use \think\Session;

	/**
	* 
	*/
	class Islogin extends Controller
	{
		protected $login;
		function __construct()
		{

			parent::__construct();
			$this->login = Session::get('user');
			if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
			    exit;
			}
		}
	}
?>