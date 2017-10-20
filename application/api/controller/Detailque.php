<?php 
namespace app\api\controller;
use \think\Controller;
class Detailque extends Controller {
	function index() {
		// 定义 问题ID 空数组
		$list = array();
		// 获取传过来的问题ID
		$problem_id = input("problemId");
		// 根据问题ID查询用到的信息
		$item = db('problem') 
					->alias("p")
					->field("p.content, p.parent_id, p.expert_id, p.price, e.id, e.expert_name, e.rank, e.worth, eta.path, eta.create_time, eta.status, eta.number, eta.point_number, u.head_pic, u.user_name")
					->join("user u", "u.id = p.user_id")
					->join("expert e", "p.expert_id = e.id")
					->join("exptaudio eta", "eta.problem_id= p.id and eta.expert_id = e.id", 'LEFT')
					->where("p.id = $problem_id")
					->order("status")
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
					->field("p.content, p.parent_id, p.price, eta.number, eta.point_number, eta.path, eta.status, eta.create_time, e.id, e.worth")
					->join("expert e", "p.expert_id = e.id", 'LEFT')
					->join("exptaudio eta", "eta.problem_id= p.id and eta.expert_id = e.id", 'LEFT')
					->where("p.id = $list[$i]")
					->select();
			array_push($item_2, $temp[0]);
		}
		// $item[1]放追问的内容
		$item[] = $item_2;
		// var_dump($item);exit;
		return json($item);
	}
}

 ?>