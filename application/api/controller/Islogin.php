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
			$ses_user = Session::get('user');
			if(!empty($ses_user)){
				$this->login = db('user')->where(['id'=>$ses_user])->find();
			}
		}
	}
?>