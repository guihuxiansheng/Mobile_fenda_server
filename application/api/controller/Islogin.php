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
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
			header('Access-Control-Allow-Methods: GET, POST, PUT');
			if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
			    exit;
			}
		}
	}
?>