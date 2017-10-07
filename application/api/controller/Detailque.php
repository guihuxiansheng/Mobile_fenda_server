<?php 
namespace app\api\controller;
use \think\Controller;
class Detailque extends Controller {
	function index() {
		$list = array();
		$expert_id = input("expertId");
		$item = db("expert")
					->alias("e")
					->field("e.expert_name, e.introduction, ana.path, ana.create_time, u.head_pic, u.user_name, p.id, p.content, p.number, p.point_number, p.parent_id")
					->join("answeraudio ana", "ana.expert_id = e.id")
					->join("problem p", "p.id = ana.problem_id")
					->join("user u", "u.id = p.user_id")
					->where("e.id = $expert_id")
					->select();
		array_push($list, $item[0]['id']);
		$problemList = db("problem") -> select();
		// 追问
		foreach ($problemList as $key => $value) {
			if($value['parent_id'] == $list[count($list)-1]) {
				array_push($list, $value['id']);
			}
		}
		var_dump($item);
		foreach ($list as $key => $value) {
			$temp = db("problem")
					->alias("p")
					->where("p.id = $value")
					// ->field("p.id, p.content, p.number, p.point_number, p.parent_id, ana.path, ana.create_time")
					// ->join("answeraudio ana", "p.id = ana.problem_id")
					->select();
			var_dump($temp);
			array_push($item_2, $temp);
		}
		var_dump($item_2);
		exit();
		return json($item);
	}
}

 ?>