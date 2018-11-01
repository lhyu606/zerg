<?php

namespace app\api\service;

use think\Cache;
use think\Request;
use think\Exception;

use app\lib\exception\TokenException;
use app\lib\exception\ForbiddenException;
use app\lib\enum\ScopeEnum;

class Token
{
	public static function generateToken(){
		// 32 个字符组成一组随机字符串
		$randChars = getRandChar(32);
		// 用三组字符串，进行 md5 加密
		$timestamp =$_SERVER['REQUEST_TIME_FLOAT'];
		// salt 盐
		$salt = config('secure.token_salt');

		return md5($randChars.$timestamp.$salt);
	}

	public static function getCurrentTokenVar($key){
		$token = Request::instance()->header('token');
		$vars = Cache::get($token);
		if(!$vars){
			throw new TokenException();
		} else {
			if(!is_array($vars)){
				$vars = json_decode($vars, true);
			}
			if(array_key_exists($key, $vars)){
				return $vars[$key];
			} else {
				throw new Exception('尝试获取的 Token 变量并不存在');
			}
		}
	}

	public static function getCurrentUid(){
		// token 
		$uid = self::getCurrentTokenVar('uid');
		return $uid;
	}

	// 用户和 CMS 管理员都可以访问的权限
	public static function needPrimaryScope(){
		$scope = self::getCurrentTokenVar('scope');
		if($scope){
			if($scope >= ScopeEnum::User){
				return true;
			} else {
				throw new ForbiddenException();
			}
		} else {
			throw new TokenException();
		}
	}

	// 只要用户才能访问权限
	public static function needExclusiveScpoe(){
		$scope = self::getCurrentTokenVar('scope');
		if($scope){
			if($scope == ScopeEnum::User){
				return true;
			} else {
				throw new ForbiddenException();
			}
		} else {
			throw new TokenException();
		}
	}

	public static function isValidOperate($checkedUid){
		if(!$checkedUid){
			throw new Exception('检查 UID 时，必须传入一个被检查的 UID');
		}
		$currentOperateUID = self::getCurrentUid();
		if($currentOperateUID == $checkedUid){
			return true;
		}
		return false;
	}
}
