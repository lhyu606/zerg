<?php

namespace app\api\service;

use app\lib\exception\WeChatException;
use app\lib\exception\tokenException;
use app\lib\enum\ScopeEnum;

use app\api\model\User as UserModel;

use app\api\service\Token;

class UserToken extends Token
{
	protected $code;
	protected $wxAppID;
	protected $wxAppSecret;
	protected $wxLoginUrl;

	function __construct($code){
		$this->code = $code;
		$this->wxAppID = config('wx.app_id');
		$this->wxAppSecret = config('wx.app_secret');
		$this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
	}

	public function get(){
		$result = curl_get($this->wxLoginUrl);
		
		$wxResult = json_decode($result, true);
		
		if(empty($wxResult)){
			throw new Exception(['获取 session_key 及 openID 时异常，微信内部错误']);
		} else {
			$loginFail = array_key_exists('errcode', $wxResult);
			if($loginFail){
				$this->processLoginError($wxResult);
			} else {
				$token = $this->grantToken($wxResult);
				return $token;
			}
		}
	}

	private function grantToken($wxResult){
		// 拿到 openid
		// 数据库检查 openid 是否存在
		// 如果存在，则不处理，否则，新增一条 user 记录
		// 生成令牌，准备缓存数据，写入缓存
		$openid = $wxResult['openid'];
		$user = UserModel::getByOpenID($openid);
		if($user){
			$uid = $user->id;
		} else {
			$uid = $this->newUser($openid);
		}
		$cacheValue = $this->prepareCachedValue($wxResult, $uid);
		$token = $this->saveToCache($cacheValue);
		return $token;
	}

	private function saveToCache($cacheValue){
		$key = self::generateToken();
		$value = json_encode($cacheValue);
		$expire_in = config('setting.token_expire_in');

		$request = cache($key, $value, $expire_in);
		if(!$request){
			throw new tokenException([
				'msg' => '服务器缓存异常',
				'errCode' => 10005
			]);
		} 
		return $key;
	}

	private function prepareCachedValue($wxResult, $uid){
		$cacheValue = $wxResult;
		$cacheValue['uid'] = $uid;
		// scope = 16 代表 APP 用户权限数值
		$cacheValue['scope'] = ScopeEnum::User;
		// scope = 32 代表 CMS 用户权限数值
		// $cacheValue['scope'] = 32;
		return $cacheValue;
	}

	private function newUser($openid){
		$user = UserModel::create([
			'openid' => $openid
		]);
		return $user->id;
	}

	private function processLoginError($wxResult){
		throw new WeChatException([
			'msg' => $wxResult['errmsg'],
			'errorCode' => $wxResult['errcode']
		]);
	}
}
