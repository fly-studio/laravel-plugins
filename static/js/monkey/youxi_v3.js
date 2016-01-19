// JavaScript Document
function Laoyue () {
	$(document).ready(function() {
		var houOffset
		var ropeOffset
		var xgd=$(".monkey").offset();
		var pingWidth=$(window).width();
		var pWidth_half=pingWidth/2
		var pingHeight=$(window).height();
		var now_fenshu=0
		var youxi_Num
		//悬挂点距离屏幕底部高度
		var xgdTobottom=Math.abs(xgd.top)+pingHeight
		//屏幕右下角与悬挂点的角度
		var pZuoXqie=Math.atan(pWidth_half/xgdTobottom)
		var pZuoXjiao=pZuoXqie*180/Math.PI;

		
		console.log($(window).height());
		console.log(xgd.left);
		
		//设置绳子摇摆函数
		
		var odd=0                //设置摇摆奇偶变量
		var rotation1 = function (){
		   $(".zhuanpan").rotate({
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
		   $(".zhuanpan").rotate({
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
			$(".zhuanpan").stopRotate();
		}
		
		var rotation3 = function (){
			if (odd%2==0)
		    {
				$(".zhuanpan").rotate({
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
				$(".zhuanpan").rotate({
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
		var xgdWidth = parseInt($(".monkey").css("width").replace("px", ""));
		//绳子原始长度
		var ropeL=$(".rope").css("height");
		console.log(ropeL);
		//得到猴子的宽高 
		var monkeyWidth = parseInt($(".monkey_wu").css("width").replace("px", ""));
		var monkeyHeight = parseInt($(".monkey_wu").css("height").replace("px", ""));
		
		//宝贝位置排序
//		var bao1,bao2,bao3,bao4,bao5,bao6,bao7,bao8,bao9,bao10
		var baby1,baby2,baby3,baby4,baby5,baby6,baby7,baby8,baby9,baby10,baby11,baby12,baby13,baby14,baby15,fullMoon,halfMoon
		var bao_hao=new Array()
		
		Paixu();
		function Paixu() {
			
			var baoH=0
			bao_hao[0]=".baby1";
			bao_hao[1]=".baby2";
			bao_hao[2]=".baby3";
			bao_hao[3]=".baby4";
			bao_hao[4]=".baby5";
			bao_hao[5]=".baby6";
			bao_hao[6]=".baby7";
			bao_hao[7]=".baby8";
			bao_hao[8]=".baby9";
			bao_hao[9]=".baby10";
			bao_hao[10]=".baby11";
			bao_hao[11]=".baby12";
			bao_hao[12]=".baby13";
			bao_hao[13]=".baby14";
			bao_hao[14]=".baby15";
			while(baoH<=8)
			{
				$(bao_hao[baoH]).css({"top":(89.05-Math.random()*15)+"%","left":(Math.random()*89.72)+"%"});
				baoH+=1;	
			}
			$(bao_hao[3]).css({"left":"3.89%"});
			$(bao_hao[4]).css({"left":"33.33%"});
			$(bao_hao[5]).css({"left":"57.92%"});
			$(bao_hao[6]).css({"left":"82.64%"});
			$(".full_moon").css({"left":(Math.random()*89.72)+"%"});
			var bao_wei=new Array()
			bao_wei[0]=$(".baby1").offset().top;
			bao_wei[1]=$(".baby2").offset().top;
			bao_wei[2]=$(".baby3").offset().top;
			bao_wei[3]=$(".baby4").offset().top;
			bao_wei[4]=$(".baby5").offset().top;
			bao_wei[5]=$(".baby6").offset().top;
			bao_wei[6]=$(".baby7").offset().top;
			bao_wei[7]=$(".baby8").offset().top;
			bao_wei[8]=$(".baby9").offset().top;
			bao_wei[9]=$(".baby10").offset().top;
			bao_wei[10]=$(".baby11").offset().top;
			bao_wei[11]=$(".baby12").offset().top;
			bao_wei[12]=$(".baby13").offset().top;
			bao_wei[13]=$(".baby14").offset().top;
			bao_wei[14]=$(".baby15").offset().top;
			function sortNumber(a,b)
			{
				return a - b
			}
			bao_wei.sort(sortNumber);
			var bwN=1
			while(bwN<=15)
			{
				var baoN=0
				while(baoN<=14)
				{
					if(bao_wei[baoN]==$(".baby"+bwN).offset().top)	
					{
						bao_hao[baoN]=".baby"+bwN;
						break;
					}
					else
					{
						baoN+=1;	
					}
				}
				bwN+=1;
			}
			console.log(bao_hao);
			//得到所有宝贝坐标
			var baby_Offset = $(".baby").offset();
			var baby1_Offset = $(bao_hao[0]).offset();		
			var baby2_Offset = $(bao_hao[1]).offset();
			var baby3_Offset = $(bao_hao[2]).offset();
			var baby4_Offset = $(bao_hao[3]).offset();
			var baby5_Offset = $(bao_hao[4]).offset();
			var baby6_Offset = $(bao_hao[5]).offset();		
			var baby7_Offset = $(bao_hao[6]).offset();
			var baby8_Offset = $(bao_hao[7]).offset();
			var baby9_Offset = $(bao_hao[8]).offset();
			var baby10_Offset = $(bao_hao[9]).offset();
			var baby11_Offset = $(bao_hao[10]).offset();
			var baby12_Offset = $(bao_hao[11]).offset();
			var baby13_Offset = $(bao_hao[12]).offset();
			var baby14_Offset = $(bao_hao[13]).offset();
			var baby15_Offset = $(bao_hao[14]).offset();
			//得到月亮的坐标
			var halfMoon_Offset = $(".half").offset();
			var fullMoon_Offset = $(".full_moon").offset();
			
			//得到宝贝的宽高
			var babyWidth = parseInt($(".baby").css("width").replace("px", ""));
			var babyHeight = parseInt($(".baby").css("height").replace("px", ""));
			var baby1_W = parseInt($(bao_hao[0]).css("width").replace("px", ""));
			var baby1_H = parseInt($(bao_hao[0]).css("height").replace("px", ""));
			var baby2_W = parseInt($(bao_hao[1]).css("width").replace("px", ""));
			var baby2_H = parseInt($(bao_hao[1]).css("height").replace("px", ""));
			var baby3_W = parseInt($(bao_hao[2]).css("width").replace("px", ""));
			var baby3_H = parseInt($(bao_hao[2]).css("height").replace("px", ""));
			var baby4_W = parseInt($(bao_hao[3]).css("width").replace("px", ""));
			var baby4_H = parseInt($(bao_hao[3]).css("height").replace("px", ""));
			var baby5_W = parseInt($(bao_hao[4]).css("width").replace("px", ""));
			var baby5_H = parseInt($(bao_hao[4]).css("height").replace("px", ""));
			var baby6_W = parseInt($(bao_hao[5]).css("width").replace("px", ""));
			var baby6_H = parseInt($(bao_hao[5]).css("height").replace("px", ""));
			var baby7_W = parseInt($(bao_hao[6]).css("width").replace("px", ""));
			var baby7_H = parseInt($(bao_hao[6]).css("height").replace("px", ""));
			var baby8_W = parseInt($(bao_hao[7]).css("width").replace("px", ""));
			var baby8_H = parseInt($(bao_hao[7]).css("height").replace("px", ""));
			var baby9_W = parseInt($(bao_hao[8]).css("width").replace("px", ""));
			var baby9_H = parseInt($(bao_hao[8]).css("height").replace("px", ""));
			var baby10_W = parseInt($(bao_hao[9]).css("width").replace("px", ""));
			var baby10_H = parseInt($(bao_hao[9]).css("height").replace("px", ""));
			var baby11_W = parseInt($(bao_hao[10]).css("width").replace("px", ""));
			var baby11_H = parseInt($(bao_hao[10]).css("height").replace("px", ""));
			var baby12_W = parseInt($(bao_hao[11]).css("width").replace("px", ""));
			var baby12_H = parseInt($(bao_hao[11]).css("height").replace("px", ""));
			var baby13_W = parseInt($(bao_hao[12]).css("width").replace("px", ""));
			var baby13_H = parseInt($(bao_hao[12]).css("height").replace("px", ""));
			var baby14_W = parseInt($(bao_hao[13]).css("width").replace("px", ""));
			var baby14_H = parseInt($(bao_hao[13]).css("height").replace("px", ""));
			var baby15_W = parseInt($(bao_hao[14]).css("width").replace("px", ""));
			var baby15_H = parseInt($(bao_hao[14]).css("height").replace("px", ""));
			
			
			//得到月亮的宽高
			var half_moonW = parseInt($(".half").css("width").replace("px", ""));
			var half_moonH = parseInt($(".half").css("height").replace("px", ""));
			var full_moonW = parseInt($(".full_moon").css("width").replace("px", ""));
			var full_moonH = parseInt($(".full_moon").css("height").replace("px", ""));		
			
			console.log(baby1_Offset.left);   
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
			baby1 = new Baby_attr (baby1_Offset.left,baby1_Offset.top,baby1_W,baby1_H);
			baby2 = new Baby_attr (baby2_Offset.left,baby2_Offset.top,baby2_W,baby2_H);
			baby3 = new Baby_attr (baby3_Offset.left,baby3_Offset.top,baby3_W,baby3_H);
			baby4 = new Baby_attr (baby4_Offset.left,baby4_Offset.top,baby4_W,baby4_H);
			baby5 = new Baby_attr (baby5_Offset.left,baby5_Offset.top,baby5_W,baby5_H);
			baby6 = new Baby_attr (baby6_Offset.left,baby6_Offset.top,baby6_W,baby6_H);
			baby7 = new Baby_attr (baby7_Offset.left,baby7_Offset.top,baby7_W,baby7_H);
			baby8 = new Baby_attr (baby8_Offset.left,baby8_Offset.top,baby8_W,baby8_H);
			baby9 = new Baby_attr (baby9_Offset.left,baby9_Offset.top,baby9_W,baby9_H);
			baby10 = new Baby_attr (baby10_Offset.left,baby10_Offset.top,baby10_W,baby10_H);
			baby11 = new Baby_attr (baby11_Offset.left,baby11_Offset.top,baby11_W,baby11_H);
			baby12 = new Baby_attr (baby12_Offset.left,baby12_Offset.top,baby12_W,baby12_H);
			baby13 = new Baby_attr (baby13_Offset.left,baby13_Offset.top,baby13_W,baby13_H);
			baby14 = new Baby_attr (baby14_Offset.left,baby14_Offset.top,baby14_W,baby14_H);
			baby15 = new Baby_attr (baby15_Offset.left,baby15_Offset.top,baby15_W,baby15_H);
			//给月亮创建对象
			halfMoon = new Baby_attr (halfMoon_Offset.left,halfMoon_Offset.top,half_moonW,half_moonH);
			fullMoon = new Baby_attr (fullMoon_Offset.left,fullMoon_Offset.top,full_moonW,full_moonH);
		}
		
		
		//得到所有宝贝距猴子悬挂点的距离
/*		var bToXgd_X=Math.abs(baby_Offset.left+babyW_half-pingWidth/2);
		var bToXgd_Y=Math.abs(baby_Offset.top+babyH_half-xgd.top);
		var bToXgd=Math.sqrt(bToXgd_X * bToXgd_X + bToXgd_Y * bToXgd_Y);
		
		var bToXgd_X1=Math.abs(baby1_Offset.left+babyW_half-pingWidth/2);
		var bToXgd_Y1=Math.abs(baby1_Offset.top+babyH_half-xgd.top);
		var bToXgd1=Math.sqrt(bToXgd_X1 * bToXgd_X1 + bToXgd_Y1 * bToXgd_Y1);
		var baby1X_left=baby1_Offset.left-pingWidth/2;
		var baby1X_right=baby1_Offset.left+babyWidth-pingWidth/2;
		var zhengqie1_left=Math.atan(baby1X_left/bToXgd1);
		var zhengqie1_right=Math.atan(baby1X_right/bToXgd1);
		var b1Jiao_left=zhengqie1_left*180/Math.PI;
		var b1Jiao_right=zhengqie1_right*180/Math.PI;
		var b1Jiao_fanwei=b1Jiao_right-b1Jiao_left;       */
		
		//给猴子创建捞宝贝函数
		function Lao_attr (bao_num,baobei) {					
			$(".rope").animate({height:bao_num.bToXgd()+"px"},300);
			$(".button_stop").css("display","block");
			$(".rope").queue(function () {					
				$(baobei).css("display","none");
				$(".monkey_wu").css("display","none");
				if($(baobei).attr("name")=="hongbao")
				{
					$(".jiafen").text("加3分");	
					now_fenshu+=3;					
					$(".monkey_hongbao").css("display","block");
					$(".hongbao_say").css("opacity","1");
				}
				else if($(baobei).attr("name")=="star")
				{
					$(".jiafen").text("加1分");	
					now_fenshu+=1;	
					$(".monkey_star").css("display","block");
					$(".star_say").css("opacity","1");
				}
				else if($(baobei).attr("name")=="yuanbao")
				{
					$(".jiafen").text("加5分");	
					now_fenshu+=5;	
					$(".monkey_yuanbao").css("display","block");
					$(".yuanbao_say").css("opacity","1");
				}
				else if($(baobei).attr("name")=="fubao1")
				{
					$(".jiafen").text("加7分");	
					now_fenshu+=7;
					$(".monkey_fubao1").css("display","block");
					$(".fubao_say").css("opacity","1");
				}
				else if($(baobei).attr("name")=="fubao2")
				{
					$(".jiafen").text("加7分");	
					now_fenshu+=7;
					$(".monkey_fubao2").css("display","block");
					$(".fubao_say").css("opacity","1");
				}
				else if($(baobei).attr("name")=="fubao3")
				{
					$(".jiafen").text("加7分");	
					now_fenshu+=7;
					$(".monkey_fubao3").css("display","block");
					$(".fubao_say").css("opacity","1");
				}
				else if($(baobei).attr("name")=="fubao4")
				{
					$(".jiafen").text("加7分");	
					now_fenshu+=7;
					$(".monkey_fubao4").css("display","block");
					$(".fubao_say").css("opacity","1");
				}
				else if($(baobei).attr("name")=="halfM1")
				{
					$(".jiafen").text("加4分");	
					now_fenshu+=4;
					$(".monkey_halfmoon1").css("display","block");
					$(".half").css("display","none");
					$(".full_moon").css("display","none");
				}
				else if($(baobei).attr("name")=="halfM2")
				{
					$(".jiafen").text("加4分");	
					now_fenshu+=4;
					$(".monkey_halfmoon2").css("display","block");
					$(".half").css("display","none");
					$(".full_moon").css("display","none");
				}
				else if($(baobei).attr("name")=="halfM3")
				{
					$(".jiafen").text("加4分");	
					now_fenshu+=4;
					$(".monkey_halfmoon3").css("display","block");
					$(".half").css("display","none");
					$(".full_moon").css("display","none");
				}
				else if($(baobei).attr("name")=="fullM")
				{
					$(".jiafen").text("加45分");
					now_fenshu+=45;
					$(".monkey_fullmoon").css("display","block");
					$(".half").css("display","none");
					$(".full_moon").css("display","none");
					$(".moon_say").css("opacity","1");
				}
				$(".fenshu input").val(now_fenshu);		
				$(this).dequeue();
			});
			$(".rope").animate({height:ropeL},1000);
			$(".rope").queue(function () {
				rotation3();
				$(".jiafen").text("");
				$(".monkey_you").css("display","none");	
				$(".monkey_wu").css("display","block");
				$(".button_stop").css("display","none");
				$(".say").animate({opacity:"0"},500);					
				$(this).dequeue();
			});	
				
		}
		
		       
		//计时
		var c=-1
		var t
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
					if($(".fenshu input").val()!=0)
					{	
						$.post(save_score_url,
						{
							type_id:type_id,
							score:$(".fenshu input").val(),
							uid:$(".yonghu_Id input").val(),
							ver_code:ver_code
						},function(data){
							if(data.result == 'success'){
								youxi_Num=parseInt(data.data.times)
								console.log(youxi_Num);
								$('.hb_num').html(data.data.bonus_cnt);	
								if(parseInt(data.data.times)<1){
									$(".rs_start").attr("href","#");
								}							
							}else{
								alert(data.data.err_msg);
							}
						}
						);
					}
					$(".game_over").css("display","block");
					
					bg_music.pause();
					$(".prize1").text($(".fenshu input").val());
					$(".prize2").text($(".fenshu input").val());
					var youxi_Num=parseInt($(".youxi_Num input").val());
					console.log(youxi_Num);	
					if(youxi_Num>0)
					{
						$(".rs_start").attr("href","#");
					}
					else
					{
						$(".rs_start").attr("href","start");
					}									
					t=window.clearInterval(t);
				}
				
			}
		//幸运榜滚动动画		
		function lucky_slide() {
			setTimeout("$('.lucky_team1').animate({top:'-84px'},300)",2000);
			setTimeout("$('.lucky_team2').animate({top:'0px'},300)",2100);
			setTimeout("$('.lucky_team1').css({'top':'84px'})",2000);
			setTimeout("$('.lucky_team3').animate({top:'0px'},300)",4100);
			setTimeout("$('.lucky_team2').animate({top:'-84px'},300)",4000);
			setTimeout("$('.lucky_team2').css({'top':'84px'})",4000);
			setTimeout("$('.lucky_team3').animate({top:'-84px'},300)",6000);
			setTimeout("$('.lucky_team1').animate({top:'0px'},300)",6100);
			setTimeout("$('.lucky_team3').css({'top':'84px'})",6000);	
		}
//		var lucky_t=self.setInterval(lucky_slide,6500);
//		setTimeout("$('.lucky_team1').animate({top:'-84px'},300)",1000);
//		setTimeout("$('.lucky_team2').animate({top:'0px'},300)",1050);
		
		
		
		//滑动手势动画
		var total_t=3
		var sign_t
		function timedJishu()
		{
			
			if(total_t>0)
				{
					$(".prompt").css("display","block");
					Hand_slide ();
					if(total_t==3)
					{
						$(".countdown").css("display","none");
						$(".countdown3").css("display","block");
					}
					if(total_t==2)
					{
						$(".countdown").css("display","none");
						$(".countdown2").css("display","block");
					}
					if(total_t==1)
					{
						$(".countdown").css("display","none");
						$(".countdown1").css("display","block");
					}
					total_t=total_t-1;
					
				}
			else
			{
				total_t=window.clearInterval(sign_t);
				
				$(".prompt").css("display","none");
				
			}	
		}		
		function Hand_slide () {
			
//			$('.arrow').css('top','18.75%');
//			$(".arrow").css("display","block");
//			$('.hand').css('top','24.58%');
//			$(".hand").css("display","block");			
//			$(".arrow").animate({top:"48.85%"},980).animate({top:"18.75%"},10).animate({top:"48.85%"},980).animate({top:"18.75%"},10).animate({top:"48.85%"},980);
//			$(".hand").animate({top:"55%"},980).animate({top:"24.58%"},10).animate({top:"55%"},980).animate({top:"24.58%"},10).animate({top:"55%"},980);
			$(".arrow").animate({top:"48.85%"},950).animate({top:"18.75%"},10);
			$(".hand").animate({top:"55%"},950).animate({top:"24.58%"},10);
//			setTimeout("$('.arrow').css('display','none')",800);
//			setTimeout("$('.hand').css('display','none')",800); 
		}
		
		//判断玩家玩的次数
		var times=parseInt($(".youxi_Num input").val());
		var lianxu_t=1;
		function game_Star () {
			if(times<=0)
			{
				$(".game_start").css("display","block");
				$(".tip1").css("display","block");
				$(".welcome").css("display","none");
			} 
			function Delay(){
				c=30;	
			}
			if(lianxu_t==1  && times>0)
			{
				sign_t = self.setInterval(timedJishu,1000);
				lianxu_t+=1;
				setTimeout(Delay,4000);
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
		
		
		
		
//		$(".share_tip,.fenxiang").click(function(){
//			$(".tip").css("display","block");
//		});
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
		$(".reward_bt").click(function(){
			$(".game_rule").css("display","block");
			$(".game_start").css("display","none");
		});
		$(".game_rule").click(function(){
			$(".game_rule").css("display","none");
			$(".game_start").css("display","block");
		});		
		
		//重新游戏
		$(".rs_start").click(function(e){
			if($(".rs_start").attr("href")!="#")					//修改
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
			var houLeftX
			var houRightX
			var houY
			console.log(rope_jiao);
			
			var  lao_music = document.getElementById("music1");  				 
			//lao_music.play(); 
			
			if(rope_jiao>=baby10.bJiao_leftOut() && rope_jiao<=baby10.bJiao_rightOut() && $(bao_hao[9]).css("display")=="block")
			{
				Lao_attr (baby10,bao_hao[9]);	
			}
			else if(rope_jiao>=baby11.bJiao_leftOut() && rope_jiao<=baby11.bJiao_rightOut() && $(bao_hao[10]).css("display")=="block")
			{
				Lao_attr (baby11,bao_hao[10]);	
			}
			else if(rope_jiao>=baby12.bJiao_leftOut() && rope_jiao<=baby12.bJiao_rightOut() && $(bao_hao[11]).css("display")=="block")
			{
				Lao_attr (baby12,bao_hao[11]);	
			}
			else if(rope_jiao>=baby13.bJiao_leftOut() && rope_jiao<=baby13.bJiao_rightOut() && $(bao_hao[12]).css("display")=="block")
			{
				Lao_attr (baby13,bao_hao[12]);	
			}
			else if(rope_jiao>=baby14.bJiao_leftOut() && rope_jiao<=baby14.bJiao_rightOut() && $(bao_hao[13]).css("display")=="block")
			{
				Lao_attr (baby14,bao_hao[13]);	
			}
			else if(rope_jiao>=baby15.bJiao_leftOut() && rope_jiao<=baby15.bJiao_rightOut() && $(bao_hao[14]).css("display")=="block")
			{
				Lao_attr (baby15,bao_hao[14]);	
			}
			else if(rope_jiao>=baby1.bJiao_leftOut() && rope_jiao<=baby1.bJiao_rightOut() && $(bao_hao[0]).css("display")=="block")
			{
				Lao_attr (baby1,bao_hao[0]);							
			}
			else if(rope_jiao>=baby2.bJiao_leftOut() && rope_jiao<=baby2.bJiao_rightOut() && $(bao_hao[1]).css("display")=="block")
			{
				Lao_attr (baby2,bao_hao[1]);	
			}
			else if(rope_jiao>=baby3.bJiao_leftOut() && rope_jiao<=baby3.bJiao_rightOut() && $(bao_hao[2]).css("display")=="block")
			{
				Lao_attr (baby3,bao_hao[2]);		
			}
			else if(rope_jiao>=baby4.bJiao_leftOut() && rope_jiao<=baby4.bJiao_rightOut() && $(bao_hao[3]).css("display")=="block")
			{
				Lao_attr (baby4,bao_hao[3]);	
			}
			else if(rope_jiao>=baby5.bJiao_leftOut() && rope_jiao<=baby5.bJiao_rightOut() && $(bao_hao[4]).css("display")=="block")
			{
				Lao_attr (baby5,bao_hao[4]);	
			}
			else if(rope_jiao>=baby6.bJiao_leftOut() && rope_jiao<=baby6.bJiao_rightOut() && $(bao_hao[5]).css("display")=="block")
			{
				Lao_attr (baby6,bao_hao[5]);	
			}
			else if(rope_jiao>=baby7.bJiao_leftOut() && rope_jiao<=baby7.bJiao_rightOut() && $(bao_hao[6]).css("display")=="block")
			{
				Lao_attr (baby7,bao_hao[6]);	
			}
			else if(rope_jiao>=baby8.bJiao_leftOut() && rope_jiao<=baby8.bJiao_rightOut() && $(bao_hao[7]).css("display")=="block")
			{
				Lao_attr (baby8,bao_hao[7]);	
			}
			else if(rope_jiao>=baby9.bJiao_leftOut() && rope_jiao<=baby9.bJiao_rightOut() && $(bao_hao[8]).css("display")=="block")
			{
				Lao_attr (baby9,bao_hao[8]);
			}
			
			
			else if(rope_jiao>=halfMoon.bJiao_leftOut() && rope_jiao<=halfMoon.bJiao_rightOut() && $(".half_moon1").css("display")=="block" && $(".half_moon1").css("opacity")=="1")
			{
				Lao_attr (halfMoon,".half_moon1");	
			}
			else if(rope_jiao>=halfMoon.bJiao_leftOut() && rope_jiao<=halfMoon.bJiao_rightOut() && $(".half_moon2").css("display")=="block" && $(".half_moon2").css("opacity")=="1")
			{
				Lao_attr (halfMoon,".half_moon2");	
			}
			else if(rope_jiao>=halfMoon.bJiao_leftOut() && rope_jiao<=halfMoon.bJiao_rightOut() && $(".half_moon3").css("display")=="block" && $(".half_moon3").css("opacity")=="1")
			{
				Lao_attr (halfMoon,".half_moon3");	
			}
			else if(rope_jiao>=fullMoon.bJiao_leftOut() && rope_jiao<=fullMoon.bJiao_rightOut() && $(".full_moon").css("display")=="block" && $(".full_moon").css("opacity")=="1")
			{
				Lao_attr (halfMoon,".full_moon");	
			}
			else if(rope_jiao>=-pZuoXjiao && rope_jiao<=pZuoXjiao)
			{
				var ropeCos=Math.cos(rope_jiao*0.017453293)
				console.log(rope_jiao);
				var ropeMaxL=xgdTobottom/ropeCos-monkeyHeight;
				console.log(ropeMaxL);
				$(".button_stop").css("display","block");	
				$(".rope").animate({height:Math.abs(ropeMaxL)+"px"},300);
				$(".rope").animate({height:ropeL},1000);
				$(".rope").queue(function () {
					rotation3();
					$(".button_stop").css("display","none");						
					$(this).dequeue();
				});	
			}
			else if(rope_jiao<=-pZuoXjiao || rope_jiao>=pZuoXjiao)
			{
				var ropeSin=Math.sin(rope_jiao*0.017453293)
				console.log(rope_jiao);
				var ropeMaxL=Math.abs(pWidth_half/ropeSin)-monkeyWidth;
				console.log(ropeMaxL);
				$(".button_stop").css("display","block");	
				$(".rope").animate({height:ropeMaxL+"px"},300);
				$(".rope").animate({height:ropeL},1000);
				$(".rope").queue(function () {
					rotation3();
					$(".button_stop").css("display","none");						
					$(this).dequeue();
				});	
			}
		  }
/*			var baby1X_left=baby1_Offset.left-pingWidth/2;
			var baby1X_right=baby1_Offset.left+babyWidth-pingWidth/2;
			var zhengqie1_left=Math.atan(baby1X_left/bToXgd1);
			var zhengqie1_right=Math.atan(baby1X_right/bToXgd1);
			var b1Jiao_left=zhengqie1_left*180/Math.PI;
			var b1Jiao_right=zhengqie1_right*180/Math.PI;   */
		});
		
    });
}
Laoyue();