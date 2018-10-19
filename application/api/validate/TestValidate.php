<?php

namespace app\api\validate;

use think\Validate;
use app\api\validate\BaseValidate;

class TestValidate extends BaseValidate
{
	protected $rule = [
		'name' => 'require|max:10',
		'email' => 'email'
	];
}
