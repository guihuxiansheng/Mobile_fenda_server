<?php 
namespace app\api\controller;
use \think\Controller;
class Detailque extends Controller {
	function index() {
		// 定义 问题ID 空数组
		$list = array();
		// 获取传过来的专家ID
		$expert_id = input("expertId");
		// 根据专家ID查询用到的信息
		$item = db("expert")
					->alias("e")
					->field("e.expert_name, e.rank, e.worth, ana.path, ana.create_time, ana.status, u.head_pic, u.user_name, p.id, p.content, p.number, p.point_number, p.parent_id")
					->join("answeraudio ana", "ana.expert_id = e.id")
					->join("problem p", "p.id = ana.problem_id")
					->join("user u", "u.id = p.user_id")
					->where("e.id = $expert_id")
					->select();
		// 将查出来的问题（父级ID为0）ID放到$list中
		array_push($list, $item[0]['id']);
		// 获取数据库中 问题列表
		$problemList = db("problem") -> select();
		// 获取问题中追问的ID
		foreach ($problemList as $key => $value) {
			if($value['parent_id'] == $list[count($list)-1]) {
				array_push($list, $value['id']);
			}
		}
		// 定义追问空数组
		$item_2 = array();
		for($i=1; $i<count($list); $i++) {
			$temp = db("problem")
					->alias("p")
					->field("p.id, p.content, p.number, p.point_number, p.parent_id, ana.path, ana.status, ana.create_time, e.worth")
					->join("answeraudio ana", "p.id = ana.problem_id", 'LEFT')
					->join("expert e", "ana.expert_id = e.id", 'LEFT')
					->where("p.id = $list[$i]")
					->select();
			array_push($item_2, $temp[0]);
		}
		// $item[1]放追问的内容
		$item[] = $item_2;
		// var_dump($item);exit();
		return json($item);
	}
}

 ?>