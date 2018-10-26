<?php

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;
use app\api\service\Order as OrderService;

use app\api\validate\OrderPlace;

use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\lib\enum\ScopeEnum;

use app\api\controller\BaseController;

class Pay extends BaseController
{
	protected function checkPrimaryScopt(){
		TokenService::needPrimaryScope();
	}

	protected function checkExclusiveScope(){
		TokenService::needExclusiveScope();
	}
}