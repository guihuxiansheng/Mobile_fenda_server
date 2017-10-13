<?php 
	namespace app\api\controller;
	use \think\Controller;
	/**
	* 
	*/
	class Health extends Controller
	{
		
		function index()
		{
			$health_list = db("healthclassification")
							->field('id,classification')
							->select();

			return json($health_list);
		}
		function healthlist() {
			$healthList=db("expert")
				->alias("e")
				->join("answeraudio a","a.id=e.answeraudio_id")
				->join("problem p","p.id=a.problem_id")
				->order("p.number desc")
				->select();
				return json($healthList);
		}
	}
 ?>