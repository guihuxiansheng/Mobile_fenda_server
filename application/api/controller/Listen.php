<?php 
	namespace app\api\controller;
	use \think\Controller;
	class Listen extends Controller {
		function index() {
			$list = db('expert') 
					->alias("e")
					->field("e.id, e.expert_name, u.head_pic, ana.status, p.content, p.number")
					->join("user u", "e.user_id = u.id")
					->join("answeraudio ana", "e.id = ana.expert_id")
					->join("problem p", "ana.problem_id = p.id")
					->where("u.whether = 'true'")
					->order("status")
					->select();
			return json($list);
		}
		function listen() {
			// 应该接收到当前登录用户的ID
			$expertList = db('listen')
							->alias("l")
							->field("e.id, e.expert_name, e.rank")
							->join("expert e", "l.expert_id = e.id")
							->join("user u", "l.user_id = u.id")
							->where("l.user_id = 2")
							->select();
			// var_dump($expertList);exit();
			return json($expertList);
		}
	}
 ?>