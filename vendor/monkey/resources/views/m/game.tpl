<{extends file="extends/main.block.tpl"}>

<{block "head-styles-plus"}>
	<link rel="stylesheet" href="<{'static/css/m/game.css'|url}>">
	<link rel="stylesheet" href="<{'static/css/m/common.css'|url}>">
<{/block}>
<{block "head-scripts-plus"}>

<{/block}>

<{block "body-container"}>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 bgimg"><img src="<{'static/img/m/monkey/monkey_main.jpg'|url}>" class="img-responsive"></div>
			<div class="col-xs-12 hplogo"><img src="<{'static/img/m/monkey/hplogo.png'|url}>" class="img-responsive center-block"></div>
			<div class="rule"><img src="<{'static/img/m/monkey/monkey_rule.png'|url}>" class="img-responsive" data-toggle="modal" data-target=".bs-example-modal-sm"></div>
			<div class="start col-xs-12"><a href="<{'m/game/start'|url}>"><img src="<{'static/img/m/monkey/monkey_start.png'|url}>" class="img-responsive center-block"></a></div>
		</div>
	</div>
	<script type="text/javascript">
		(function($){
			//让图片满屏
			$('.bgimg').find('img').css({'height':$(window).height(),'width':$(window).width()});
		})(jQuery);
	</script>


<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  	<div class="container-fluid box">
  		<div class="row">
		    <div class="rule-content">
		     	<h5>游戏规则</h5>
		     	<div class="close"><a href="" class=""><img src="<{'static/img/m/monkey/monkey_close.png'|url}>" class="img-responsive"></a></div>
			    <div class="img-line"><img src="<{'static/img/m/monkey/monley_line.png'|url}>" class="img-responsive"></div>
			    <ol>
				    <li>游戏说明：通过手指下滑屏幕控制美猴抓取物品，获取相应积分;</li>
				    <li>新用户有一次玩游戏捞红包的机会，分享游戏给好友，可获取多次捞红包机会;</li>
				    <li>每次游戏获得的积分将兑换成红包放入您的账号，1积分=1元现金</li>
				    <li>获得的红包在购买“美猴捞红包”促销页面商品时使用;</li>
				    <li>每单仅限使用一个红包，可分多单购买;</li>
				    <li>本活动最终解释权在汉派商城</li>
			    </ol>

		     </div>
	     </div>
	</div>
</div>




<{/block}>

