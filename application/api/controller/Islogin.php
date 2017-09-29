<?php
	namespace app\api\controller;
	use \think\Controller;
	use \think\Session;

	/**
	* 
	*/
	class Islogin extends Controller
	{
		function __construct()
		{
			parent::__construct();
			$ses_user = Session::get('user');
			if(isset($ses_user)){
				$user = db('user')->where(['id'=>$ses_user])->find();
				$this->assign('user',$user);
			}
		}
	}
?>