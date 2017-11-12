<?php 
	namespace app\api\controller;
	use \think\Controller;
	class Listen extends Controller {
		function index() {
			$list = db('problem') 
					->alias("p")
					->field("p.id, p.content, p.expert_id, e.expert_name, e.user_id, u.head_pic, eta.status, eta.number")
					->join("expert e", "p.expert_id = e.id")
					->join("user u", "e.user_id = u.id")
					->join("exptaudio eta", "eta.problem_id= p.id and eta.expert_id = e.id")
					->where("p.parent_id = 0 and p.whether = 1")
					->order("status")
					->select();
			// var_dump($list);exit;
			return json($list);
		}
		function listen() {
			// 应该接收到当前登录用户的ID
			$user_id = 2;
			$expertList = db('listen')
							->alias("l")
							->field("e.id, e.expert_name, e.rank, e.user_id")
							->join("expert e", "l.expert_id = e.id")
							->join("user u", "l.user_id = u.id")
							->where("l.user_id", $user_id)
							->select();
			// var_dump($expertList);exit();
			return json($expertList);
		}
	}
 ?>