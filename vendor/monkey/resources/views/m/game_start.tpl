<{extends file="extends/main.block.tpl"}>

<{block "head-styles-plus"}>
	<link rel="stylesheet" href="<{'static/css/m/game.css'|url}>">
    <link rel="stylesheet" href="<{'static/css/m/monkey.css'|url}>">
    <link rel="stylesheet" href="<{'static/css/m/common.css'|url}>">
<{/block}>
<{block "head-scripts-plus"}>
	<script>var $ = jQuery.noConflict();</script> 
    <script type="text/javascript" src="<{'static/js/monkey/jquery.touchSwipe.min.js'|url}>"></script>
    <script type="text/javascript" src="<{'static/js/monkey/jquery.easing.min.js'|url}>"></script>
    <script type="text/javascript" src="<{'static/js/monkey/jquery.rotate.min.js'|url}>"></script>
    <script type="text/javascript" src="<{'static/js/monkey/wave.js'|url}>"></script>
    <script type="text/javascript" src="<{'static/js/monkey/youxi_V3.js'|url}>"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>var type_id = <{$_type_id}>;var save_score_url='<{"/m/game/save_score"|url}>';</script>
<{/block}>
<{block "body-container"}>
	 <!-- 游戏开始，弹出页面 -->
    <div class="game_start">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 bgimg"><img src="<{'static/img/m/monkey/monkey_main.jpg'|url}>" class="img-responsive"></div>
                <div class="col-xs-12 hplogo"><img src="<{'static/img/m/monkey/hplogo.png'|url}>" class="img-responsive center-block"></div>
                <div class="rule"><img src="<{'static/img/m/monkey/monkey_rule.png'|url}>" class="img-responsive" data-toggle="modal" data-target=".bs-example-modal-sm"></div>
                <div id="begin" class="start col-xs-12"><a><img src="<{'static/img/m/monkey/monkey_start.png'|url}>" class="img-responsive center-block"></a></div>
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
    </div>

    <div class="end"></div>
    <div class="prompt">
    	<div class="sign"><img src="<{'static/img/m/monkey/sign.png'|url}>" /></div>
        <div class="arrow"><img src="<{'static/img/m/monkey/arrow.png'|url}>" /></div>
        <div class="hand"><img src="<{'static/img/m/monkey/hand.png'|url}>" /></div>
    </div>
	<div class="main">
    	<div class="button_stop"></div>
        <div class="chumo"></div>
    	<form name="input">
            <div class="fenshu">当前分数：<input type="text" name="Score" value="0" size="5" readonly></div>  
            <div class="yonghu_Id"> <input type="text" name="user_Id" value="<{$_uid}>" size="5" readonly></div> 
            <div class="youxi_Num"> <input type="text" name="game_Num" value="1" size="5" readonly></div>     
            <h2 class="time">时间：<span></span></h2>
        </form> 
        <h1 class="jiafen"></h1>
        <a class="lao">捞</a>
        <div id="wave">
        	<input type="range" id="range" min="0" max="1" step="0.01" />			
        </div>
        <div class="zhuanpan">
            <div class="monkey">
                <div class="rope"></div>
                <div class="monkey_wu">
                    <span class="monkey_mid"></span>
                    <span class="wu_pic"><img src="<{'static/img/m/monkey/monkey_wu.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_hongbao">
                    <span class="houHb_pic"><img src="<{'static/img/m/monkey/hou_hongbao.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_star">
                    <span class="houXx_pic"><img src="<{'static/img/m/monkey/hou_star.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_yuanbao">
                    <span class="houYb_pic"><img src="<{'static/img/m/monkey/hou_yuanbao.png'|url}>"/></span>
                </div>               
                <div class="monkey_you monkey_fubao1">
                    <span class="houFb_pic"><img src="<{'static/img/m/monkey/hou_fubao1.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_fubao2">
                    <span class="houFb_pic"><img src="<{'static/img/m/monkey/hou_fubao2.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_fubao3">
                    <span class="houFb_pic"><img src="<{'static/img/m/monkey/hou_fubao3.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_fubao4">
                    <span class="houFb_pic"><img src="<{'static/img/m/monkey/hou_fubao4.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_halfmoon1">
                    <span class="houHm1_pic"><img src="<{'static/img/m/monkey/hou_halfmoon1.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_halfmoon2"></div>
                <div class="monkey_you monkey_halfmoon3"></div>
                <div class="monkey_you monkey_fullmoon">
                    <span class="houFm_pic"></span>
                </div>
            </div>            
		</div>
        <div class="leaf"></div>
        <audio id="bg_music"  src="<{'static/img/m/monkey/backmusic.mp3'|url}>" controls="controls" loop="loop">
		</audio>
        <audio id="music1" src="<{'static/img/m/monkey/gain.wav'|url}>" controls="">		  
		</audio>
        <div class="fubao_say say"></div>
        <div class="hongbao_say say"></div>
        <div class="yuanbao_say say"></div>
        <div class="star_say say"></div>
        <div class="moon_say say"></div>
        <div class="kong_say say"></div>       
        <span class="baby baby1" name="hongbao"><b>1</b></span>
        <span class="baby baby2" name="hongbao"><b>2</b></span>
        <span class="baby baby3" name="hongbao"><b>3</b></span>
        <span class="baby baby4" name="fubao1"><b>4</b><img src="<{'static/img/m/monkey/fubao1.png'|url}>"/></span>
        <span class="baby baby5" name="fubao2"><b>5</b><img src="<{'static/img/m/monkey/fubao2.png'|url}>"/></span>
        <span class="baby baby6" name="fubao3"><b>6</b><img src="<{'static/img/m/monkey/fubao3.png'|url}>"/></span>
        <span class="baby baby7" name="fubao4"><b>7</b><img src="<{'static/img/m/monkey/fubao4.png'|url}>"/></span>
        <span class="baby baby8" name="yuanbao"><b>8</b><img src="<{'static/img/m/monkey/yuanbao1.png'|url}>"/></span>
        <span class="baby baby9" name="yuanbao"><b>9</b><img src="<{'static/img/m/monkey/yuanbao1.png'|url}>"/></span>
        <span class="baby baby10" name="star"><b>10</b><img src="<{'static/img/m/monkey/star.png'|url}>"/></span>
        <span class="baby baby11" name="star"><b>11</b><img src="<{'static/img/m/monkey/star.png'|url}>"/></span>
        <span class="baby baby12" name="star"><b>12</b><img src="<{'static/img/m/monkey/star.png'|url}>"/></span>
        <span class="baby baby13" name="star"><b>13</b><img src="<{'static/img/m/monkey/star.png'|url}>"/></span>
        <span class="baby baby14" name="star"><b>14</b><img src="<{'static/img/m/monkey/star.png'|url}>"/></span>
        <span class="baby baby15" name="star"><b>15</b><img src="<{'static/img/m/monkey/star.png'|url}>"/></span>
        <span class="full_moon" name="fullM"></span>
        <span class="half half_moon1" name="halfM1"></span>
        <span class="half half_moon2" name="halfM2"></span>
        <span class="half half_moon3" name="halfM3"></span>
    </div>
    <!-- 游戏结束，弹出页面 -->
    <div class="end-box">
        <div class="container-fluid">
            <div class="row text-center">
               <h5 class="">恭喜您！</h5>
               <h6 class="">您本次获得<span></span>红包</h6>
               <div class="restart"><a class="btn btn-success" href="<{'game/start'|url}>" role="button">再玩一次</a></div>
               <small class="text-muted">您现在还有<span class="text-danger"><{$_times}></span>次红包游戏机会<br/>点击下面"分享红包"获取更多红包</small>
               <div class="share"><a class="btn btn-danger" href="#" role="button">分享红包</a></div>

               <p class="text-muted">您现在共有<span class="text-danger" id="bonus_cnt"><{$_bonus_cnt}></span>个现金红包</p>
               <div class=""><a class="btn btn-warning" href="<{'m/activity/special?type_id=3'|url}>" role="button">使用红包</a></div>

            </div>
         </div>
        </div>
    </div>
    <div class="tip"><p><span>请点击右上角</span><span>选择“发送给朋友”</span><span>然后点击“发送”</span></p></div>
<{/block}>
<{block "body-scripts-jquery"}>
	wx.config(js = {
		debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		appId: '<{$_wechat.appid|escape}>', // 必填，公众号的唯一标识
		timestamp: '<{$_wechat.timestamp|escape}>', // 必填，生成签名的时间戳
		nonceStr: '<{$_wechat.noncestr|escape}>', // 必填，生成签名的随机串
		signature: '<{$_wechat.signature|escape}>',// 必填，签名，见附录1
		jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','hideMenuItems'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});
	//分享数据
	var wxData = {
		"imgUrl": '<{$_data.imgUrl|url}>',
		"link": '<{$_share_url|@addslashes}>',
		"desc": '​<{$_data.desc}>',
		"title": '<{$_data.title|escape}>'
	};
	
	wx.ready(function(){
		wx.onMenuShareTimeline(wxData);
		wx.onMenuShareAppMessage(wxData);
		wx.hideMenuItems({
			menuList: ['menuItem:share:qq','menuItem:share:weiboApp'] // 要隐藏的菜单项，所有menu项见附录3
            
		});
        

	});
<{/block}>