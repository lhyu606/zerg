<?php

namespace app\lib\exception;

use app\lib\exception\BaseException;

class BannerMissException extends BaseException
{
	public $code = 404;

	public $msg = '请求的 banner 不存在';

	public $errorCode = 10000;
}
