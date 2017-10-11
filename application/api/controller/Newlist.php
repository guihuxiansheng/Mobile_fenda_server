<?php
	namespace app\api\controller;
	use \think\Controller;
	/**
	 * 
	 */
	class Newlist extends controller {
		
		function index() {
			$newlist=db("expert")
				->alias("e")
				->join("answeraudio a","a.id=e.answeraudio_id")
				->order("e.create_time desc")
				->select();
				return json($newlist);
		}
			
	}
	
?>