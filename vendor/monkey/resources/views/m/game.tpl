<{extends file="extends/main.block.tpl"}>

<{block "head-styles-plus"}>
	<link rel="stylesheet" href="<{'plugins/css/m/game.css'|url}>">
    <link rel="stylesheet" href="<{'plugins/css/m/monkey.css'|url}>">
    <link rel="stylesheet" href="<{'static/css/m/common.css'|url}>">
<{/block}>
<{block "head-scripts-plus"}>
	<script>var $ = jQuery.noConflict();</script> 
    <script type="text/javascript" src="<{'plugins/js/monkey/jquery.touchSwipe.min.js'|url}>"></script>
    <script type="text/javascript" src="<{'plugins/js/monkey/jquery.easing.min.js'|url}>"></script>
    <script type="text/javascript" src="<{'plugins/js/monkey/jquery.rotate.min.js'|url}>"></script>
    <script type="text/javascript" src="<{'plugins/js/monkey/wave.js'|url}>"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>var type_id = <{$_type_id}>;var save_score_url='<{"/m/game/save_score"|url}>';var ver_code='<{$_save_put_code}>';</script>
	<script type="text/javascript" src="<{'plugins/js/monkey/youxi_v3.js'|url}>"></script>
<{/block}>
<{block "body-container"}>
	 <!-- 游戏开始，弹出页面 -->
    <div class="game_start">
<!--       <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 bgimg"><img src="<{'plugins/img/m/monkey/welcome.png'|url}>" class="img-responsive"></div>
                <div class="col-xs-12 hplogo"><img src="<{'plugins/img/m/monkey/hplogo.png'|url}>" class="img-responsive center-block"></div>
                <div class="rule"><img src="<{'plugins/img/m/monkey/monkey_rule.png'|url}>" class="img-responsive" data-toggle="modal" data-target=".bs-example-modal-sm"></div>
                <div id="begin" class="start col-xs-12"><a><img src="<{'plugins/img/m/monkey/monkey_start.png'|url}>" class="img-responsive center-block"></a></div>
            </div>
        </div>-->
        <script type="text/javascript">
            (function($){
                //让图片满屏
                //$('.bgimg').find('img').css({'height':$(window).height(),'width':$(window).width()});
            })(jQuery);
        </script>
        
        <div class="welcome"></div>
        <div class="start_bt" id="begin"><img src="<{'plugins/img/m/monkey/star_bt.png'|url}>" /></div>
        <div class="reward_bt"><img src="<{'plugins/img/m/monkey/reward_bt.png'|url}>" /></div>
        <p class="use_hb"><a href="<{'m/special?type_id=3'|url}>"><img src="<{'plugins/img/m/monkey/use_hb.png'|url}>" /></a></p>
        <div class="tip1"></div>
        <div class="lucky_chart">
        	<div class="lucky_box">
        		<{if !empty($_bonus_list)}>
        			<{foreach $_bonus_list $bonus}>
        			<{if $bonus@index % 3 == 0}>
        			<ul class="lucky_team<{$bonus@index/3+1}>">
        			<{/if}>
         			<li>恭喜<span class="winning_user"><{$bonus.users.nickname}></span>抢到<span class="prize_amount"><{$bonus.bonus}></span>元红包</li>        			
        			<{if $bonus@last || $bonus@index % 3 == 2}>
        				</ul>
        			<{/if}>
        			<{/foreach}>
        		<{else}>
                <ul class="lucky_team1">
                    <li>恭喜<span class="winning_user">琴女</span>抢到<span class="prize_amount">88</span>元红包</li>
                    <li>恭喜<span class="winning_user">巨魔</span>抢到<span class="prize_amount">68</span>元红包</li>
                    <li>恭喜<span class="winning_user">日光</span>抢到<span class="prize_amount">66</span>元红包</li>              
                </ul>
                <ul class="lucky_team2">
                    <li>恭喜<span class="winning_user">流浪</span>抢到<span class="prize_amount">98</span>元红包</li>
                    <li>恭喜<span class="winning_user">赏金</span>抢到<span class="prize_amount">58</span>元红包</li>
                    <li>恭喜<span class="winning_user">安妮</span>抢到<span class="prize_amount">48</span>元红包</li>             
                </ul>
                <ul class="lucky_team3">
                    <li>恭喜<span class="winning_user">雪人骑士</span>抢到<span class="prize_amount">68</span>元红包</li>
                    <li>恭喜<span class="winning_user">嗜血猎手</span>抢到<span class="prize_amount">33</span>元红包</li>
                    <li>恭喜<span class="winning_user">蛮王</span>抢到<span class="prize_amount">21</span>元红包</li>             
                </ul>
                <{/if}>
            </div>
        </div>    
    </div>
	<div class="game_rule">
    	<img src="<{'plugins/img/m/monkey/game_rule.png'|url}>" />
    </div>
    <div class="end"></div>
    <div class="prompt">
        <div class="arrow"><img src="<{'plugins/img/m/monkey/arrow.png'|url}>" /></div>
        <div class="hand"><img src="<{'plugins/img/m/monkey/hand.png'|url}>" /></div>
        <div class="countdown countdown1"><img src="<{'plugins/img/m/monkey/countdown1.png'|url}>" /></div>
        <div class="countdown countdown2"><img src="<{'plugins/img/m/monkey/countdown2.png'|url}>" /></div>
        <div class="countdown countdown3"><img src="<{'plugins/img/m/monkey/countdown3.png'|url}>" /></div>        
    </div>
	<div class="main">
    	<div class="button_stop"></div>
        <div class="chumo"></div>
    	<form name="input">
            <div class="fenshu">当前分数：<input type="text" name="Score" value="0" size="5" readonly></div>  
            <div class="yonghu_Id"> <input type="text" name="user_Id" value="<{$_uid}>" size="5" readonly></div> 
            <div class="youxi_Num"> <input type="text" name="game_Num" value="<{$_times}>" size="5" readonly></div>     
            <h2 class="time">时间：<span></span></h2>
        </form> 
        <h1 class="jiafen"></h1>
        <a class="lao">捞</a>
        <div id="wave">
        	<input type="range" id="range" min="0" max="1" step="0.01" />
        </div>
        <div class="wave_bg"></div>
        <div class="zhuanpan">
            <div class="monkey">
                <div class="rope"></div>
                <div class="monkey_wu">
                    <span class="monkey_mid"></span>
                    <span class="wu_pic"><img src="<{'plugins/img/m/monkey/monkey_wu.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_hongbao">
                    <span class="houHb_pic"><img src="<{'plugins/img/m/monkey/hou_hongbao.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_star">
                    <span class="houXx_pic"><img src="<{'plugins/img/m/monkey/hou_star.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_yuanbao">
                    <span class="houYb_pic"><img src="<{'plugins/img/m/monkey/hou_yuanbao.png'|url}>"/></span>
                </div>               
                <div class="monkey_you monkey_fubao1">
                    <span class="houFb_pic"><img src="<{'plugins/img/m/monkey/hou_fubao1.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_fubao2">
                    <span class="houFb_pic"><img src="<{'plugins/img/m/monkey/hou_fubao2.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_fubao3">
                    <span class="houFb_pic"><img src="<{'plugins/img/m/monkey/hou_fubao3.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_fubao4">
                    <span class="houFb_pic"><img src="<{'plugins/img/m/monkey/hou_fubao4.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_halfmoon1">
                    <span class="houHm1_pic"><img src="<{'plugins/img/m/monkey/hou_halfmoon1.png'|url}>"/></span>
                </div>
                <div class="monkey_you monkey_halfmoon2"></div>
                <div class="monkey_you monkey_halfmoon3"></div>
                <div class="monkey_you monkey_fullmoon">
                    <span class="houFm_pic"></span>
                </div>
            </div>            
		</div>
        <div class="leaf"></div>
        <audio id="bg_music"  src="<{'plugins/img/m/monkey/backmusic.mp3'|url}>" controls="controls" loop="loop">
		</audio>
        <audio id="music1" src="<{'plugins/img/m/monkey/gain.wav'|url}>" controls="">		  
		</audio>
        <div class="fubao_say say"><img src="<{'plugins/img/m/monkey/fubao_say.png'|url}>"/></div>
        <div class="hongbao_say say"><img src="<{'plugins/img/m/monkey/hongbao_say.png'|url}>"/></div>
        <div class="yuanbao_say say"><img src="<{'plugins/img/m/monkey/yuanbao_say.png'|url}>"/></div>
        <div class="star_say say"><img src="<{'plugins/img/m/monkey/star_say.png'|url}>"/></div>
        <div class="moon_say say"><img src="<{'plugins/img/m/monkey/yue_say.png'|url}>"/></div>
        <div class="kong_say say"><img src="<{'plugins/img/m/monkey/kong_say.png'|url}>"/></div>       
        <span class="baby baby1" name="hongbao"><b>1</b></span>
        <span class="baby baby2" name="hongbao"><b>2</b></span>
        <span class="baby baby3" name="hongbao"><b>3</b></span>
        <span class="baby baby4" name="fubao1"><b>4</b><img src="<{'plugins/img/m/monkey/fubao1.png'|url}>"/></span>
        <span class="baby baby5" name="fubao2"><b>5</b><img src="<{'plugins/img/m/monkey/fubao2.png'|url}>"/></span>
        <span class="baby baby6" name="fubao3"><b>6</b><img src="<{'plugins/img/m/monkey/fubao3.png'|url}>"/></span>
        <span class="baby baby7" name="fubao4"><b>7</b><img src="<{'plugins/img/m/monkey/fubao4.png'|url}>"/></span>
        <span class="baby baby8" name="yuanbao"><b>8</b><img src="<{'plugins/img/m/monkey/yuanbao1.png'|url}>"/></span>
        <span class="baby baby9" name="yuanbao"><b>9</b><img src="<{'plugins/img/m/monkey/yuanbao1.png'|url}>"/></span>
        <span class="baby baby10" name="star"><b>10</b><img src="<{'plugins/img/m/monkey/star.png'|url}>"/></span>
        <span class="baby baby11" name="star"><b>11</b><img src="<{'plugins/img/m/monkey/star.png'|url}>"/></span>
        <span class="baby baby12" name="star"><b>12</b><img src="<{'plugins/img/m/monkey/star.png'|url}>"/></span>
        <span class="baby baby13" name="star"><b>13</b><img src="<{'plugins/img/m/monkey/star.png'|url}>"/></span>
        <span class="baby baby14" name="star"><b>14</b><img src="<{'plugins/img/m/monkey/star.png'|url}>"/></span>
        <span class="baby baby15" name="star"><b>15</b><img src="<{'plugins/img/m/monkey/star.png'|url}>"/></span>
        <span class="full_moon" name="fullM"></span>
        <span class="half half_moon1" name="halfM1"></span>
        <span class="half half_moon2" name="halfM2"></span>
        <span class="half half_moon3" name="halfM3"></span>
    </div>
    <!-- 游戏结束，弹出页面 -->    
    <div class="game_over">
    	<div class="prize1">100</div>
        <div class="prize2">100</div>
        <div class="hb_bt"><a href="<{'m/special?type_id=3'|url}>"><img src="<{'plugins/img/m/monkey/hb_bt.png'|url}>" /></a></div>
        <div class="restart_bt"><a class="rs_start" href="<{'m/game'|url}>"><img src="<{'plugins/img/m/monkey/restart_bt.png'|url}>" /></a></div>
        <div class="hb_num"><{$_bonus_cnt}></div>
        <div class="share_tip"></div>            
    </div>
    
    <div class="tip"></div>
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
	//分享朋友圈
	wxTimeLineData = {
		imgUrl:'<{$_data.imgUrl|url}>',
		link:'<{$_share_url nofilter}>',
		title:'<{$_data.title|escape}>',
		success: function () { 
			// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	};
	
	//分享朋友
	wxMenuShareData = {
		title:'<{$_data.title|escape}>',
		imgUrl:'<{$_data.imgUrl|url}>',
		link:'<{$_share_url nofilter}>',
		desc:'<{$_data.desc}>',
		type:'link',
		dataUrl: '',
		success: function () { 
			// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	};
	
	
	wx.ready(function(){
		wx.onMenuShareTimeline(wxTimeLineData);
		wx.onMenuShareAppMessage(wxMenuShareData);
		wx.hideMenuItems({
			menuList: ['menuItem:share:qq','menuItem:share:weiboApp'] // 要隐藏的菜单项，所有menu项见附录3
            
		});
        

	});
<{/block}>