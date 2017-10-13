<?php
	namespace app\api\controller;
	use \think\Controller;
	/**
	 * 
	 */
	class Top extends controller {
		
		function index() {
			$top_list=db("expert")
				->alias("e")
				->join("answeraudio a","a.id=e.answeraudio_id")
				->join("problem p","p.id=a.problem_id")
				->order("p.number desc")
				->select();
				return json($top_list);
		}
			
	}
	
?>