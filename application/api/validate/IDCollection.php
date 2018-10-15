<?php

namespace app\api\validate;

use app\api\validate\BaseValidate;

class IDCollection extends BaseValidate
{
	protected $rule = [
		'ids' => 'require|checkIDs'
	];

	protected $message = [
		'ids' => 'ids 参数必须为是以逗号分隔的多个正整数'
	];
	
	protected function checkIDs($value){
		$value = explode(',', $value);
		if(empty($value)){
			return false;
		}
		foreach ($value as $id) {
			if(!$this->isPositiveInteger($id)){
				return false;
			}
		}
		return true;
	}
}
