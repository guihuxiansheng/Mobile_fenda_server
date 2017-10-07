<?php 
	namespace app\api\controller;
	use \think\Controller;
	class Listen extends Controller {
		// function __construct(){
		// 	$expert = db('expert') -> find();
		// 	var_dump($expert);
		// 	// $this->assign('listen',$expert);
		// 	// return $this->fetch('/listen');
		// 	return json($expert);
		// 	// exit();
		// }
		function index() {
			$list = db('expert') 
					->alias("e")
					->field("e.id, e.expert_name, u.head_pic, p.content, p.number")
					->join("user u", "e.user_id = u.id")
					->join("answeraudio ana", "e.id = ana.expert_id")
					->join("problem p", "ana.problem_id = p.id")
					->where("u.whether = 'true'")
					->select();
			// var_dump($list);
			// exit();
			return json($list);
		}
	}
 ?>