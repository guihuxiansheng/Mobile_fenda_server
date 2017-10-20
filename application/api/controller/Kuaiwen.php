<?php 
namespace app\api\controller;
use \think\Controller;
/**
* 
*/
class Kuaiwen extends Controller
{
	protected $kewn;
	function __construct() {
		parent::__construct();
		$this->kwen = model("Kuaiwen");
	}
	function index() {
		
		// 获取分类
		$kwCate = $this->kwen -> findKwCate();
		return json($kwCate);
	}
	function problem() {
		// 获取最新的问题
		$kwNewest = $this->kwen -> findNewest();
		return json($kwNewest);
	}
	function solved() {
		// 获取最新的问题
		$kwNewest = $this->kwen -> findNewest();
		// 
		$kwSolved = array();
		foreach ($kwNewest[1] as $key => $value) {
			if (count($value) > 0) {
				$kwSolved[0][] = $kwNewest[0][$key];
				$kwSolved[1][] = $kwNewest[1][$key];
			}
		}
		return json($kwSolved);
	}
//kuaiwenTopic页面 
	// kuaiwenTopic即快问某个分类
	function topic() {
		$kwCateId = input('kwCateId');
		$kwCateCur = $this->kwen -> findKwCate($kwCateId);
		$kwCateQueCur = $this->kwen -> findNewest($kwCateId);

		$kwtopic[] = $kwCateCur;
		$kwtopic = array_merge($kwtopic, $kwCateQueCur);
		return json($kwtopic);
	}
// kwenDetail页面
	function detail() {
		$kwproblemId = input('kwproblemId');
		$kwproblem = db('kwproblem')
						->alias("kwp")
						->field("kwp.content, kwp.whether, u.user_name, u.head_pic")
						->join("user u", "kwp.user_id = u.id")
						->where("kwp.id", $kwproblemId)
						->find();
		// 获取问题对应的分类
		$kwCateId = db('kwproblem')
						->alias("kwp")
						->field("kwcate_id")
						->where("kwp.id", $kwproblemId)
						->find();
		// var_dump($kwCateId);exit;
		$kwCateCur = $this->kwen -> findKwCate($kwCateId['kwcate_id']);
		$kwanswer = $this->kwen -> detailAnswer($kwproblemId);
		$detail[] = $kwproblem;
		$detail[] = $kwCateCur;
		$detail[] = $kwanswer;
		return json($detail);
	}
// kwenAsk页面
	function ask() {
		$kwproblem = input();
		// var_dump($kwproblem);exit;
		if(empty($kwproblem)){
			//options请求时为空，过滤掉options
			exit;
		} else {
			try{
				db('kwproblem')
				->insert([
					'content' => $kwproblem['content'],
					'whether' => $kwproblem['whether'],
					'user_id' => $kwproblem['userId'],
					'kwcate_id' => $kwproblem['kwCateId'],
					'create_time' => time()
				]);
				return json(Array(
					'status' => 0,
					'message' => ''
				));
			} catch (\Exception $e) {
				return json(Array(
					'status' => 1,
					'message' => '非常抱歉，发布失败'
				));
			}
		}
	}
}
 ?>