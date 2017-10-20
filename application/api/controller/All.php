<?php 
	namespace app\api\controller;
	use \think\Controller;

	/**
	* 
	*/
	class All extends controller
	{
		
		function index()
		{
			$all_list=db("classification")
				->select();
				return json($all_list);
		}
		
	}
 ?>
