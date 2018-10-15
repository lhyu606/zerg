<?php

namespace app\api\model;

use app\lib\exception\BaseException;

use think\Db;
use think\Model;

class Banner extends Model
{
	public function items () {
		return $this->hasMany('bannerItem', 'banner_id', 'id');
	}

	protected $hidden = ['delete_time', 'update_time'];

	// protected $table = 'banner_item';
	public static function getBannerById ($id) {
		// TODO: 根据 banner ID 号，获取 banner 信息
		// $result = Db::query('select  * from banner_item where banner_id=?', [$id]);
		// return $result;
		
		// $result = Db::table('banner_item')->where('banner_id', '=', $id)->select();
		// 闭包方式
		// $result = Db::table('banner_item')->batch()->where(function($query) use ($id) {
		// 	$query->where('banner_id', '=', $id);
		// })->select();

		$banner = self::with(['items', 'items.img'])->find($id);

		return $banner;
	}
}

// 模型创建
// zerg> php think make:model api/BannerItem

// Db  		find() select()
// Model 	get()  all() find() select()
?>
