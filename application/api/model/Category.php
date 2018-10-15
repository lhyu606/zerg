<?php

namespace app\api\model;

use app\api\model\BaseModel;

class Category extends BaseModel
{
	protected $hidden = ['delete_time', 'topic_img_id', 'update_time'];
    public function img(){
    	return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}
