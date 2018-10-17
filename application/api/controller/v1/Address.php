<?php

namespace app\api\controller\v1;

use app\api\validate\AddressNew;

use app\api\service\Token as TokenService;

use app\api\model\User as UserModel;

use app\lib\exception\CategoryException;

class Address 
{
	public function createOrUpdateAddress(){
		(new AddressNew())->goCheck();
		
		// 根据 Token 来获取 uid
		// 根据 uid 来查找用户数据，判断用户是否存在，如果不存在跑出错误
		// 获取用户从客户端提交来的地址信息
		// 根据用户地址信息是否存在判断，从而判断是添加地址还是更新地址
		$uid = TokenService::getCurrentUid();
		$user = UserModel::get($uid);
		if(!$uer){
			throw new UserException();
		}
	}
}
