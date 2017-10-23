<?php 
	namespace app\api\controller;
	use \think\Controller;
	/**
	* 
	*/
	class headlines extends controller
	{
		
		function index()
		{
			
			$head_list=db("headline")
				->alias('h')
				->join("expert e","e.id=h.expert_id")
				->order('h.time desc')
				->paginate(5);
				return json($head_list);
		}
	}
 ?>