<?php 
	namespace app\api\controller;
	use \think\Session;
	/**
	* 
	*/
	class User extends Islogin
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
		function index(){

		}
		function upload(){
			$file_pic = request()->file('image');
			$info = $file_pic->validate(['size'=>1048576,'ext'=>'jpeg,jpg,png,gif'])->move('uploads');
			if($info){
				Session::set('image','uploads'.DS.$info->getExtension());

				return json([
					'status'=>0,
					'message'=> '上传成功！'
				]);
			}else{
				return json([
					'status'=>2,
					'message'=> $file_pic->getError()
				]);
			}
			
		}
		function verify(){
			if(empty(input('id'))){
				return Common::create_verify();
			}else{
				return Common::create_verify(input('id'));
			}
		}
		function phone(){
			if(empty(input('phone'))){
				return json([
					'status' => 1,
					'message' => '号码不正确！'
				]);
			}
			if(preg_match_all('/^1[34578]\d{9}$/', input('phone'))){
				model('User')->phoneVerify(rand(100000,1000000),$this->login['id'],input('phone'));
				return json([
					'status' => 0,
					'message' => '发送成功！'
				]);
			}else{
				return json([
					'status' => 1,
					'message' => '号码不正确！'
				]);
			}
		}
		function checkCode(){
			$code = input('code');
			if(empty($code)){
				return json([
					'status' => 1,
					'message' => '手机验证码不正确！'
				]);
			}
			$db_code = model('User')->getCode($this->login['id']);
			if(!empty($db_code) && $db_code['code'] == $code){
				return json([
					'status' => 0,
					'message' => '手机验证码正确'
				]);
			}else{
				return json([
					'status' => 1,
					'message' => '手机验证码错误！'
				]);
			}
		}
		function changePhone(){
			$phone = input('phone');
			$code = input('code');
			if(preg_match_all('/^1[34578]\d{9}$/', $phone)){
				if(strlen($code) !== 6){
					return json([
						'status' => 1,
						'message' => '验证码错误！'
					]);
				}
				$phone_check = model('User')->getCode($this->login['id']);
				if(!empty($phone_check) && $phone_check['code'] == $code && $phone_check['phone'] == $phone){
					if(model('User')->changePhone()){
						return json([
							'status' => 0,
							'message' => '更改成功！'
						]);
					}
					return json([
						'status' => 1,
						'message' => '更改失败！'
					]);
				}else{
					return json([
						'status' => 1,
						'message' => '信息错误！'
					]);
				}
			}else{

			}
		}
	}
 ?>