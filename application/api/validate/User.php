<?php
	namespace app\api\validate;

	use \think\Validate;

	/**
	* 
	*/
	class User extends Validate
	{
		protected $rule = [
			['phone_number', 'require|number|length:11', '用户名不能为空！|手机号不合法！|手机号必须为11位！'],
			['captcha', 'require|min:2','验证码不能为空！|验证码不正确！' ]
		];
	}
?>