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
	}
 ?>