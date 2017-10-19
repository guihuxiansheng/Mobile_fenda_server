<?php 
	namespace app\api\model;

	/**
	* 
	*/
	class Myanswer extends \think\Model
	{
		
		function getQuestionList($id, $state, $uid){
			$expert = $this->table('fd_expert')->where([
				'user_id'=>$uid
			])->field('id')->find();
			$time = time() - 2*24*60*60;
			$data = Array(
				'problem.expert_id'=>$expert['id']
			);
			if($state === 5){
				$data['problem.state'] = ['neq',4];
			}else
			if($state === 0){
				$data['problem.create_time'] = ['gt', $time];
				$data['problem.parent_id'] = 0;
			}else
			if($state === 1){
				$data['problem.state'] = 1;
			}else
			if($state === 2){
				$data['problem.state'] = 2;
			}else
			if($state === 3){
				$data['problem.state'] = 3;
			}else
			if($state === 4){
				$data['problem.create_time'] = ['elt', $time];
				$data['problem.parent_id'] = 0;
			}else
			if($state === 6){
				$data['problem.parent_id'] = ['neq', 0];
			}
			return $this->table('fd_problem problem,fd_user user')->where($data)->where('problem.user_id=user.id')->order('problem.create_time DESC')->field('problem.id,user.head_pic,user.user_name,user.whether,problem.content,problem.parent_id,problem.number,problem.price,problem.create_time,problem.state')->limit(10*$id-10,10*$id)->select();
		}
		function getQuickList($id, $uid){
			$expert = $this->table('fd_expert')->where([
				'user_id'=>$uid
			])->field('id')->find();
			$kw_answer = $this->table('fd_kwproblem kp,fd_kwanswer kaa,fd_user user')
							->where([
								'kaa.expert_id'=>$expert['id']
							])
							->where('kaa.kwproblem_id=kp.id and kp.user_id=user.id')
							->order('kp.create_time DESC')
							->field('user.head_pic,user.user_name,kp.content as kp_content,kp.whether,kaa.content,kaa.status,kaa.number,kaa.point_number,kaa.create_time')
							->limit(10*($id-1),10*$id)
							->select();	
			foreach ($kw_answer as $value) {
				if($value['whether']){
					unset($value['head_pic']);
					unset($value['user_name']);
				}
			}
			return array_merge($kw_answer);
		}
	}
 ?>