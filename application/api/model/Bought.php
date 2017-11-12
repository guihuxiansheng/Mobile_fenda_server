<?php 
	namespace app\api\model;

	/**
	* 
	*/
	class Bought extends \think\Model
	{
		function getMyQuest($id,$state,$index){
			$param = Array('problem.user_id'=>$id);
			if($state !== 5 && $state !== 4){
				$param['problem.state'] = $state;
			}
			if($state === 4){
				$param['problem.create_time'] = ['lt', time() - 2*60*60];
			}
			if($state === 0){
				$param['problem.create_time'] = ['gt', time() - 2*60*60];
			}
			return $this->table('fd_problem problem,fd_expert expert,fd_user user')->where($param)->where('problem.expert_id=expert.id and expert.user_id=user.id')->field('problem.id,problem.content,problem.create_time,problem.state,problem.income,problem.price,user.head_pic,user.user_name')->order('problem.create_time DESC')->limit(($index-1)*10,$index*10)->select();
		}
	}
 ?>