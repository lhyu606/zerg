<?php

namespace app\api\model;

use app\api\model\BaseModel;

class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id', 'delete_time', 'update_time'];

}
