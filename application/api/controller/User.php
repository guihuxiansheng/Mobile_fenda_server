<?php 
	namespace app\api\controller;
	/**
	* 
	*/
	class User extends Islogin
	{
		function __construct(){
			parent::__construct();
			if(empty($this->login)){
				return json([
					'status'=>1,
					'message'=> '没有访问权限'
				]);
			}
		}
		function index(){

		}
		function upload(){
			$file_pic = request()->file('image');
			if(empty($file_pic) || empty($file_pic->info) || empty($file_pic->info['type']) || !is_string($file_pic->info['type']) || substr($file_pic->info['type'],0,5) !== 'image'){
				return json([
					'status'=>2,
					'message'=> '内容错误'
				]);
			}
			Session::set('image',$file_pic->info['tmp_name'] + $file_pic->info['name']);
		}
	}
 ?>