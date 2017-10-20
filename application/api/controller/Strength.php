<?php
	namespace app\api\controller;
	use \think\Controller;
	/**
	 * 
	 */
	class Strength extends controller {
		
		function index() {
			$one_list=db("expert")
				->alias("e")
				->join("answeraudio a","a.id=e.answeraudio_id")
				->join("problem p","p.id=a.problem_id")
				->order("p.number desc")
				->select();
				return json($one_list);
		}
			
	}
	
?>