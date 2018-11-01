<?php

namespace app\api\service;

use app\api\model\Order as OrderModel;

use app\api\service\Order as OrderService;
use app\api\service\Token;

use think\Exception;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;

use app\lib\enum\OrderStatusEnum;

class Pay
{
	private $orderID;
	private $orderNO;

	function __construct($orderID){
		if(!$orderID){
			throw new Exception('订单号不允许为 NULL');
		}
		$this->orderID = $orderID;
	}

	public function(){
		// 订单号可能不存在
		// 订单号存在，但是和用户不匹配
		// 订单可能已经支付过
		// 进行库存量检测
		$this->checkOrderValid();
		$orderService = new OrderService();
		$status = $orderService->checkOrderStock($this->orderID);
		if(!$status['pass']){
			return $status;
		}
	}

	private function makeWxPreOrder(){
		// openid
		$openid = Token::getCurrentTokenVar('openid');
		if(!openid){
			throw new TokenException();
		}
	}

	private function checkOrderValid(){
		$order = OrderModel::where('id', '=', $this->orderID)->find();
		if(!$order){
			throw new OrderException([]);
		}
		if(!Token::isValidOperate($order->user_id)){
			throw new TokenException([
				'msg' => '订单与用户不匹配',
				'errorCode' => 10003
			]);
		}
		// 1 代表待支付
		if($order->status != OrderStatusEnum::UNPAID){
			throw new OrderException([
				'msg' => '订单已支付过啦',
				'errorCode' => 80003,
				'code' => 400
			]);
		}
		$this->orderNO = $order->order_no;
		return true;
	}
}