// JavaScript Document
(function($){
	$(document).ready(function() {
		var houOffset;
		var ropeOffset;
		var xgd=$(".monkey").offset();
		var pingWidth=$(window).width();
		var pWidth_half=pingWidth/2;
		var pingHeight=$(window).height();
		var now_fenshu=0;
		var youxi_Num;
		//悬挂点距离屏幕底部高度
		var xgdTobottom=Math.abs(xgd.top)+pingHeight;
		//屏幕右下角与悬挂点的角度
		var pZuoXqie=Math.atan(pWidth_half/xgdTobottom);
		var pZuoXjiao=pZuoXqie*180/Math.PI;
		//设置绳子摇摆函数		
		var odd=0   ;             //设置摇摆奇偶变量
		var $zhuanpan=$(".zhuanpan");
		var rotation1 = function (){
		   $zhuanpan.rotate({
			  angle:-30, 
			  animateTo:30, 
			  duration: 1000,
			  callback: function(){
				  rotation2();
				  odd+=1;
			  },
			  easing: $.easing.easeInOutQuad
		   });
		}
		rotation1();
		var rotation2 = function (){
		   $zhuanpan.rotate({
			  animateTo:-30, 
			  duration: 1000,
			  callback: function(){
				  rotation1();
				  odd+=1;
			  },
			  easing: $.easing.easeInOutQuad
		   });
		}
		rotation2();
		var ratate_stop = function (){
			$zhuanpan.stopRotate();
		}
		
		var rotation3 = function (){
			if (odd%2==0)
		    {
				$zhuanpan.rotate({
					animateTo:30, 
					callback: function(){
						rotation2();
						odd+=1;
					},
					easing: $.easing.easeOutQuad
				});
			}
			else
			{
				$zhuanpan.rotate({
					animateTo:-30, 
					callback: function(){
						rotation1();
						odd+=1;
					},
					easing: $.easing.easeOutQuad
				});	
			}		   	
		}		
		//悬挂点的宽度 
		var xgdWidth = $(".monkey").width();
		//绳子原始长度
		var ropeL=$(".rope").css("height");
		//得到猴子的宽高 
		var monkeyWidth = $(".monkey_wu").width();
		var monkeyHeight = $(".monkey_wu").height();
		
		//宝贝位置排序
		var $bao = $('.baby');	
		var bao_attr=[];	
		Paixu();
		function Paixu() {			
			var baoH=0;		
			while(baoH<=8)
			{
				$bao.eq(baoH).css({"top":(89.05-Math.random()*15)+"%","left":(Math.random()*89.72)+"%"});
				baoH+=1;	
			}
			$bao.eq(3).css({"left":"3.89%"});
			$bao.eq(4).css({"left":"33.33%"});
			$bao.eq(5).css({"left":"57.92%"});
			$bao.eq(6).css({"left":"82.64%"});
			$(".full_moon").css({"left":(Math.random()*89.72)+"%"});							
			//得到宝贝的宽高
			var babyWH = [];
			for(var i = 0; i<$bao.length;++i)
			{
				babyWH.push({width: $bao.eq(i).width(),height: $bao.eq(i).height()});
			}			
			//给宝贝创建函数
			function Baby_attr (babyOffset_left,babyOffset_top,babyW,babyH) {
				this.baoOffset_left=babyOffset_left;
				this.baoOffset_top=babyOffset_top;
				this.baoW=babyW;
				this.baoH=babyH;		
			}
			Baby_attr.prototype.bToXgd = function() {
				var babyW_half=this.baoW/2
				var babyH_half=this.baoH/2
				var bToXgd_X=Math.abs(this.baoOffset_left+babyW_half-pingWidth/2)
				var bToXgd_Y=Math.abs(this.baoOffset_top+babyH_half-xgd.top)
				return Math.sqrt(bToXgd_X * bToXgd_X + bToXgd_Y * bToXgd_Y)-monkeyHeight;
			};
			Baby_attr.prototype.bJiao_left = function() {
				var babyH_half=this.baoH/2
				var babyX_left=this.baoOffset_left-pingWidth/2
				var bToXgd_Y=Math.abs(this.baoOffset_top+babyH_half-xgd.top)
				var zhengqie_left=Math.atan(babyX_left/bToXgd_Y)			
				return zhengqie_left*180/Math.PI;
			};
			Baby_attr.prototype.bJiao_right = function() {
				var babyH_half=this.baoH/2
				var babyX_right=this.baoOffset_left+this.baoW-pingWidth/2
				var bToXgd_Y=Math.abs(this.baoOffset_top+babyH_half-xgd.top)
				var zhengqie_right=Math.atan(babyX_right/bToXgd_Y)			
				return zhengqie_right*180/Math.PI;
			};
			Baby_attr.prototype.bJiao_leftOut = function() {
				var babyH_half=this.baoH/2
				var monkeyW_half=monkeyWidth/2
				var babyX_leftOut=this.baoOffset_left-pingWidth/2-monkeyW_half
				var bToXgd_Y=Math.abs(this.baoOffset_top+babyH_half-xgd.top)
				var zhengqie_leftOut=Math.atan(babyX_leftOut/bToXgd_Y)			
				return zhengqie_leftOut*180/Math.PI;
			};
			Baby_attr.prototype.bJiao_rightOut = function() {
				var babyH_half=this.baoH/2
				var monkeyW_half=monkeyWidth/2
				var babyX_rightOut=this.baoOffset_left+this.baoW-pingWidth/2+monkeyW_half
				var bToXgd_Y=Math.abs(this.baoOffset_top+babyH_half-xgd.top)
				var zhengqie_rightOut=Math.atan(babyX_rightOut/bToXgd_Y)			
				return zhengqie_rightOut*180/Math.PI;
			};
			//给所有宝贝创建对象			
			for(var i = 0; i<$bao.length;++i)
			{						
				bao_attr[i]=new Baby_attr ($bao.eq(i).offset().left,$bao.eq(i).offset().top,$bao.eq(i).width(),$bao.eq(i).height());							
			}
		}
		//给猴子创建捞宝贝函数
		var $rope=$(".rope");
		var $monkey_wu=$(".monkey_wu");
		var $monkey_you=$(".monkey_you");
		var $button_stop=$(".button_stop");
		var $jiafen=$(".jiafen");
		var $fenshu_input=$(".fenshu input");
		var $say=$(".say");
		function Lao_attr (bao_num,bb_xh) {					
			$rope.animate({height:bao_num.bToXgd()+"px"},300);
			$button_stop.css("display","block");
			$rope.queue(function () {					
				$bao.eq(bb_xh).css("display","none");
				$monkey_wu.css("display","none");
				switch($bao.eq(bb_xh).attr("name")) {
					case "hongbao":
						$jiafen.text("加3分");	
						now_fenshu+=3;					
						$(".monkey_hongbao").css("display","block");
						break;
					case "star":
						$jiafen.text("加1分");	
						now_fenshu+=1;	
						$(".monkey_star").css("display","block");
						break;
					case "yuanbao":
						$jiafen.text("加5分");	
						now_fenshu+=5;	
						$(".monkey_yuanbao").css("display","block");
						break;
					case "fubao1":
						$jiafen.text("加7分");	
						now_fenshu+=7;
						$(".monkey_fubao1").css("display","block");
						break;
					case "fubao2":
						$jiafen.text("加7分");	
						now_fenshu+=7;
						$(".monkey_fubao2").css("display","block");
						break;
					case "fubao3":
						$jiafen.text("加7分");	
						now_fenshu+=7;
						$(".monkey_fubao3").css("display","block");
						break;
					case "fubao4":
						$jiafen.text("加7分");	
						now_fenshu+=7;
						$(".monkey_fubao4").css("display","block");
						break;					
					case "fullM":
						$jiafen.text("加45分");	
						now_fenshu+=45;
						$(".monkey_fullmoon").css("display","block");
						break;						
				}
				$fenshu_input.val(now_fenshu);		
				$(this).dequeue();
			});
			$rope.animate({height:ropeL},1000);
			$rope.queue(function () {
				rotation3();
				$jiafen.text("");
				$monkey_you.css("display","none");	
				$monkey_wu.css("display","block");
				$button_stop.css("display","none");
				$say.animate({opacity:"0"},500);					
				$(this).dequeue();
			});					
		}
		//计时
		var c=-1;
		var $rs_start=$(".rs_start");	
		var $hb_num=$('.hb_num')
		var t;
			function timedCount()
			{				
				
				if(c>0)
				{
					$(".time span").text(c);
					c=c-1;	
				}
				else if(c==-1)
				{
					c=c;	
				}
				else
				{									
					if($fenshu_input.val()!=0)
					{	
						$.post(save_score_url,
						{
							type_id:type_id,
							score:$fenshu_input.val(),
							uid:$(".yonghu_Id input").val(),
							ver_code:ver_code
						},function(data){
							if(data.result == 'success'){
								youxi_Num=parseInt(data.data.times)
								$hb_num.html(data.data.bonus_cnt);	
								if(parseInt(data.data.times)<1){
									$rs_start.attr("href","#");
								}							
							}else{
								alert(data.data.err_msg);
							}
						}
						);
					}
					$(".game_over").css("display","block");
					
					bg_music.pause();
					$(".prize1").text($fenshu_input.val());
					$(".prize2").text($fenshu_input.val());
					var youxi_Num=parseInt($(".youxi_Num input").val());
					if(youxi_Num>0)
					{
						$rs_start.attr("href","#");
					}
					else
					{
						$rs_start.attr("href","start");
					}									
					t=window.clearInterval(t);
				}
				
			}
		
		//滑动手势动画
		function timedJishu()
		{
			$(".prompt").css("display","block");
			$(".arrow,.hand,.countdown").addClass("active");
			setTimeout(function(){$(".prompt").css("display","none");},3000);	
		}		
	
		//判断玩家玩的次数
		var times=parseInt($(".youxi_Num input").val());
		var lianxu_t=1;
		function game_Star () {
			if(times<=0)
			{
				$(".game_start").css("display","block");
				$(".tip").toggleClass("active");
			} 
			function Delay(){
				c=30;	
			}
			if(lianxu_t==1  && times>0)
			{
				timedJishu();
				lianxu_t+=1;
				setTimeout(Delay,3000);
				$(".fenshu input").val(0);                                                //修改
				t = self.setInterval(timedCount,1000);
				$(".game_start").css("display","none");
			}
			else if(lianxu_t!=1  && youxi_Num>0)
			{
				$(".fenshu input").val(0);
				now_fenshu=0;													//修改
				Paixu();
				$(".baby,.full_moon").css("display","block");
				Delay();
				t = self.setInterval(timedCount,1000);	
			}	
		}
		
		//控制水波
		var SW = new SiriWave({
			  width: screen.width*1.35,
			  height: 60
			});
		SW.setSpeed(0.1);
		SW.start();
		
		var range = document.getElementById('range');
		setInterval(function(){
		  SW.setNoise(range.value);
		}, 0);
		
		$(".tip").click(function(){
			$(this).toggleClass("active");
		});
		//阻止屏幕默认滑动
		$('body').on('touchmove', function (event) {
			event.preventDefault();
		});			
		//点击开始玩游戏按钮
		$("#begin").click(function(){
			game_Star ();
		});
		//点击游戏规则
		$game_rule=$(".game_rule");
		$game_start=$(".game_start")
		$(".reward_bt").click(function(){
			$game_rule.css("display","block");
			$game_start.css("display","none");
		});
		$game_rule.click(function(){
			$game_rule.css("display","none");
			$game_start.css("display","block");
		});		
		
		//重新游戏
		$rs_start.click(function(e){
			if($rs_start.attr("href")!="#")					//修改
			{
				e.preventDefault();
				$(".game_over").css("display","none");
				game_Star ();
			}
			else
			{
				$(".tip").toggleClass("active");	
			}	
		});
		
		$("body>div.main .chumo").swipe({
		  swipe:function(event, direction, distance, duration, fingerCount){
			ratate_stop();
			//得到绳子当前角度
			ropeOffset = $(".monkey_mid").offset();
			var ropeX=ropeOffset.left-pingWidth/2;
			var ropeY=Math.abs(ropeOffset.top-xgd.top);
			var ropeqie=Math.atan(ropeX/ropeY);
			var rope_jiao=ropeqie*180/Math.PI;
			//得到猴子当前坐标			
			var houLeftX;
			var houRightX;
			var houY;
			//背景声音
			var  lao_music = document.getElementById("music1");  				 
			lao_music.play(); 			
			//此元素是否与猴子相交，并且取top在上面那个宝贝DOM，
			var tangent=null;			
			var bh=0;
			$bao.each(function(){
				var $this = $(this);
				var top = $this.offset().top;			
				if (rope_jiao>=bao_attr[bh].bJiao_leftOut() && rope_jiao<=bao_attr[bh].bJiao_rightOut() && $this.is(':visible'))
				{
					if(tangent==null)
					{tangent=$this;}
					else 
					{
						if(top < tangent.offset().top)
						{
							tangent=$this;	
						}
						else
						{
							tangent=tangent;	
						}	
					}
				}					
				bh+=1;				
			});			
			if (tangent) 
			//让猴子下来并拉住它
			{
				var n=tangent.index()-17;				
				Lao_attr (bao_attr[n],n);
			}
			else if(rope_jiao>=-pZuoXjiao && rope_jiao<=pZuoXjiao)
			{
				var ropeCos=Math.cos(rope_jiao*0.017453293);
				var ropeMaxL=xgdTobottom/ropeCos-monkeyHeight;
				$button_stop.css("display","block");	
				$rope.animate({height:Math.abs(ropeMaxL)+"px"},300);
				$rope.animate({height:ropeL},1000);
				$rope.queue(function () {
					rotation3();
					$button_stop.css("display","none");						
					$(this).dequeue();
				});	
			}
			else if(rope_jiao<=-pZuoXjiao || rope_jiao>=pZuoXjiao)
			{
				var ropeSin=Math.sin(rope_jiao*0.017453293);
				var ropeMaxL=Math.abs(pWidth_half/ropeSin)-monkeyWidth;
				console.log(ropeMaxL);
				$button_stop.css("display","block");	
				$rope.animate({height:ropeMaxL+"px"},300);
				$rope.animate({height:ropeL},1000);
				$rope.queue(function () {
					rotation3();
					$button_stop.css("display","none");						
					$(this).dequeue();
				});	
			}
		  }

		});
		
    });
})(jQuery);
