<?php

namespace app\api\validate;

use think\Validate;
use app\api\validate\BaseValidate;

class TokenGet extends BaseValidate
{
	protected $rule = [
		'code' => 'require|isNotEmpty'
	];

	protected $message = [
		'code' => 'code 丢失'
	];
	
}
