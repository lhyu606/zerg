<?php

namespace app\api\controller\v1;

use app\api\validate\AddressNew;

use app\api\service\Token as TokenService;

use app\api\model\User as UserModel;

use app\lib\exception\CategoryException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;

use app\api\controller\BaseController;

class Address extends BaseController
{
	protected $beforeActionList = [
		'checkPrimaryScope' => ['only'=>'createOrUpdateAddress']
	];

	
	// protected $beforeActionList = [
	// 	'first' => ['only' => 'second,third']
	// ];

	// protected function first(){
	// 	echo 'first';
	// }

	// // API 接口
	// public function second(){
	// 	echo 'second';
	// }

	// public function third(){
	// 	echo 'third';
	// }

	public function createOrUpdateAddress(){
		$validate = new AddressNew();
		$validate->goCheck();
		
		// 根据 Token 来获取 uid
		// 根据 uid 来查找用户数据，判断用户是否存在，如果不存在抛出错误
		// 获取用户从客户端提交来的地址信息
		// 根据用户地址信息是否存在判断，从而判断是添加地址还是更新地址
		$uid = TokenService::getCurrentUid();
		$user = UserModel::get($uid);
		if(!$user){
			throw new UserException();
		}
		$dataArray = $validate->getDataByRule(input('post.'));
		$userAddress = $user->address;
		if(!$userAddress){
			$user->address()->save($dataArray);
		} else {
			$user->address->save($dataArray);
		}
		// return $user;
		return json(new SuccessMessage(), 201);
	}
}
