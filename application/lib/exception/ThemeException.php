<?php

namespace app\lib\exception;

use app\lib\exception\BaseException;

class ThemeException extends BaseException
{
	public $code = 404;

	public $msg = '指定主题不存在，请检查 ID';

	public $errorCode = 30000;
}
