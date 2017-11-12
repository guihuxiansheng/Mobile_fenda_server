<?php 
	namespace app\api\controller;

	class Myanswer extends Islogin
	{
		function __construct(){
			parent::__construct();
			if(empty($this->login)){
				echo json_encode([
					'status'=>3,
					'message'=> '没有访问权限'
				]);
				exit;
			}
		}
		function getQuest(){
			$id = (int)input('id');
			if(!empty($id) && $this->login['whether']){
				return json([
					'status'=>0,
					'data'=>model('Myanswer')->getQuestion($id, $this->login['id'])
				]);
			}
		}
		function questionList(){
			$id = (int)input('id');
			$state = (int)input('state');
			if(!empty($id) && $this->login['whether']){
				return json(model('Myanswer')->getQuestionList($id, $state, $this->login['id']));
			}
		}
		function quickList(){
			$id = (int)input('id');
			if(!empty($id) && $this->login['whether']){
				return json(model('Myanswer')->getQuickList($id, $this->login['id']));
			}
		}
		// 保存音频
		function postAudio(){
			// $audio_file = input('file.audio');
			$audio_file = request()->file('audio');
			$id = (int)request()->post('id');
			if(!empty($audio_file) && !empty($id)){
				$path = 'uploads'.DS.$this->login['id'].DS.'audio';
				$info = $audio_file->validate(['ext'=>'amr,wav'])->move($path);
				if($info){
					$path_file = $path.DS.$info->getSaveName();
					$result = model('Myanswer')->saveAudio($path_file, $id, $this->login['id']);
					if($result){
						return json([
							'status'=> 0,
							'message' => '上传成功！'
						]);
					}else{
						return json([
							'status'=> 1,
							'message' => '上传出错！'
						]);
					}
				}else{
					return json([
						'status'=> 1,
						'message'=> $audio_file->getError()
					]);
				}
			}else{
				return json([
					'status'=> 1,
					'message' => '请正确上传文件！'
				]);
			}
		}
		function rejectAnswer(){
			$id = (int)(input('id'));
			if(!empty($id)){
				$result = model('myanswer')->changeQuest($id, $this->login['id']);
				if($result){
					return json([
						'status'=> 0,
						'message' => '拒绝成功！'
					]);
				}else{
					return json([
						'status'=> 1,
						'message' => '拒绝失败！'
					]);
				}
			}else{
				return json([
					'status'=> 1,
					'message' => '列表错误！'
				]);
			}
		}
	}
 ?>