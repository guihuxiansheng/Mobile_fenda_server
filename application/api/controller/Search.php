<?php 
	namespace app\api\controller;
	use \think\Controller;
	/**
	* 
	*/
	class Search extends \think\Controller
	{
		
		function hot()
		{
			$hot=db("course")
				->alias("c")
				->join("expert e","c.expert_id=e.id")
				->order("c.num")
				->limit(9)
				->select();
				return json($hot);
		}

		function search(){
			$query=input();
			$search=db("exptaudio")
					->alias("e")
					->join("expert p","e.expert_id=p.id")
					->where(['p.expert_name'=>['like',$query['query'],'%']])
					->limit(3)	
					->select();
			$total = Array();
			$search_one['id'] = '人物';
			$search_one['data'] = $search;
			$total[] = $search_one;

			$search=db("course")
			->alias("c")
			->join("expert e","c.expert_id=e.id")
			->where(['e.expert_name'=>['like',$query['query'],'%']])
			->limit(3)		
			->select();
			$seach_one['id'] = '小讲';
			$seach_one['data'] = $search;
			$total[] = $seach_one;

			$search=db("exptaudio")
			->alias("e")
			->join("expert p","e.expert_id=p.id")
			->where(['p.expert_name'=>['like',$query['query'],'%']])	
			->select();
			$seach_one['id'] = '问答';
			$seach_one['data'] = $search;
			$total[] = $seach_one;

			return json($total);
		}
	}
 ?>