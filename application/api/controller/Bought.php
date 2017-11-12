<?php 
	namespace app\api\controller;

	/**
	* 
	*/
	class Bought extends Login
	{
		
		function __construct()
		{
			parent::__construct();
			if(empty($this->login)){
				echo json_encode([
					'status'=>3,
					'message'=> '没有访问权限'
				]);
				exit;
			}
		}
		function talk(){
			
		}
		function myquest(){
			$state = (int)input('state');
			$index = (int)input('index');
			$index = $index < 1 ? 1 : $index;
			$quest = model('Bought')->getMyQuest($this->login['id'],$state,$index);
			return json([
				'status'=> 0,
				'data'=>$quest
			]);
		}
	}
 ?>