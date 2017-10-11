<?php
	namespace app\admin\validate;

	use \think\Validate;

	/**
	* 
	*/
	class User extends Validate
	{
		protected $rule = [
			['admin', 'require|max:25', '用户名不能为空！|用户名长度过长！'],
			['password', 'require|min:5','密码不能为空！|密码长度必须大于等于5！' ]
		];
	}
?>