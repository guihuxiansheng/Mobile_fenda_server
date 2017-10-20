<?php 
namespace app\api\controller;
use \think\Controller;
class Answerpage extends Controller {
	protected $answerer;
	function __construct() {
		parent::__construct();
		$this->answerer = model("Answerer");
	}
	function index() {
		$expertId = input('expertUid');
		$expertInfo = $this->answerer ->expertInfo($expertId);
		return json($expertInfo);
	}
	function question() {
		$expertId = input('expertUid');
		$expertInfo = $this->answerer ->expertInfo($expertId);
		$eId = $expertInfo['id'];
		$detailQue = $this->answerer ->findQuestion($eId);
		// var_dump($detailQue);
		// exit;
		return json($detailQue);
	}
	function ask() {
		$problemInfo = input();
		// var_dump($problemInfo);exit;
		if(empty($problemInfo)){
			exit;
		} else {
			try{
				db('problem')
					->insert([
						'content'=> $problemInfo['content'],
						'price'=> $problemInfo['price'],
						'parent_id'=>$problemInfo['parentId'],
						'create_time'=> time(),
						'whether'=>$problemInfo['whether'],
						'user_id'=>$problemInfo['userId'],
						'expert_id'=>$problemInfo['expertId']
					]);
				$problemId = db('problem')
								->alias("p")
								->field('p.id')
								->order("id desc")
								->find();
				// var_dump($problemId);exit;
					return json(Array(
						'status'=> 0,
						'message'=> '',
						'problemId'=> $problemId['id']
					));
			} catch (\Exception $e){
				return json(Array(
					'status'=> 1,
					'message'=> '抱歉，提问出错'
				));
			}
		}
	}
}
 ?>