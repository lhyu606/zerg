<?php

namespace app\api\validate;

use think\Exception;
use think\Request;
use think\Validate;

use app\lib\exception\ParameterException;

class BaseValidate extends Validate
{
	public function goCheck () {
		// 获取 http 传入的参数
		// 对参数校验
		$request = Request::instance();
		$params = $request->param();

		$result = $this->batch()->check($params);
		if(!$result) {
			$e = new ParameterException([
				'msg' => $this->error,
				'code' => '400',
				'errorCode' => '10002'
			]);
			//$error = $this->error;
			//throw new Exception($error);
			//$e->msg = $this->error;
			throw $e;
		} 
		else {
			return true;
		} 
	}

	protected function isPositiveInteger ($value, $rule = '',
	 $data = '', $field = '') {
		if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
			return true;
		}
		else {
			return false;
			//return $field.' 必须是正整数';
		}
	}

	protected function isNotEmpty($value, $rule = '', $data, $field){
		if(empty($value)){
			return false;
		} else {
			return true;
		}
	}
}

?>
