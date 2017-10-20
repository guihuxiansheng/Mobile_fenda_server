<?php 
namespace app\api\model;
/**
* 
*/
class Answerer extends \think\Model
{
	function expertInfo($id) {
		return db('expert')
					->alias("e")
					->where("e.user_id", $id)
					->find();
	}
	function findQuestion($id) {
		$problem = db('problem')
					->alias("p")
					->field("p.id ,p.content, eta.path, eta.number, eta.point_number, eta.status, eta.create_time, u.head_pic")
					->join("exptaudio eta", "p.id = eta.problem_id")
					->join("user u", "p.user_id = u.id")
					->where("p.whether = 1 and p.expert_id = $id")
					->order("create_time desc")
					->select();
		$kwproblem = db('kwproblem')
					->alias("kwp")
					->field("kwp.id ,kwp.content, kwp.kwcate_id, kwa.path, kwa.content as anscontent, kwa.number, kwa.point_number, kwa.status, kwa.create_time")
					->join("kwanswer kwa", "kwa.kwproblem_id = kwp.id and kwa.expert_id = $id")
					->order("create_time desc")
					->select();
		$totalQue = array_merge($problem, $kwproblem);
		return $totalQue;
	}
}
 ?>