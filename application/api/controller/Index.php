<?php
	namespace app\api\controller;

	/**
	* 
	*/
	class Index extends Islogin
	{
		
		function index()
		{
			$banner = model('index')->getBanner();
			$this->assign('banner',$banner);
		}
	}
?>