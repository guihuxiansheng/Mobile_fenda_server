<?php 
	namespace app\api\common;
	use \think\captcha\Captcha;
	/**
	* 
	*/
	class Common extends \think\Model
	{
		public static function getRandom($param=32){
		    $str="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		    $key = "";
		    for($i=0;$i<$param;$i++)
		     {
		         $key .= $str{mt_rand(0,32)};    //生成php随机数
		     }
		     return $key;
		}
		/**
		 * [check_verify 验证图片验证码]
		 * @param  [string] $code [验证码]
		 * @param  string $id   [标识id]
		 * @return [type]       [验证结果]
		 */
		 public static function check_verify($code, $id=''){
		 	$captcha = new Captcha();
		 	return $captcha->check($code, $id);
		}
		/**
		 * [create_verify 生成图片验证码]
		 * @param  string $id [表示id]
		 * @return [type]     [图片数据]
		 */
		public static function create_verify($id=''){
		 	$captcha = new Captcha();
		 	$captcha->useCurve = false;
		 	if(empty($id)){
		 		return $captcha->entry();
		 	}
			return $captcha->entry($id);
		}
		/**
		 * [create_phoneCode 生成手机验证码]
		 * @param  [string] $id    [用户id]
		 * @param  [string] $phone [手机号]
		 * @return [obj]        [生成结果]
		 */
		public static function create_phoneCode($id,$phone){
			if(preg_match_all('/^1[34578]\d{9}$/', $phone)){
				$state = self::phoneVerify(rand(100000,1000000),$id,$phone);
				if($state){
					return [
						'status' => 0,
						'message' => '发送成功！'
					];
				}
				return [
					'status' => 1,
					'message' => '请勿频繁发送！'
				];
			}else{
				return [
					'status' => 1,
					'message' => '号码错误！'
				];
			}
		}
		/**
		 * [check_phoneCode 验证手机验证码]
		 * @param  [string] $id    [用户id]
		 * @param  [string] $phone [手机号]
		 * @param  [string] $code  [验证码]
		 * @return [obj]        [验证结果]
		 */
		public static function check_phoneCode($id, $phone, $code){
		 	if(preg_match_all('/^1[34578]\d{9}$/', $phone)){
				if(strlen($code) !== 6 || empty($code)){
					return [
						'status' => 1,
						'message' => '手机验证码错误！'
					];
				}
				$phone_check = self::getCode($phone);
				if(!empty($phone_check) && $phone_check['uid'] ===$id && $phone_check['code'] == $code && $phone_check['phone'] == $phone){
					db('captcha')->where(['phone'=>$phone])->delete();
					if(time() - $phone_check['create_time'] > 5*60){
						return [
							'status' => 1,
							'message' => '手机验证码错误！'
						];
					}else{
						return [
							'status' => 0,
							'message' => '验证成功！'
						];
					}
				}else{
					return [
						'status' => 1,
						'message' => '手机验证码错误！'
					];
				}
			}else{
				return [
					'status' => 1,
					'message' => '手机号错误！'
				];
			}
		}
		/**
		 * [findUser 查找用户]
		 * @param  [type] $phone [手机号]
		 * @return [type]        [返回false或用户信息]
		 */
		public static function findUser($phone){
			try{
				$db_find = db('user')->where(['phone_number'=>$phone])->find();
				if(empty($db_find)){
					return false;
				}else{
					return $db_find;
				}
			}catch(\Exception $e){
				return false;
			}
		}
		public static function user_exit($phone){
			$user = self::findUser($phone);
			if(empty($user)){
				return false;
			}else{
				return true;
			}
		}
		/**
		 * [getCode 获取数据库的验证码数据]
		 * @param  [string] $id [用户id]
		 * @return [obj]     [查询结果]
		 */
		private static function getCode($phone){
			return db('captcha')->where(['phone'=>$phone])->find();
		}
		/**
		 * [phoneVerify 保存验证码到数据库]
		 * @param  [string] $code  [手机验证码]
		 * @param  [string] $id    [用户id]
		 * @param  [string] $phone [手机号]
		 */
		private static function phoneVerify($code,$id,$phone){
			try{
				$phone_check = self::getCode($phone);
				if(!empty($phone_check) && time() - $phone_check['create_time'] < 5*60 ){
					return false;
				}
				db('captcha')->where(['phone'=>$phone])->delete();
				db('captcha')->insert(['uid'=>$id,'code'=>$code,'phone'=>$phone,'create_time' => time()]);
				return true;
			}catch(\Exception $e){
				return false;
			}
		}
	}
 ?>