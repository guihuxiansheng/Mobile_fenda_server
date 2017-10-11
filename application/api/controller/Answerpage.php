<?php 
namespace app\api\controller;
use \think\Controller;
class Answerpage extends Controller {
	function index() {
		$expertId = input('expertId');
		$expertInfo = db('expert')
						->alias("e")
						->where("e.id = $expertId")
						->select();
		return json($expertInfo);
	}
}
 ?>