<?php
	namespace app\admin\controller;
	/**
	* 
	*/
	class Index extends Islogin
	{
		function index(){
			if($this->login){
				return $this->fetch();
			}else{
				$this->redirect(url('/admin/login'));
			}
		}
	}
?>