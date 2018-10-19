<?php

namespace app\api\controller\v1;

use app\api\service\Token as TokenService;

use app\api\model\Category as CategoryModel;

use app\lib\exception\CategoryException;

class Category 
{
	public function getAllCategories() {

		$category = CategoryModel::all([], 'img');
		
		if($category->isEmpty()){
			throw new CategoryException();
		}
		return $category;
	}
}
