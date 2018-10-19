<?php

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;

use app\api\validate\OrderPlace;

use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;

use app\api\controller\BaseController;

class Order extends BaseController
{
	// 用户在选择商品时，向 api 提交包含他所选择商品的相关信息
	// API 在接受到消息后，需要检查订单相关商品库存
	// 有库存，把订单数据存入数据库，下单成功，返回客户端消息，告诉客户可以支付了
	// 请用我们的支付接口，进行支付
	// 还需要再次进行库存量检查
	// 服务器就可以调用微信的支付接口进行支付
	// 微信会返还一个支付结果（异步）
	// 成功，也需要进行库存量检查
	// 成功，进行库存量扣除，失败，返回一个支付失败的结果

	protected $beforeActionList = [
		'checkExclusiveScope' => ['only' => 'placeOrder']
	];

	public function placeOrder(){
		(new OrderPlace())->goCheck();
	}

	public function deleteOrder(){
		
	}
}
