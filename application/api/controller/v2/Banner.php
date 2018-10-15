<?php
namespace app\api\controller\v2;

use app\api\validate\IDMustBePositiveInt;

use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;

class Banner 
{
	/*
	 * 获取指定 id 的 banner 信息
	 * @url /banner/:id
	 * @http Get
	 * @id banner 的 id 号
	 */
	public function getBanner($id) {
		// 独立验证
		
		(new IDMustBePositiveInt())->goCheck();
		
		$banner = BannerModel::getBannerById($id);
		
		if(!$banner){
			throw new BannerMissException();
		}

		return $banner;
	}
}

?>
