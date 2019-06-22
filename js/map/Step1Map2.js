//Step1Map 0.4
function Step1Map()
{
	function K_Function(){}
	//读取网址后缀的函数
	K_Function.GetQueryString=function(key)
	{
		var url=document.URL;
		var index=url.indexOf("?");
		if(index<=0){index=url.indexOf("#");}
		if(index>0)
		{
			var params=url.substr(index+1).split("&");
			for(var i=0;i<params.length;i++)
			{
				var index=params[i].indexOf("=");
				if(index>0)
				{
					var name=params[i].substr(0,index);
					var value=params[i].substr(index+1);
					if(name==key)
					{
						return decodeURIComponent(value);
					}
				}
			}
		}
		return "";
	}
	K_Function.GetCallBack=function(obj,func)
	{
		return function(){return func.apply(obj,arguments)};
	}
	K_Function.InheritClass=function(a,b)
	{
		var c=function(){};
		c.prototype=b.prototype;
		a.prototype=new c();
	};
	//Cookie操作函数
	K_Function.GetCookieVal=function(offset)
	{
		var endstr = document.cookie.indexOf (";", offset);
		if (endstr == -1)
			endstr = document.cookie.length;
		return unescape(document.cookie.substring(offset, endstr));
	}
	K_Function.SetCookie=function(name, value)
	{
		var expdate = new Date();
		var argv = K_Function.SetCookie.arguments;
		var argc = K_Function.SetCookie.arguments.length;
		var expires = (argc > 2) ? argv[2] : null;
		var path = (argc > 3) ? argv[3] : null;
		var domain = (argc > 4) ? argv[4] : null;
		var secure = (argc > 5) ? argv[5] : false;
		if(expires!=null) expdate.setTime(expdate.getTime() + ( expires * 1000 ));
		document.cookie = name + "=" + escape (value) +((expires == null) ? "" : ("; expires="+ expdate.toGMTString()))+((path == null) ? "" : ("; path=" + path)) +((domain == null) ? "" : ("; domain=" + domain))+((secure == true) ? "; secure" : "");
	}
	K_Function.DelCookie=function(name)
	{
		var exp = new Date();
		exp.setTime(exp.getTime() - 1);
		var cval =K_GetCookie(name);
		document.cookie = name + "=" + cval + "; expires="+ exp.toGMTString();
	}
	K_Function.GetCookie=function(name)
	{
		var arg = name + "=";
		var alen = arg.length;
		var clen = document.cookie.length;
		var i = 0;
		while (i < clen)
		{
			var j = i + alen;
			if (document.cookie.substring(i, j) == arg)
				return K_Function.GetCookieVal(j);
			i = document.cookie.indexOf(" ", i) + 1;
			if (i == 0) break;
		}
		return null;
	}
//显示地图中心十字的控件
	function K_CrossControl(image,size)
	{
		this.size=size?size:new GSize(20,20);
		this.image=image?image:"http://tool.yowao.com/img/cross.gif";
		this.div=document.createElement("div");
		this.img=document.createElement("img");
		this.div.appendChild(this.img);
		this.div.style.position="absolute";
		this.img.style.position="absolute";
	}
	K_CrossControl.prototype=new GControl(true,false);
	K_CrossControl.prototype.initialize=function(map)
	{
		if(this.img.src!=this.image)
		{
			this.img.src=this.image;
		}
		this.img.width=this.size.width;
		this.img.height=this.size.height;
		this.map=map;
		this.resetSize();
		map.getContainer().appendChild(this.div);
		GEvent.bind(map,"resize",this,this.resetSize());
		return this.div;
	}
	K_CrossControl.prototype.resetSize=function()
	{
		var size=this.map.getSize();
		this.img.style.left=(size.width/2-this.size.width/2)+"px";
		this.img.style.top=(size.height/2-this.size.height/2)+"px";
	}
	K_CrossControl.prototype.getDefaultPosition=function()
	{
		return new GControlPosition(G_ANCHOR_TOP_LEFT,new GSize(0,0));
	}

//在地图上显示HTML内容的控件
	function K_HtmlControl(html)
	{
		this.html=html;
	}
	K_HtmlControl.prototype=new GControl(true,false);
	K_HtmlControl.prototype.initialize=function(a)
	{
		this.Map=a;
		this.div=document.createElement("div");
		this.div.style.cursor="default";
		this.div.style.position="absolute";
		this.div.unselectable="on";
		this.div.onselectstart=function(){return false};
		this.div.style.fontSize="11px";
		this.div.style.fontFamily="Arial, sans serif";
		this.div.style.MozUserSelect="none"
		this.div.innerHTML=this.html;
		a.getContainer().appendChild(this.div);
		GEvent.bindDom(this.div,"click",this,this.onClick);
		return this.div;
	};
	K_HtmlControl.prototype.getDefaultPosition=function()
	{
		return new GControlPosition(G_ANCHOR_BOTTOM_RIGHT,new GSize(10,10))
	};
	K_HtmlControl.prototype.onClick=function()
	{
		GEvent.trigger(this,"click");
	}
//显示经纬度网格线的标注类型
	function K_LatlngGrid()
	{
		this.overlays=[];
	}
	K_LatlngGrid.prototype= new GControl(true,true);
	K_LatlngGrid.prototype.initialize=function(map)
	{
		this.map=map;
		this.redraw();
		GEvent.bind(map,"move",this,this.redraw);
		return document.createElement("div");
	}
	K_LatlngGrid.prototype.remove=function()
	{
		var overlay;
		while(overlay=this.overlays.pop())
		{
			this.map.removeOverlay(overlay);
		}
	}
	K_LatlngGrid.prototype.redraw=function(a)
	{
		var bounds=map.getBounds();
		var span=bounds.toSpan();
		var scale=Math.log(Math.min(span.lng(),span.lat()))/Math.log(10);
		scale=(scale-Math.floor(scale)<0.5)?Math.pow(10,Math.floor(scale)):Math.pow(10,Math.floor(scale))*5;
		if(this.scale==scale && this.bounds.containsBounds(bounds)){return;}
		this.remove();
		this.scale=scale;
		var sw=new GLatLng(2*bounds.getSouthWest().lat()-bounds.getNorthEast().lat(),2*bounds.getSouthWest().lng()-bounds.getNorthEast().lng(),true);
		var ne=new GLatLng(2*bounds.getNorthEast().lat()-bounds.getSouthWest().lat(),2*bounds.getNorthEast().lng()-bounds.getSouthWest().lng(),true);
		this.bounds=new GLatLngBounds(sw,ne);
		for(var lng=Math.floor(sw.lng()/scale)*scale;lng<ne.lng();lng+=scale)
		{
			var polyline=new GPolyline([new GLatLng(sw.lat(),lng),new GLatLng(sw.lat()+(ne.lat()-sw.lat())/3,lng),new GLatLng(sw.lat()+(ne.lat()-sw.lat())*2/3,lng),new GLatLng(ne.lat(),lng)],"red",1,0.5);
			map.addOverlay(polyline);
			this.overlays.push(polyline);
		}
		for(var lat=Math.floor(sw.lat()/scale)*scale;lat<ne.lat();lat+=scale)
		{
			var polyline=new GPolyline([new GLatLng(lat,sw.lng()),new GLatLng(lat,sw.lng()+(ne.lng()-sw.lng())/3),new GLatLng(lat,sw.lng()+(ne.lng()-sw.lng())*2/3),new GLatLng(lat,ne.lng())],"red",1,0.5);
			map.addOverlay(polyline);
			this.overlays.push(polyline);
		}
		return;
	};
	K_LatlngGrid.prototype.getDefaultPosition=function()
	{
		return new GControlPosition(G_ANCHOR_BOTTOM_RIGHT,new GSize(10,10))
	};
//在地图上显示一个小图标的标注类型
	function K_IconOverlay(imageUrl,point,scale,bounds,color)
	{
		this.imageUrl=imageUrl;
		this.point=point;
		this.scale=scale?scale:1;
		this.bounds=bounds;
		this.color=color;
		this.icon=new Object();
		this.icon.iconSize=new GSize(this.scale*32,this.scale*32);
	}
	K_IconOverlay.prototype = new GOverlay();
	K_IconOverlay.prototype.initialize=function(a)
	{
		this.map=a;
		this.div=document.createElement("img");
		a.getPane(G_MAP_MARKER_PANE).appendChild(this.div);
		GEvent.bindDom(this.div,"load",this,this.setClip);
		this.div.style.display="none";
		this.div.src=this.imageUrl;
		this.div.style.position="absolute";
		if(document.all)
		{
			this.div.unselectable="on";
			this.div.onselectstart=function(){return false};
			this.div.galleryImg="no";
			this.div.style.filter="progid:DXImageTransform.Microsoft.Chroma(color='#"+this.color+"')";
		}
		else
		{
			this.div.style.MozUserSelect="none";
		}
		this.div.style.border="0";
		this.div.style.padding="0";
		this.div.style.margin="0";
		color=(this.color)?this.color:"FFFFFF";
		this.div.style.cursor=document.all?"hand":"pointer";
		this.div.oncontextmenu=function(){return false};
		GEvent.bindDom(this.div,"mousedown",this,this.onMouseDown);
	};
	K_IconOverlay.prototype.setClip=function()
	{
		this.div.style.display='';
		this.currentSize=new GSize(this.div.offsetWidth,this.div.offsetHeight);
		if(this.bounds)
		{
			this.div.style.clip="rect("+((this.currentSize.height-this.bounds.maxY)*this.scale)+"px "+(this.bounds.maxX*this.scale)+"px "+((this.currentSize.height-this.bounds.minY)*this.scale)+"px "+(this.bounds.minX*this.scale)+"px)";
			this.icon.iconSize=new GSize(this.scale*(this.bounds.maxX-this.bounds.minX),this.scale*(this.bounds.maxY-this.bounds.minY));
		}
		else
			this.icon.iconSize=new GSize(this.scale*this.currentSize.width,this.scale*this.currentSize.height);
		this.div.width=(this.currentSize.width*this.scale);
		this.div.height=(this.currentSize.height*this.scale);
		this.div.style.display='';
		this.redraw(true);
	}
	K_IconOverlay.prototype.remove=function()
	{
		this.div.parentNode.removeChild(this.div);
	};
	K_IconOverlay.prototype.setPoint=function(point)
	{
		this.point=point;
		this.redraw(true);
	};
	K_IconOverlay.prototype.getIcon=function()
	{
		return this.icon;
	};
	K_IconOverlay.prototype.copy=function()
	{
		return new K_IconOverlay(this.imageUrl,this.point,this.scale,this.bounds,this.color);
	};
	K_IconOverlay.prototype.redraw=function(a)
	{
		if(!a || !this.point)return;
		if(!this.currentSize)return;
		var c=this.map.fromLatLngToDivPixel(this.point);
		if(this.bounds)
		{
			this.div.style.left=(c.x-(this.bounds.maxX+this.bounds.minX)/2*this.scale)+"px";
			this.div.style.top=(c.y-(this.currentSize.height*2-this.bounds.maxY-this.bounds.minY)/2*this.scale)+"px";
		}
		else
		{
			this.div.style.left=(c.x-this.currentSize.width*this.scale/2)+"px";
			this.div.style.top=(c.y-this.currentSize.height*this.scale/2)+"px";
		}
	};
	K_IconOverlay.prototype.onMouseDown=function(a)
	{
		if(document.all)
		{
			window.event.cancelBubble=true;
			window.event.returnValue=false
		}
		else
		{
			a.cancelBubble=true;
			a.preventDefault();
			a.stopPropagation()
		}
		GEvent.trigger(this,"click",this);
	};
	K_IconOverlay.prototype.openInfoWindowHtml=function(html)
	{
		this.map.openInfoWindowHtml(this.point,html);
	}
//地图上显示一张地图图片的标注类型
	function K_ImageOverlay(imageUrl,bounds,rotation,opacity)
	{
		this.imageUrl=imageUrl;
		this.bounds=bounds;
		this.rotation=-rotation;
		this.opacity=opacity||0.45;
	}
	K_ImageOverlay.prototype = new GOverlay();
	K_ImageOverlay.prototype.initialize=function(a)
	{
		this.map=a;
		if(this.rotation>5 || this.rotation<-5)
		{
			this.drawElement=document.createElement("v:Image");
			this.drawElement.style.rotation=this.rotation;
		}
		else
			this.drawElement=document.createElement("img");
		this.drawElement.title=this.imageUrl;
		this.drawElement.style.position="absolute";
		this.drawElement.style.filter="progid:DXImageTransform.Microsoft.Alpha(opacity="+(this.opacity*100)+");";
		this.drawElement.src=this.imageUrl;
		if(document.all==1)
		{
			this.drawElement.unselectable="on";
			this.drawElement.onselectstart=function(){return false};
			this.drawElement.galleryImg="no"
		}
		else
		{
			this.drawElement.style.MozUserSelect="none"
		}
		this.drawElement.style.border="0";
		this.drawElement.style.padding="0";
		this.drawElement.style.margin="0";
		this.drawElement.oncontextmenu=function(){return false};
		a.getPane(G_MAP_MARKER_PANE).appendChild(this.drawElement);
	};
	K_ImageOverlay.prototype.redraw=function(a)
	{
		if(!a)return;
		var min=this.map.fromLatLngToDivPixel(this.bounds.getSouthWest());
		var max=this.map.fromLatLngToDivPixel(this.bounds.getNorthEast());
		this.drawElement.style.left=(min.x)+"px";
		this.drawElement.style.top=(max.y)+"px";
		this.drawElement.style.width=(max.x-min.x)+"px";
		this.drawElement.style.height=(min.y-max.y)+"px";
	};
	K_ImageOverlay.prototype.setOpacity=function(opacity)
	{
		this.opacity=opacity||0.45;
		this.drawElement.style.filter="progid:DXImageTransform.Microsoft.Alpha(opacity="+(this.opacity*100)+");";
	}
	K_ImageOverlay.prototype.copy=function()
	{
		return new K_ImageOverlay(this.imageUrl,this.bounds,this.rotation,this.opacity)
	};
	K_ImageOverlay.prototype.remove=function()
	{
		this.drawElement.parentNode.removeChild(this.drawElement);
	}
//地图上对地图图片进行坐标定位的标注类
	function K_ImageAdjustorOverlay(imageUrl)
	{
		this.imageUrl=imageUrl;
		this.image=new Image();
		this.image.style.position="absolute";
		GEvent.bindDom(this.image,"load",this,this.onImageLoad);
		this.image.src=this.imageUrl;
	}
	K_ImageAdjustorOverlay.prototype = new GOverlay();
	K_ImageAdjustorOverlay.prototype.initialize=function(a)
	{
		this.map=a;
		this.bounds=a.getBounds();
		var sw=this.bounds.getSouthWest(),ne=this.bounds.getNorthEast();
		this.bounds=new GLatLngBounds(new GLatLng(sw.lat()+(ne.lat()-sw.lat())/8,sw.lng()+(ne.lng()-sw.lng())/8),new GLatLng(sw.lat()+(ne.lat()-sw.lat())*7/8,sw.lng()+(ne.lng()-sw.lng())*7/8));
		a.getPane(G_MAP_MAP_PANE).appendChild(this.image);
		if(this.size){this.onImageLoad();};
	};
	K_ImageAdjustorOverlay.prototype.redraw=function(a)
	{
		if(!a)return;
		var min=this.map.fromLatLngToDivPixel(this.bounds.getSouthWest());
		var max=this.map.fromLatLngToDivPixel(this.bounds.getNorthEast());
		this.image.style.left=(min.x)+"px";
		this.image.style.top=(max.y)+"px";
		this.image.style.width=(max.x-min.x)+"px";
		this.image.style.height=(min.y-max.y)+"px";
	};
	K_ImageAdjustorOverlay.prototype.onImageLoad=function()
	{
		this.size=new GSize(this.image.offsetWidth,this.image.offsetHeight);
		if(!this.map){return;}
		var ltP=this.map.fromLatLngToDivPixel(new GLatLng(this.bounds.getNorthEast().lat(),this.bounds.getSouthWest().lng()));
		var rbL=this.map.fromDivPixelToLatLng(new GPoint(ltP.x+this.size.width,ltP.y+this.size.height));
		this.bounds=new GLatLngBounds(new GLatLng(rbL.lat(),this.bounds.getSouthWest().lng()),new GLatLng(this.bounds.getNorthEast().lat(),rbL.lng()));
		this.redraw(true);

		var iIcon=new GIcon(null,"images/inside.gif");
		iIcon.iconSize=new GSize(32,32);
		iIcon.iconAnchor=new GPoint(16,16);
		var oIcon=new GIcon(null,"images/outside.gif");
		oIcon.iconSize=new GSize(24,24);
		oIcon.iconAnchor=new GPoint(12,12);
		this.iMarkers=[];
		this.oMarkers=[];

		var marker=new GMarker(this.bounds.getNorthEast(),{"icon":iIcon,draggable:true});
		GEvent.bind(marker,"drag",this,function(){this.onIDrag(0)});
		this.map.addOverlay(marker);
		this.iMarkers.push(marker);

		var marker=new GMarker(this.bounds.getSouthWest(),{"icon":iIcon,draggable:true});
		GEvent.bind(marker,"drag",this,function(){this.onIDrag(1)});
		this.map.addOverlay(marker);
		this.iMarkers.push(marker);

		var marker=new GMarker(new GLatLng(this.bounds.getNorthEast().lat(),this.bounds.getSouthWest().lng()),{"icon":iIcon,draggable:true});
		GEvent.bind(marker,"drag",this,function(){this.onIDrag(2)});
		this.map.addOverlay(marker);
		this.iMarkers.push(marker);

		var marker=new GMarker(this.bounds.getNorthEast(),{"icon":oIcon,draggable:true});
		GEvent.bind(marker,"drag",this,function(){this.onODrag(0)});
		this.map.addOverlay(marker);
		this.oMarkers.push(marker);

		var marker=new GMarker(this.bounds.getSouthWest(),{"icon":oIcon,draggable:true});
		GEvent.bind(marker,"drag",this,function(){this.onODrag(1)});
		this.map.addOverlay(marker);
		this.oMarkers.push(marker);

		var marker=new GMarker(new GLatLng(this.bounds.getNorthEast().lat(),this.bounds.getSouthWest().lng()),{"icon":oIcon,draggable:true});
		GEvent.bind(marker,"drag",this,function(){this.onODrag(2)});
		this.map.addOverlay(marker);
		this.oMarkers.push(marker);

	}
	K_ImageAdjustorOverlay.prototype.onIDrag=function(k)
	{
		document.title=k;
	}
	K_ImageAdjustorOverlay.prototype.onODrag=function(k)
	{
		document.title=k;
	}
	K_ImageAdjustorOverlay.prototype.copy=function()
	{
		return new K_ImageAdjustorOverlay(this.imageUrl,this.bounds,this.rotation,this.opacity)
	};
	K_ImageAdjustorOverlay.prototype.remove=function()
	{
		this.drawElement.parentNode.removeChild(this.drawElement);
	}
//自定义的HTML marker标注类型，以指定点显示HTML内容
	function K_HtmlMarker(icon,point,html)
	{
		this.icon=icon;
		this.point=point;
		this.html=html;
	}
	K_HtmlMarker.prototype = new GOverlay();
	K_HtmlMarker.prototype.initialize=function(a)
	{
		this.map=a;
		a.addOverlay(this.icon);
		this.icon.setPoint(this.point);
		GEvent.bindDom(this.icon,"mousedown",this,this.onMouseDown);
		this.div=document.createElement("span");
		this.div.align="left";
		this.div.style.position="absolute";
		this.div.style.cursor="default";
		this.div.style.width="200px";
		this.div.innerHTML=this.html;
		a.getPane(G_MAP_MARKER_PANE).appendChild(this.div);
		GEvent.bind(this.icon,"click",this,this.onMouseDown);
	};
	K_HtmlMarker.prototype.remove=function(){this.icon.remove();if(this.div&&this.div.parentNode){this.div.parentNode.removeChild(this.div)}};
	K_HtmlMarker.prototype.copy=function()
	{
		return new K_HtmlMarker(this.icon.copy(),this.point,this.html)
	};
	K_HtmlMarker.prototype.redraw=function(a)
	{
		this.icon.redraw(a);
		if(!a)return;
		var c=this.map.fromLatLngToDivPixel(this.point);
		iconSize=this.icon.getIcon().iconSize?this.icon.getIcon().iconSize:new GSize(32,32);
		this.div.style.left=(c.x+iconSize.width/2)+"px";
		this.div.style.top=(c.y-this.div.offsetHeight/2)+"px";
	};
	K_HtmlMarker.prototype.onMouseDown=function(a)
	{
		if(document.all)
		{
			window.event.cancelBubble=true;
			window.event.returnValue=false
		}
		else
		{
			a.cancelBubble=true;
			a.preventDefault();
			a.stopPropagation()
		}
		GEvent.trigger(this,"click",this);
	};
	K_HtmlMarker.prototype.openInfoWindowHtml=function(html)
	{
		this.map.openInfoWindowHtml(this.point,html);
	}
//这是调用用户所在地点的对象
	function K_UserPosition()
	{
		this.loaded=false;
	}
	K_UserPosition.prototype.Load=function(handle)
	{
		this.handle=handle;
		this.LoadByWiFi();
	}
	K_UserPosition.prototype.LoadByWiFi=function()
	{
		var wifi=this.GetWiFiControl();
		if(wifi)
		{
			try
			{
				var results = wifi.GetLocation();
				if(results&&results.length>0)
					{eval(results);return;}
			}
			catch(ex){}
		}
		window.SetAutoLocateViewport=K_Function.GetCallBack(this,this.SetAutoLocateViewport);
		window.ShowMessage=K_Function.GetCallBack(this,this.ShowMessage);
		new K_JsLoader().load("http://virtualearth.msn.com/WiFiIPService/locate.ashx?pos=");
	}
	K_UserPosition.prototype.GetWiFiControl=function()
	{
		var wifi=null;
		try
		{
			wifi=new ActiveXObject("WiFiScanner");
		}
		catch(e)
		{
			try
			{
				wifi=new ActiveXObject("Microsoft.MapPoint.WiFiScanner.1");
			}
			catch(e)
			{
				try
				{
					wifi=new WiFiScanner("Microsoft.MapPoint.WiFiScanner.1");
				}
				catch(e)
				{}
			}
		}
		return wifi;
	}
	K_UserPosition.prototype.ShowMessage=function(message)
	{
	}
	K_UserPosition.prototype.SetAutoLocateViewport=function(lat,lon,zoom,pin,message)
	{
		if(this.loaded)
			return;
		this.point=new GLatLng(lat,lon);
		this.zoom=17-zoom;
		this.pin=pin;
		this.message=message;
		this.loaded=true;
		if(this.handle)
		{
			this.handle.apply(this);
			this.handle=null;
		}
	}
//让点沿轨迹移动的类
	function K_PointMover(points,time,rate,handle)
	{
		this.points=points;
		this.time=time?time:100;
		this.rate=rate?rate:1;
		this.handle=handle;
		this.pointsIndex=0;
		this.numberIndex=0;
	}
	K_PointMover.prototype.Move=function()
	{
		if(!this.timer)
		{
			this.timer=setInterval(K_Function.GetCallBack(this,this.Move),this.time);
			this.point=this.points[this.pointsIndex];
			if(this.handle)
			{
				this.handle.call(null,this);
			}
			return;
		}
		else
		{
			if(!this.offset)
			{
				offsetX=this.points[this.pointsIndex+1].lng()-this.points[this.pointsIndex].lng();
				a=Math.log((1+Math.sin(this.points[this.pointsIndex].lat()*Math.PI/180))/(1-Math.sin(this.points[this.pointsIndex].lat()*Math.PI/180)))*180/Math.PI/2;
				a1=Math.log((1+Math.sin(this.points[this.pointsIndex+1].lat()*Math.PI/180))/(1-Math.sin(this.points[this.pointsIndex+1].lat()*Math.PI/180)))*180/Math.PI/2;
				offsetY=a1-a;//this.points[this.pointsIndex+1].lat()-this.points[this.pointsIndex].lat();
				offset=Math.sqrt(Math.pow(offsetX,2)+Math.pow(offsetY,2));
				if(offset==0)
					this.offset=new GSize(0,0);
				else
					this.offset=new GSize(offsetX/offset,offsetY/offset);
			}
			var lng=this.points[this.pointsIndex].lng()+this.rate*this.offset.width*(this.numberIndex+1);
			var lat=Math.log((1+Math.sin(this.points[this.pointsIndex].lat()*Math.PI/180))/(1-Math.sin(this.points[this.pointsIndex].lat()*Math.PI/180)))*180/Math.PI/2+this.rate*this.offset.height*(this.numberIndex+1);
			lat=(Math.asin((Math.pow(Math.E,lat*Math.PI/180*2)-1)/(Math.pow(Math.E,lat*Math.PI/180*2)+1))*180/Math.PI);
			if((lng-this.points[this.pointsIndex].lng())*(lng-this.points[this.pointsIndex+1].lng())<0 || (lat-this.points[this.pointsIndex].lat())*(lat-this.points[this.pointsIndex+1].lat())<0)
			{
				this.point=new GLatLng(lat,lng);
				if(this.handle)
					this.handle.call(null,this);
				this.numberIndex++;
			}
			else
			{
				this.pointsIndex++;
				this.numberIndex=0;
				this.offset=null;
				this.point=this.points[this.pointsIndex];
				if(this.handle)
					this.handle.call(null,this);
				if(this.pointsIndex>=this.points.length-1)
				{
					clearInterval(this.timer);
					this.pointsIndex=0;
					this.numberIndex=0;
				}
			}
		}
	}
	K_PointMover.prototype.Pause=function()
	{
		if(this.timer)
		{
			clearInterval(this.timer);
			this.timer=null;
		}
	}
//简单的XML文件读取对象
	function K_XmlLoader(parseHandle)
	{
		this.parseHandle=parseHandle;
		this.xmlhttp =null;
	}
	K_XmlLoader.prototype.Load=function(url,postData)
	{
		this.url=url;
		this.xmlhttp =GXmlHttp.create();
		var method="GET";
		if(postData && postData.length>0)
			method="POST";
		this.xmlhttp.open(method,this.url,true);
		this.xmlhttp.onreadystatechange=K_Function.GetCallBack(this,this.ParseXmlFile);
		if(postData && postData.length>0)
		{
			this.xmlhttp.setRequestHeader ("Content-Type","text/xml; charset=utf-8"); 
			this.xmlhttp.setRequestHeader ("SOAPAction","\"\""); 
		}
		this.xmlhttp.send(postData);
	}
	K_XmlLoader.prototype.ParseXmlFile=function()
	{
		if(this.xmlhttp==null || this.xmlhttp.readyState!=4)
			return;
		this.xmlDoc = this.xmlhttp.responseXML;
		if(this.xmlDoc.documentElement==null && this.xmlhttp.responseText &&　this.xmlhttp.responseText!="")
		{
			try{this.xmlDoc=GXml.parse(this.xmlhttp.responseText);}
			catch(ce){}
		}
		if(this.xmlDoc.documentElement==null)
			this.responseText=this.xmlhttp.responseText;
		this.xmlhttp=null;
		if(this.parseHandle)
			this.parseHandle.call(null,this);
		GEvent.trigger(this,"loaded",this);
	}
//加载一个JS文件的对象
	function K_JsLoader(parseHandle)
	{
		this.parseHandle=parseHandle;
	}
	K_JsLoader.prototype.load=function(src)
	{
		if(!this.jsFile)
		{
			this.jsFile=document.createElement("script");
			this.jsFile.type="text/javascript";
			this.jsFile.defer=true;
			document.body.insertBefore(this.jsFile,document.body.firstChild);
			GEvent.bindDom(this.jsFile,"readystatechange",this,this.onReadyStateChange);
			GEvent.bindDom(this.jsFile,"load",this,this.onLoad);
		}
		this.jsFile.src=src;
		this.running=true;
	}
	K_JsLoader.prototype.onLoad=function(e)
	{
		if(window._OLR)
		{
			GEvent.trigger(this,"loaded",K_JsLoader.parseObject(window._OLR));
			if(this.parseHandle)
				this.parseHandle.call(null,window._OLR);
		}
		else
		{
			GEvent.trigger(this,"error");
		}
		window._OLR=null;
		if(!document.all && this.jsFile && this.jsFile.parentNode==document.body)
		{
			this.jsFile.removeAttribute("src");
			document.body.removeChild(this.jsFile);
			delete this.jsFile;
		}
		this.running=false;
	}
	K_JsLoader.parseObject=function(obj)
	{
		return obj;
	}
	K_JsLoader.prototype.onReadyStateChange=function(e)
	{
		if(!this.jsFile || this.jsFile.readyState!="loaded")
		{
			return;
		}
		this.onLoad();
	}
	K_JsLoader.getChild=function(arr,name)
	{
		for(var i=0;i<arr.c.length;i++)
		{
			if(arr.c[i].name==name)
			{
				return arr.c[i];
			}
		}
	}
//这是51ditu坐标系统对象
	function K_51dituProjection()
	{
		this.imgSize=200;
		this.imgNtuSize=256;
	}
	K_51dituProjection.prototype=new GProjection(); 
	K_51dituProjection.load=function(latlng)
	{
		K_51dituProjection.loading=true;
		K_51dituProjection._latlng=[latlng[0],latlng[1]];
		if(!K_51dituProjection.loader)
		{
			K_51dituProjection.loader=new K_JsLoader();
			GEvent.addListener(K_51dituProjection.loader,"loaded",K_51dituProjection.onLoad);
		}
		K_51dituProjection.loader.load("http://www.step1.cn/51ditu/services/NTL_.aspx?ps="+latlng[0]+","+latlng[1]+"");
	}
	K_51dituProjection.onLoad=function(points)
	{
		if(points.length==1)
		{
			K_51dituProjection.spLatlng=K_51dituProjection._latlng;
			K_51dituProjection._latlng=null;
			K_51dituProjection.spNtu=points[0];
			GEvent.trigger(K_51dituProjection,"change");
			K_51dituProjection.loading=false;
		}
	}
	K_51dituProjection.LatlngToNtu=function(latlng)
	{
		if(K_51dituProjection.spLatlng)
		{
			if(Math.pow(K_51dituProjection.spLatlng[0]-latlng[0],2)+Math.pow(K_51dituProjection.spLatlng[1]-latlng[1],2)>100000000 && !K_51dituProjection.loading)
			{
				K_51dituProjection.load(latlng);
			}
			return [latlng[0]-K_51dituProjection.spLatlng[0]+K_51dituProjection.spNtu[0],latlng[1]-K_51dituProjection.spLatlng[1]+K_51dituProjection.spNtu[1]];
		}
		else
		{
			if(!K_51dituProjection.loading)
			{
				K_51dituProjection.load(latlng);
			}
			return [latlng[0],latlng[1]];
		}
	}
	K_51dituProjection.NtuToLatlng=function(ntu)
	{
		if(K_51dituProjection.spLatlng)
		{
			if(Math.pow(K_51dituProjection.spLatlng[0]-ntu[0],2)+Math.pow(K_51dituProjection.spLatlng[1]-ntu[1],2)>100000000 && !K_51dituProjection.loading)
			{
				K_51dituProjection.load(ntu);
			}
			return [ntu[0]+K_51dituProjection.spLatlng[0]-K_51dituProjection.spNtu[0],ntu[1]+K_51dituProjection.spLatlng[1]-K_51dituProjection.spNtu[1]];
		}
		else
		{
			if(!K_51dituProjection.loading)
			{
				K_51dituProjection.load(ntu);
			}
			return [ntu[0],ntu[1]];
		}
	}
	K_51dituProjection.get51dituZoom=function(zoom)
	{
		return 17-zoom;
	}
	K_51dituProjection.prototype.fromLatLngToPixel=function(point,zoom)
	{
		var zoomUnits=Math.pow(2,K_51dituProjection.get51dituZoom(zoom))*this.imgNtuSize/this.imgSize;
		var ntu=K_51dituProjection.LatlngToNtu([point.lng()*100000,point.lat()*100000]);
		return new GPoint(ntu[0]/zoomUnits,-ntu[1]/zoomUnits)
	};
	K_51dituProjection.prototype.fromPixelToLatLng=function(point,zoom,flag)
	{
		var zoomUnits=Math.pow(2,K_51dituProjection.get51dituZoom(zoom))*this.imgNtuSize/this.imgSize;
		var latlng=K_51dituProjection.NtuToLatlng([point.x*zoomUnits,-point.y*zoomUnits]);
		return new GLatLng(latlng[1]/parseFloat(100000),latlng[0]/parseFloat(100000),flag)
	};
	K_51dituProjection.prototype.tileCheckRange=function(tile,zoom,tilesize)
	{
		return true;
	};

	K_51dituProjection.prototype.getWrapWidth=function(zoom)
	{
		return Math.pow(2,zoom+8);
	};

//这是调用51ditu图片的地图类型对象
	function K_51dituSpec()
	{
		GTileLayer.call(this,new GCopyrightCollection("51ditu.com"),3,17);
		this.imgURL=["http://cache2.51ditu.com/"];
	}
	K_Function.InheritClass(K_51dituSpec,GTileLayer); 
	K_51dituSpec.prototype.getTileUrl=function(point,zoom)
	{
		var z=K_51dituProjection.get51dituZoom(zoom);
		var nGrade=parseInt(Math.ceil((12-z)/4));
		var nPreRow=0,nPreCol=0,nPreSize=0;  
		var path="";
		for(var i=0;i<nGrade;i++)
		{
			var nSize=1<<(4*(nGrade-i));
			var nRow =parseInt((point.x-nPreRow*nPreSize)/nSize);
			var nCol =parseInt((-point.y-1-nPreCol*nPreSize)/nSize);
			path+=((nRow>9)?nRow:"0"+nRow)+""+((nCol>9)?nCol:"0"+nCol)+"/";
			nPreRow = nRow;
			nPreCol = nCol;
			nPreSize = nSize;
		}
		var id=(((point.x)&((1<<20)-1))+(((-point.y-1)&((1<<20)-1))*Math.pow(2,20))+(((z)&((1<<8)-1))*Math.pow(2,40)));
		return this.imgURL[(point.x+point.y)%this.imgURL.length]+z+"/"+path+id+".png";
	}
	K_51dituSpec.prototype.isPng=function(){return true;}
	window.K_51ditu_MAP=new GMapType([new K_51dituSpec()],new K_51dituProjection(),"51ditu",{tileSize:200,shortName:51});
	//显示地图的中心点地理信息的控件
	function K_CenterPlaceControl()
	{
		this.loader=new K_JsLoader();
		GEvent.bind(this.loader,"loaded",this,this.onRegoLoader);
		GEvent.bind(this.loader,"error",this,this.setRgeoText);
	}
	K_CenterPlaceControl.prototype=new GControl(true,false);
	K_CenterPlaceControl.prototype.initialize=function(a)
	{
		this.Map=a;
		this.div=document.createElement("div");
		this.div.style.position="absolute";
		this.div.style.fontSize="11px";
		this.div.style.color="#FFFFFF";
		
		a.getContainer().appendChild(this.div);
		this.setRgeoText();
		this.listener=GEvent.bind(map,"moveend",this,this.onMapMove);
		this.onMapMove();
		return this.div;
	};
	K_CenterPlaceControl.prototype.onMapMove=function()
	{
		if(this.timeout){window.clearTimeout(this.timeout);}
		this.timeout=window.setTimeout(K_Function.GetCallBack(this,this.loadRegoCode),2000);
	}
	K_CenterPlaceControl.prototype.loadRegoCode=function()
	{
		var point=map.getCenter();
		this.setRgeoText();
		var lng=point.lng(),lat=point.lat();
		lng=Math.round(lng*1000)/1000;
		lat=Math.round(lat*1000)/1000;
		this.loader.load("http://www.step1.cn/place/rgeo.aspx?ll="+point.lng()+","+point.lat(),"gb2312");
	}
	K_CenterPlaceControl.prototype.onRegoLoader=function(result)
	{
		try
		{
			var node=result.c[1];
			var str=node.t.split("-");
			var link=node.a.link.split("-");
			var html=[];
			for(var i=0;i<str.length;i++)
			{
				html.push('<a href="/place/cn/'+link.slice(0,i+1).join("/")+'.aspx" target="_blank" style="color:#FFFFFF">'+str[i]+'</a>');
			}
			this.setRgeoText("地图中心点位于："+html.join("-")+" 附近");
		}
		catch(e)
		{
			this.setRgeoText("获取当前中心点信息失败");
		}
	}
	K_CenterPlaceControl.prototype.setRgeoText=function(html)
	{
		this.div.innerHTML=html?html:"地图中心地名信息加载中……";
	}
	K_CenterPlaceControl.prototype.getDefaultPosition=function()
	{
		return new GControlPosition(G_ANCHOR_TOP_LEFT,new GSize(50,10))
	};

	//加载
	function K_PanoramioPhotoControl(config)
	{
		this.loader=new K_JsLoader();
		GEvent.bind(this.loader,"loaded",this,this.onPanoramioLoader);
		this.markers=[];
		this.config=config?config:{};
	}
	K_PanoramioPhotoControl.prototype=new GControl(true,false);
	K_PanoramioPhotoControl.prototype.initialize=function(a)
	{
		this.map=a;
		this.listener=GEvent.bind(a,"moveend",this,this.onMapMove);
		this.onMapMove();
		return document.createElement("div");
	};
	K_PanoramioPhotoControl.prototype.onMapMove=function()
	{
		if(this.timeout){window.clearTimeout(this.timeout);}
		this.timeout=window.setTimeout(K_Function.GetCallBack(this,this.loadPhotos),1000);
	}
	K_PanoramioPhotoControl.prototype.loadPhotos=function()
	{
		var bounds=map.getBounds();
		this.loader.load("http://www.step1.cn/51ditu/Services/JSPano.aspx?minx=" + bounds.getSouthWest().lng() + "&miny=" + bounds.getSouthWest().lat() +"&maxx=" + bounds.getNorthEast().lng() + "&maxy=" + bounds.getNorthEast().lat() + "&from=0&to=50&user=&tag=","utf-8")
	}
	K_PanoramioPhotoControl.prototype.onPanoramioLoader=function(rs)
	{
		this.clear();
		var photos = rs.photos;
		var contentDiv=this.config.content;
		if(contentDiv){while(contentDiv.firstChild){contentDiv.removeChild(contentDiv.firstChild)}}
		for (var i = 0; i < photos.length; i++)
		{
			var p = photos[i];
			if(!this.baseIcon)
			{
				this.baseIcon=new GIcon();
				this.baseIcon.iconSize=new GSize(32,32);
				this.baseIcon.iconAnchor=new GPoint(16,16);
				this.baseIcon.infoWindowAnchor=new GPoint(16,0);
			}
			var iconSrc=p.photo_url.replace("photo/","photos/mini_square/")+'.jpg';
			var icon=new GIcon(this.baseIcon);
			icon.image=iconSrc;
			var marker = new GMarker(new GLatLng(p.latitude,p.longitude),icon);
			marker.panorama=p;
			this.markers.push(marker);
			GEvent.bind(marker, "click",marker,this.onPhotoClick);
			this.map.addOverlay(marker);
			if(contentDiv)
			{
				var img=document.createElement("img");
				img.title=p.photo_title;
				img.style.cursor="pointer";
				img.src=iconSrc;
				img.style.width="32px";
				img.style.height="32px";
				contentDiv.appendChild(img);
				GEvent.bindDom(img,"click",marker,this.onPhotoClick);
			}
		}
	}
	K_PanoramioPhotoControl.prototype.clear=function()
	{
		var marker;
		while(marker=this.markers.pop())
		{
			marker.img=null;
			this.map.removeOverlay(marker);
		}
	}
	K_PanoramioPhotoControl.prototype.onPhotoClick=function()
	{
		var p=this.panorama;
		this.openInfoWindowHtml('<a href="'+this.panorama.photo_url+'" target="_blank"><img border="0" width='+p.width+' height='+p.height+' src="'+p.photo_url.replace("photo/","photos/medium/")+'.jpg"/></a>',{maxTitle:this.panorama.photo_title});
	}
	K_PanoramioPhotoControl.prototype.setRgeoText=function(html)
	{
		this.div.innerHTML=html?html:"地图中心地名信息加载中……";
	}
	K_PanoramioPhotoControl.prototype.getDefaultPosition=function()
	{
		return new GControlPosition(G_ANCHOR_TOP_LEFT,new GSize(50,10))
	};

	window.K_Function=K_Function;
	window.K_CrossControl=K_CrossControl;
	window.K_HtmlControl=K_HtmlControl;
	window.K_LatlngGrid=K_LatlngGrid;
	window.K_IconOverlay=K_IconOverlay;
	window.K_ImageOverlay=K_ImageOverlay;
	window.K_ImageAdjustorOverlay=K_ImageAdjustorOverlay;
	window.K_HtmlMarker=K_HtmlMarker;
	window.K_UserPosition=K_UserPosition;
	window.K_PointMover=K_PointMover;
	window.K_JsLoader=K_JsLoader;
	window.K_XmlLoader=K_XmlLoader;
	window.K_51dituProjection=K_51dituProjection;
	window.K_51dituSpec=K_51dituSpec;
	window.K_CenterPlaceControl=K_CenterPlaceControl;
	window.K_PanoramioPhotoControl=K_PanoramioPhotoControl;
}
Step1Map();