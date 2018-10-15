<?php

namespace app\api\model;

use think\Model;
use app\api\model\BaseModel;

class BannerItem extends BaseModel
{	
	protected $hidden = ['id', 'delete_time', 'update_time', 'img_id', 'banner_id'];

    public function img() {
    	return $this->belongsTo('Image', 'img_id', 'id');
    }
}
