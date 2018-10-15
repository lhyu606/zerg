<?php

namespace app\api\model;

use app\api\model\BaseModel;

class Product extends BaseModel
{
    protected $hidden = [
    	'delete_time', 'main_img_id', 'pivot', 'from', 'category_id', 'create_time', 'update_time'
    ];

    public function getMainImgUrlAttr($value, $data) {
    	return $this->prefixImgUrl($value, $data);
    }

    public static function getMostRecent($count){
    	$products = self::limit($count)->order('create_time desc')->select();
    	return $products;
    }

    public static function getProductsByCategory($CategoryID){
    	$products = self::where('category_id', '=', $CategoryID)->select();
    	return $products;

    }
}
