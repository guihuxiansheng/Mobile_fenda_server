<?php 
	namespace app\api\controller;
	use \think\Session;
	use app\api\common\Common;
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
			return json(Common::create_phoneCode($this->login['id'],input('phone')));
		}
		function checkCode(){
			$code = input('code');
			return json(Common::check_phoneCode($this->login['id'], $this->login['phone_number'], $code));
		}
		function changePhone(){
			$phone = input('phone');
			$code = input('code');
			$result = Common::check_phoneCode($this->login['id'], $phone, $code);
			if($result['status'] === 0){
				if(model('User')->changePhone($this->login['id'],$phone)){
					return json([
						'status' => 0,
						'message' => '更改成功！'
					]);
				}else{
					return json([
						'status' => 1,
						'message' => '更改失败！'
					]);
				}
			}else{
				return json($result);
			}
		}
	}
 ?>