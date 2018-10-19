<?php

namespace app\api\model;

use think\Model;
use app\api\model\BaseModel;

class User extends BaseModel
{
    public function address(){
    	return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getByOpenID ($openid){
    	$user = self::where('openid', '=', $openid)->find();
    	return $user;
    }
}
