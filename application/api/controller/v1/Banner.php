<?php
namespace app\api\controller\v1;

use app\api\validate\TestValidate;
use app\api\validate\IDMustBePositiveInt;
use think\Validate;
use think\Exception;

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
		// $data = [
		// 	'id' => $id,
		// 	// 'name' => 'vendor11111',
		// 	// 'email' => 'vendor@qq.com'
		// ];

		// $validate = new Validate([
		// 	'name' => 'require|max:10',
		// 	'email' => 'email'
		// ]);

		//$result = $validate->batch()->check($data);
		// if($result){
		// 	echo $result;
		// } else {
		// 	var_dump($validate->getError());
		// }
		
		(new IDMustBePositiveInt())->goCheck();
		// try
		// {
			// $banner = BannerModel::getBannerById($id);
		// }
		// catch (Exception $ex)
		// {
		// 	$err = [
		// 		'error_code' => 10001,
		// 		'msg' => $ex->getMessage()
		// 	];
		// 	return json($err, 400);
		// };

		// $banner = new BannerModel();
		// $banner = $banner->get($id);

		$banner = BannerModel::getBannerById($id);
		// $data = $banner->toArray();
		// unset($data['delete_time']);
		// var_dump($banner);
		// $banner->hidden(['delete_time', 'update_time']);
		// $banner->visibale(['delete_time', 'update_time']);
		if(!$banner){
			throw new BannerMissException();
			// throw new Exception("内部错误");
			
		}

		return $banner;
	}
}

?>
