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
				->alias('h')
				->join("expert e","e.id=h.expert_id")
				->limit(3)
				->select();
				return json($head_list);
		}
		function smalltalk()
		{
			$special_list=db("special")
				->alias('s')
				->join("column c","c.id=s.column_id")
				->join("expert e","e.id=c.expert_id")
				->join("categories ca","e.classification_id=ca.id")
				->select();
				return json($special_list);
		}
		function smallList(){
			$smallList=db("categories")
				->select();
				return json($smallList);
		}
	}   
 ?>