<?php

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;

use app\api\model\Product as ProductModel;

use app\lib\exception\ProductException;

class Product 
{
	public function getRecent($count = 15) {
		(new Count())->goCheck();

		$products = ProductModel::getMostRecent($count);
		//$collection = collection($products);
		$products = $products->hidden(['summary']);
		if($products->isEmpty()){
			throw new ProductException();
		}
		return $products;
	}

	public function getAllInCategory($id){
		(new IDMustBePositiveInt())->goCheck();
		
		$products = ProductModel::getProductsByCategory($id);
		if($products->isEmpty()){
			throw new ProductException();
		}
		$products = $products->hidden(['summary']);
		return $products;
	}

	public function getOne($id){
		(new IDMustBePositiveInt())->goCheck();

		$Product = ProductModel::getProductDetail($id);
		if(!$Product){
			throw new ProductException();
		}
		return $Product;
	}
}
