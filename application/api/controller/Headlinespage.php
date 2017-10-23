<?php 
	namespace app\api\controller;
	use \think\Controller;

	/**
	* 
	*/
	class Headlinespage extends controller
	{
		
		function index()
		{
			$headID=input('id');
			$headlines=db("headline")
			->alias("h")
			->join("expert e", "h.expert_id=e.id")
			->where("h.id",$headID)
			->select();
			// var_dump($headlines);
			return json($headlines);
		}
		// function other(){
		// 	$headID=input('id');

		// }
	}
 ?>