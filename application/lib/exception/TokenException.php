<?php

namespace app\lib\exception;

use app\lib\exception\BaseException;

class TokenException extends BaseException
{
	public $code = 401;

	public $msg = 'Token 已过期或无效 Token';

	public $errorCode = 10001;
}
