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
	}
 ?>