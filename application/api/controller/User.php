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
				$path = $info->getSaveName();
				Session::set('image','uploads'.DS.$path);

				return json([
					'status'=>0,
					'message'=> '上传成功！',
					'src' => 'uploads'.DS.$path
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
		// 修改个人资料
		function saveProfile(){
			$rule = [
			    'title'  => 'require|max:18',
			    'nickname'   => 'require|max:16',
			    'problem' => 'require',
			    'money' => 'require|number| min:0.01 | max:1000 | regex:^d.d{2}'
			];

			$msg = [
			    'title.require' => '头衔不能为空',
			    'title.max' => '头衔不能超过18个字符',
			    'nickname.require'     => '昵称不能为空',
			    'nickname.max'   => '昵称不能超过16个字符',
			    'problem.require'   => '问题不能为空',
			    'money.require'   => '金额不能为空',
			    'money.number'   => '金额必须为数字',
			    'money.min'   => '金额必须≥0.01',
			    'money.max'   => '金额必须≤1000',
			    'money.regex'   => '金额必须为两位小数'
			];
			$data = [
				'title'  => input('title'),
			    'nickname'   => input('nickname'),
			    'problem' => input('problem'),
			    'money' => input('money'),
			    'head_pic' => Session::get('image')
			];
			$validate = new Validate($rule, $msg);
			$result   = $validate->check($data,$this->login['id']);
			if($result){
				model('User')->saveProfile($data);
			}else{
				return json([
					'status'=> 0,
					'message'=> $validate->getError()
				]);
			}
		}
	}
 ?>