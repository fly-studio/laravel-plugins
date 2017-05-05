<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MakeWechats extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
		\DB::transaction(function() {
			\Illuminate\Database\Eloquent\Model::unguard(true);

			$fields = [
				'wechat|微信' => [
					'type|公众号类型' => [
						'news|订阅号' => [],
						'service|服务号' => [],
						'enterprise|企业号' => [],
					],
					'message_type|消息类型' => [
						'depot|素材' => [],
						'news|图文' => [],
						'image|图片' => [],
						'thumb|缩略图' => [],
						'video|视频' => [],
						'shortvideo|小视频' => [],
						'voice|音频' => [],
						'music|音乐' => [],
						'text|文字' => [],
						'link|连接' => [],
						'location|地址' => [],
						'callback|回调' => [],
						'event|事件' => [],
					],
					'event_type|事件类型' => [
						'subscribe|关注' => [],
						'unsubscribe|取消关注' => [],
						'SCAN|扫描二维码' => [],
						'LOCATION|地址' => [],
						'CLICK|点击' => [],
						'VIEW|视图' => [],
						'scancode_push|扫描事件' => [],
						'scancode_waitmsg|扫描事件「非跳转」' => [],
						'pic_sysphoto|系统拍照发图' => [],
						'pic_photo_or_album|拍照或者相册发图' => [],
						'pic_weixin|相册发图' => [],
						'location_select|地址选择' => [],
					],
				],
			];

			\App\Catalog::import($fields, \App\Catalog::findByName('fields'));

			//添加权限
			\App\Permission::import([
				'wechat-account' => '微信公众号',
				'wechat-depot' => '微信素材',
				'wechat-menu' => '微信菜单',
				'wechat-message' => '微信消息',
				'wechat-reply' => '微信自定义回复',
				'wechat-user' => '微信用户',
			]);
			\App\Role::findByName('super')->perms()->sync(\App\Permission::all());

			\Illuminate\Database\Eloquent\Model::unguard(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{

	}
}
