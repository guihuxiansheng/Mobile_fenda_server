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
			     $topicshow=db('topicshow')
        ->alias('t')
        ->join('specialtopic s','s.id = t.topicid')
        ->select();
        return json($topicshow);
		}
		function smallList(){
$selectedID = input('selectedID');
        $topic = db('specialtopic')
        ->alias('s')
        ->where('s.categroies_id',$selectedID)
        ->select();
        return json($topic);
		}
	}   
 ?>