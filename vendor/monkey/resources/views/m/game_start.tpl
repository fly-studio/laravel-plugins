<{extends file="extends/main.block.tpl"}>

<{block "head-styles-plus"}>
    <link rel="stylesheet" href="<{'static/css/m/monkey.css'|url}>">
    <link rel="stylesheet" href="<{'static/css/m/common.css'|url}>">
<{/block}>
<{block "head-scripts-plus"}>
	<script>var $ = jQuery.noConflict();</script> 
    <script src="<{'static/js/monkey/jquery.touchSwipe.min.js'|url}>"></script>
    <script src="<{'static/js/monkey/jquery.easing.min.js'|url}>"></script>
    <script src="<{'static/js/monkey/jquery.rotate.min.js'|url}>"></script>   
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>var type_id = <{$_type_id}>;var save_score_url='<{"/m/game/save_score"|url}>';var wxTimeLineData,wxMenuShareData;</script>
    <script src="<{'static/js/monkey/youxi_V3.js'|url}>"></script>
<{/block}>
<{block "body-container"}>
	<div class="start"></div>
    <div class="end"></div>
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
                <div class="monkey_you monkey_fubao">
                    <span class="houFb_pic"><img src="<{'static/img/m/monkey/hou_fubao.png'|url}>"/></span>
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
        <audio id="bg_music" controls="controls" loop="loop">
		  <source src="<{'static/img/m/monkey/backmusic.mp3'|url}>" type="audio/mp3" />
		</audio>
        <audio id="music1" controls="">
		  <source src="<{'static/img/m/monkey/gain.wav'|url}>"" type="audio/wav" />
		</audio>
        <div class="sign"><img src="<{'static/img/m/monkey/sign.png'|url}>" /></div>
        <div class="arrow"><img src="<{'static/img/m/monkey/arrow.png'|url}>" /></div>
        <div class="hand"><img src="<{'static/img/m/monkey/hand.png'|url}>" /></div>
        <span class="baby baby1" name="hongbao"><b>1</b></span>
        <span class="baby baby2" name="hongbao"><b>2</b></span>
        <span class="baby baby3" name="hongbao"><b>3</b></span>
        <span class="baby baby4" name="hongbao"><b>4</b></span>
        <span class="baby baby5" name="fubao"><b>5</b></span>
        <span class="baby baby6" name="fubao"><b>6</b></span>
        <span class="baby baby7" name="star"><b>7</b></span>
        <span class="baby baby8" name="star"><b>8</b></span>
        <span class="baby baby9" name="fullM"><b>9</b></span>
        <span class="baby baby10" name="fullM"><b>10</b></span>
        
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
               <div class="support text-center text-muted">联合创美提供技术支持</div>
            </div>
         </div>
        </div>
    </div>
    <div class="tip"><p><span>请点击右上角</span><span>选择“发送给朋友”</span><span>然后点击“发送”</span></p></div>
<{/block}>
<{block "body-scripts-jquery"}>
	wx.config({
		debug:false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		appId:'<{$_wechat.appid|escape}>', // 必填，公众号的唯一标识
		timestamp:'<{$_wechat.timestamp|escape}>', // 必填，生成签名的时间戳
		nonceStr:'<{$_wechat.noncestr|escape}>', // 必填，生成签名的随机串
		signature:'<{$_wechat.signature|escape}>',// 必填，签名，见附录1
		jsApiList:['onMenuShareTimeline','onMenuShareAppMessage','hideMenuItems'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
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