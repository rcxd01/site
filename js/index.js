// JavaScript Document
$(function(){

/*********动态加载图片start*************/
$(".scrollLoading").scrollLoading();
/*********动态加载图片end**************/


/**********回到顶部start***************/
$("#to_top").css("opacity","0.6");
$("#to_top").hover(function(){
	$(this).stop().animate({"opacity":"1"},100);
	},function(){
		$(this).stop().animate({"opacity":"0.6"},100);
		});
$("#to_top").click(function(){
   $("body,html").stop().animate({"scrollTop":"0px"},400)	
});

/**********回到顶部end*****************/


/**********返回点击效果start************/
$("#back").hover(function(){
           $(this).css({"background-position":"0px -35px"});
	       },function(){
		   $(this).css({"background-position":"0px 0px"});
		   });
/**********返回点击效果end************/
		   
		   
/********导航栏start********/
$(".nav_ul li a").hover(function(){   //鼠标移到对应的li的a标签时，通过改变其绝对定位的值，来更改背景
      if($(this).attr("state")=="off"){
	     $(this).stop().animate({"top":"-40px"},300);
	  }
	},function(){
		  if($(this).attr("state")=="off"){
		    $(this).css("top","-30px").stop().animate({"top":"0px"},200);
		  }
		});
		
var nav_speed = parseInt($("#nav_speed").text());				
$(".nav_ul li,.logo").click(function(){
	var scrollTop = $(this).attr("scrollTop");
	$("html,body").stop().animate({"scrollTop":scrollTop+"px"},nav_speed);//通过修改此处的值来改变导航中#nav_01所滑动到的值
	});

$(".nav_ul li a").attr("state","off"); //默认所有导航未被点中
$(".nav_ul li a").click(function(){
	$(".text_list_less").click();
	/*$(".text_one li:gt(5),.text_two li:gt(5),.text_three li:gt(5)").slideUp(700,function(){
		$(".text_list_more").fadeIn(200);
		});*/
	$(this).parent().siblings().children("a[state=on]").css("top","-30px").stop().animate({"top":"0px"},200);
	$(".nav_ul li a").attr("state","off").css("top","0px");
	$(this).attr("state","on").css("top","-40px");
	});
/********导航栏end**********/
	


/*******幻灯片插件start*********/	
$('#coin_slider').coinslider({
    width: 840,
    height: 380,
    delay: 4000,
    effect: "",
    navigation: true,
    links: false 
 });
/********幻灯片插件end***********/




/**********模板效果图start*************/
//一次横向滚动一个
	$('#marquee').kxbdSuperMarquee({
		distance:240,
		time:3,
		btnGo:{left:'#goL',right:'#goR'},
		direction:'left'
	});
	
    $("#marquee ul li a img").hover(function(){
	   $(this).css("opacity","0.7");
	},function(){
	   $(this).css("opacity","1");
	});
/**********模板效果图end*************/




/*********案例展示start********/
$("#case_ul li").hover(function(){
	$(this).children(".case_a_img").append("<div class='imghover'></div>");
	$(".imghover").css("opacity","0.9");
	},function(){
		$(this).children(".case_a_img").children(".imghover").remove();
		});
		
var case_li_len = $("#case_ul li").length; //求出#case_ul里面共有多少个li
var case_page = Math.ceil(case_li_len/3); 
//求出共分多少页
var i;
for(i=0;i<case_page;i++){  //当有多少页，就添加多少个按钮
	$("#case_btn").append("<b>"+i+"</b>");
}


var index = 0;     //未点击前获得的index值
var new_index = 0; //新点击时获得的index值

$("#case_btn b").click(function(){
	var case_ul_left = parseInt($("#case_ul").css("left"))+50; //取得当前#case_ul的css属性中的left的值，并再加20
	var case_ul_right = parseInt($("#case_ul").css("left"))-50; //取得当前#case_ul的css属性中的left的值，并再减20
	var case_ul_width = 960;   //定义case_ul_width的值为960
	$(this).addClass("cass_btn_b_hover").siblings().removeClass("cass_btn_b_hover");
	index = new_index;   //重新获得未点击的index的值
	new_index = $(this).index();  //重新获得刚刚点击的index的值
	case_ul_width = -case_ul_width * new_index;
	//alert("new_index的值为"+new_index+","+"index的值为"+index);
	if(new_index != index){           //判断新旧index的大小，看先往那一边移动
		if(new_index<index ){
	 	   $("#case_ul").stop().animate({"left":case_ul_right+"px"},200,function(){
		   $("#case_ul").animate({"left":case_ul_width+"px"},400);
	    	});
	    }else{
		   $("#case_ul").stop().animate({"left":case_ul_left+"px"},200,function(){
		   $("#case_ul").animate({"left":case_ul_width+"px"},400);
		   });
		}
	}
});
$("#case_btn b:first").click();
/*********案例展示end**********/
	
	
	
	
	
/***************************************百度地图start***********************************************/
    //创建和初始化地图函数：
    function initMap(){
        createMap();//创建地图
        setMapEvent();//设置地图事件
        addMapControl();//向地图添加控件
        addMarker();//向地图中添加marker
    }
    
    //创建地图函数：
    function createMap(){
        var map = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
        var point = new BMap.Point(113.392958,22.515477);//定义一个中心点坐标
        map.centerAndZoom(point,18);//设定地图的中心点和坐标并将地图显示在地图容器中
        window.map = map;//将map变量存储在全局
    }
    
    //地图事件设置函数：
    function setMapEvent(){
        map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
        map.enableScrollWheelZoom();//启用地图滚轮放大缩小
        map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
        map.enableKeyboard();//启用键盘上下左右键移动地图
    }
    
    //地图控件添加函数：
    function addMapControl(){
        //向地图中添加缩放控件
	var ctrl_nav = new BMap.NavigationControl({anchor:BMAP_ANCHOR_TOP_LEFT,type:BMAP_NAVIGATION_CONTROL_SMALL});
	map.addControl(ctrl_nav);
                //向地图中添加比例尺控件
	var ctrl_sca = new BMap.ScaleControl({anchor:BMAP_ANCHOR_BOTTOM_LEFT});
	map.addControl(ctrl_sca);
    }
    
    //标注点数组
    var markerArr = [{title:"地球村网络有限公司",content:"中山市东区银通街19号中海商务A308",point:"113.392401|22.515402",isOpen:0,icon:{w:21,h:21,l:0,t:0,x:6,lb:5}}
		 ];
    //创建marker
    function addMarker(){
        for(var i=0;i<markerArr.length;i++){
            var json = markerArr[i];
            var p0 = json.point.split("|")[0];
            var p1 = json.point.split("|")[1];
            var point = new BMap.Point(p0,p1);
			var iconImg = createIcon(json.icon);
            var marker = new BMap.Marker(point,{icon:iconImg});
			var iw = createInfoWindow(i);
			var label = new BMap.Label(json.title,{"offset":new BMap.Size(json.icon.lb-json.icon.x+10,-20)});
			marker.setLabel(label);
            map.addOverlay(marker);
            label.setStyle({
                        borderColor:"#808080",
                        color:"#333",
                        cursor:"pointer"
            });
			
			(function(){
				var index = i;
				var _iw = createInfoWindow(i);
				var _marker = marker;
				_marker.addEventListener("click",function(){
				    this.openInfoWindow(_iw);
			    });
			    _iw.addEventListener("open",function(){
				    _marker.getLabel().hide();
			    })
			    _iw.addEventListener("close",function(){
				    _marker.getLabel().show();
			    })
				label.addEventListener("click",function(){
				    _marker.openInfoWindow(_iw);
			    })
				if(!!json.isOpen){
					label.hide();
					_marker.openInfoWindow(_iw);
				}
			})()
        }
    }
    //创建InfoWindow
    function createInfoWindow(i){
        var json = markerArr[i];
        var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>"+json.content+"</div>");
        return iw;
    }
    //创建一个Icon
    function createIcon(json){
        var icon = new BMap.Icon("http://map.baidu.com/image/us_cursor.gif", new BMap.Size(json.w,json.h),{imageOffset: new BMap.Size(-json.l,-json.t),infoWindowOffset:new BMap.Size(json.lb+5,1),offset:new BMap.Size(json.x,json.h)})
        return icon;
    }
    
    initMap();//创建和初始化地图
/*******************************************百度地图end***************************************/	





/****************************************ajax-start****************************************/
$("a[class=ajax]").click(function(){
   return false;
});


$(".ajax").click(function(){
	var filediv = $(this).attr("href");
	if(filediv){
	  var window_scrollTop = (parseInt($(window).scrollTop())+20)+"px";//定义当前窗口距离顶部的距离，再加50
	  var body_width = $("body").width();               //定义窗口的宽度
	   //求出内容框距离左边的宽度
	  var window_half_width = (parseInt(body_width)-700)/2;  
	  if(window_half_width<0){        //如果window_half_width的值少于0 则等于0
		  window_half_width = 0+"px";
		  }else{
			  window_half_width = window_half_width+"px";
		  	  }
      var body_height = (parseInt($("body").height())+40)+"px";    //求出页面总长度，在谷歌 IE8下少了40像素，另外加上40
	  if(body_width<980){
		  body_width=980+"px";
		  }
      var div = "<div id='black_window'></div><div id='window_text'><div id='close_title'></div><div id='close'></div><div id='ajax_content'></div></div>";  //增加的DIV，包括全屏黑的div和内容框
      $("body").append(div);          //增加DIV
	  $("#window_text").css({"top":window_scrollTop,"left":window_half_width}).fadeIn();      //显示内容框
	  $("#black_window").css({"width":body_width,"height":body_height,"opacity":"0.8"});      //显示黑div

	  	var  ajax_random = Math.random();
	  	 //$("#ajax_content").load("text.html?"+ajax_random+" #"+filediv); //调用AJAX读取相应DIV的内容

	  	 $("#ajax_content").load(filediv+" #ajax_href_content"); //调用AJAX读取相应DIV的内容

	  //alert(ajax_random);
	  
	  $("#close,#back").hover(function(){
           $(this).css({"background-position":"0px -35px"});
	       },function(){
		   $(this).css({"background-position":"0px 0px"});
		   });
	}	
});

$("#close").live('click',function(){                      //为新增的关闭元素绑定点击事件
	$("#window_text,#black_window").fadeOut(500,function(){         //当点击时，把黑div和内容框的元素删除
		$("#window_text,#black_window").remove();
		})
	});

$(window).bind("scroll resize",function(){            //当浏览器放大，缩小时，黑的div的大小也对应改变
	var body_width = $("body").width();
    var body_height = (parseInt($("body").height())+40)+"px";
	if(body_width<980){
		body_width=980+"px";
		}
	$("#black_window").css({"width":body_width,"height":body_height,"opacity":"0.8"})	
	})
	
$(window).resize(function(){          //当浏览器放大时，改变内容框的相对位置
	var window_scrollTop = (parseInt($(window).scrollTop())+20)+"px";
	var body_width = $("body").width();
	var window_half_width = (parseInt(body_width)-700)/2;
	if(window_half_width<0){
		window_half_width = 0+"px";
		}else{
			window_half_width = window_half_width+"px";
			}
    var body_height = (parseInt($("body").height())+40)+"px";
	$("#window_text").css({"top":window_scrollTop,"left":window_half_width})
});

/****************************************ajax-end*****************************************/


/**********************************最顶部文章展开，收缩start***************************/
$(".text_one li:lt(5),.text_two li:lt(5),.text_three li:lt(5)").show();
$(".text_list_more").show();
$(".text_list_more").click(function(){
	$(this).parent().children("li").slideDown(700);
	$(this).hide();
	});
	
$(".text_list_less").click(function(){
	$(this).parent().children("li:gt(5)").slideUp(700,function(){
		$(this).parent().children(".text_list_more").fadeIn(200);
		});
	});
/**********************************最顶部文章展开，收缩end*****************************/
	
	
	
	
	
});
