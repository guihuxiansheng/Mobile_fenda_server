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
				->join("answeraudio a","a.expert_id=e.id")
				->order("e.create_time desc")
				->limit(3)
				->select();
				return json($expert_list);
		}
		function  talent()
		{
			$expert_list=db("expert")
				->alias("e")
				->join("answeraudio a","a.expert_id=e.id")
				->join("problem p","p.id=a.problem_id")
				->order("p.number desc")
				->limit(3)
				->select();
				return json($expert_list);
		}
		function  top()
		{
			$expert_list=db("expert")
				->alias("e")
				->join("answeraudio a","a.expert_id=e.id")
				->join("problem p","p.id=a.problem_id")
				->order("p.number desc")
				->limit(5)
				->select();
				return json($expert_list);
		}
		function  onetoone()
		{
			$one_list=db("expert")
				->alias("e")
				->join("answeraudio a","a.expert_id=e.id")
				->join("problem p","p.id=a.problem_id")
				->limit(5)
				->select();
				return json($one_list);
		}
	}
 ?>