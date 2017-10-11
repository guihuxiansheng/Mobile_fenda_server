<?php 
	namespace app\api\controller;
	use \think\Controller;

	/**
	* 
	*/
	class expert extends controller
	{
		
		function index()
		{
			$expert_list=db("expert")
				->alias("e")
				->join("answeraudio a","a.id=e.answeraudio_id")
				->order("e.create_time desc")
				->limit(3)
				->select();
				return json($expert_list);
		}
		function  talent()
		{
			$expert_list=db("expert")
				->alias("e")
				->join("answeraudio a","a.id=e.answeraudio_id")
				->join("problem p","p.id=a.problem_id")
				->order("p.number desc")
				->limit(3)
				->select();
				return json($expert_list);
		}
	}
 ?>