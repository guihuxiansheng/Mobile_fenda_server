<?php 
	namespace app\api\controller;
	use \think\Controller;
	/**
	* 
	*/
	class Home extends controller
	{
		
		function index()
		{
			$head_list=db("headline")
				->field("id,title,content,create_time,expert_id,audio_id")
				->select();

				return json($head_list);
		}
	}
 ?>