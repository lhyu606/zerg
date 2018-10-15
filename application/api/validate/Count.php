<?php

namespace app\api\validate;

use think\Validate;
use app\api\validate\BaseValidate;

class Count extends BaseValidate
{
	protected $rule = [
		'count' => 'isPositiveInteger|between:1,15'
	];

	protected $message = [
		'count' => 'count 必须是 1-15 之间的正整数'
	];
	
}


?>
