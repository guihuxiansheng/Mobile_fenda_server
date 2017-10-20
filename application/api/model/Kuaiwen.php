<?php 
namespace app\api\model;
use \think\Model;
/**
* 
*/
class Kuaiwen extends Model
{
	// 快问分类查找
	function findKwCate($cateid='') {
		if (empty($cateid)) {
			// 查询所有分类
			return db('kwcate')
					->alias("kwc")
					->select();
		} else {
			// 查询单个分类
			return db('kwcate')
					->alias("kwc")
					// ->where("kwc.id = '$id'")
					->where("kwc.id", $cateid)
					->find();
		}
	}
	// 找最新的问题
	function findNewest($cateid='') {
		$kwNewest = array();
		if(empty($cateid)){
			// 查询所有分类
			$kwproblem = db('kwproblem')
						->alias("kwp")
						->field("kwp.id, kwp.content, kwp.whether, kwp.create_time, u.head_pic, u.user_name")
						->join("user u", "kwp.user_id = u.id")
						->order("create_time desc")
						->select();
		} else {
			// 查询单个分类
			$kwproblem = db('kwproblem')
						->alias("kwp")
						->field("kwp.id, kwp.content, kwp.whether, kwp.create_time, u.head_pic, u.user_name")
						->join("user u", "kwp.user_id = u.id")
						->where("kwp.kwcate_id", $cateid)
						->order("create_time desc")
						->select();
		}
		
		// 查找出回答的数据，在kwanswer表中
		for ($i=0; $i<count($kwproblem); $i++) {
			$index = $kwproblem[$i]['id'];
			$kwanswer[] = db('kwanswer')
								->alias("kwa")
								->field("kwa.create_time, kwa.id, e.expert_name, e.rank")
								->join("expert e", "kwa.expert_id = e.id")
								->where("kwa.kwproblem_id = $index")
								->order("create_time desc")
								->select();
		}
		// 将所有数据存入$kwNewest，并返回
		array_push($kwNewest,$kwproblem);
		array_push($kwNewest,$kwanswer);
		return $kwNewest;
	}
	// 对单个问题查找对应的回答
	function detailAnswer($problemId) {
		$kwanswer = db('kwanswer')
							->alias("kwa")
							->field("kwa.create_time, kwa.path, kwa.content, kwa.number, kwa.point_number, kwa.status, e.id, e.expert_name, e.rank, u.head_pic")
							->join("expert e", "kwa.expert_id = e.id")
							->join("user u", "e.user_id = u.id")
							->where("kwa.kwproblem_id", $problemId)
							->order("create_time desc")
							->select();
		return $kwanswer;
	}
}
 ?>