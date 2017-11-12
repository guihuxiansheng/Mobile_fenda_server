<?php 
	namespace app\api\model;

	/**
	* 
	*/
	class Myanswer extends \think\Model
	{
		/**
		 * [getQuestion 获取某个问题的信息]
		 * @param  [number] $id  [问题id]
		 * @param  [number] $uid [登陆用户id]
		 * @return [obj]      [返回问题的内容和状态码]
		 */
		function getQuestion($id, $uid){
			$expert = $this->table('fd_expert')->where([
				'user_id'=>$uid
			])->field('id')->find();
			$quest = $this->table('fd_problem problem,fd_user user, fd_exptaudio exptaudio')->where([
				'problem.expert_id'=>$expert['id'],
				'problem.id'=>$id
			])->where('problem.user_id=user.id and exptaudio.problem_id=problem.id')->order('problem.parent_id ASC')->field('problem.id,problem.content,problem.whether,problem.create_time as quest_time,problem.state,user.head_pic,user.user_name,exptaudio.id as audio_id,exptaudio.path,exptaudio.status,exptaudio.create_time as audio_time')->select();
			if(count($quest) === 0){
				$quest = $this->table('fd_problem problem,fd_user user')->where([
					'problem.expert_id'=>$expert['id'],
					'problem.id'=>$id
				])->where('problem.user_id=user.id')->field('problem.id,problem.content,problem.whether,problem.create_time as quest_time,problem.state,user.head_pic,user.user_name')->select();
			}
			foreach ($quest as $value) {
				if(empty($value['whether'])){
					if(!empty($value['user_name'])){
						unset($value['user_name']);
					}
				}
			}
			return $quest;
		}
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
		/**
		 * [saveAudio 保存音频]
		 * @param  [string] $path [文件路径]
		 * @param  [number] $id   [问题id]
		 * @param  [number] $uid  [用户id]
		 * @return [boolean]       [状态]
		 */
		function saveAudio($path,$id, $uid){
			try{
				$problem = $this->table('fd_problem problem,fd_expert expert')->where([
					'problem.id'=> $id,
					'expert.user_id'=> $uid
				])->where('problem.expert_id=expert.id')->find();
				if(empty($problem)){
					return false;
				}
				$audio = $this->table('fd_exptaudio')->where([
					'problem_id'=> $id
				])->find();
				if(!empty($audio)){
					return false;
				}
				$this->table('fd_exptaudio')->insert([
					'path'=>$path,
					'create_time'=> time(),
					'problem_id' => $id,
					'expert_id' => $uid
				]);
				return true;
			}catch(\Exception $e){
				return false;
			}
		}
		/**
		 * [changeQuest 拒绝回答]
		 * @param  [string] $id [问题id]
		 * @return [boolean]     [操作状态]
		 */
		function changeQuest($id, $uid){
			// 排除用户已经回答的情况
			$expert = $this->table('fd_exptaudio audio,fd_expert expert')->where([
				'audio.problem_id'=> $id,
				'expert.user_id'=> $uid
			])->where('expert.id=audio.expert_id')->find();
			if(!empty($expert)){
				return false;
			}
			// 判断是否有这个问题
			$prob = $this->table('fd_problem problem,fd_expert expert')->where([
				'problem.id'=> $id,
				'expert.user_id'=> $uid
			])->where('expert.id=problem.expert_id')->find();
			if(empty($prob)){
				return false;
			}
			// 保存信息
			$this->table('fd_problem')->where(['id'=>$id])->update([
				'state'=>2
			]);
			return true;
		}
	}
 ?>