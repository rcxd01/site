	var map,pageInited;
	function onLoad()
	{
		if(pageInited){return;}
		if(!window.GMap2 || !window.K_CenterPlaceControl)
		{
			setTimeout(onLoad,1000);
			return;
		}
		pageInited=true;
		initOptions()
		initMap();
		 
	}
	//����URL������ʼ����ͼ
	function initMap()
	{
		map = new GMap2(document.getElementById("mapDiv"));
		var zoom=((zoom=K_Function.GetQueryString("zoom"))!="")?parseInt(zoom):4;
		var lng=K_Function.GetQueryString("lng"),lat=K_Function.GetQueryString("lat");
		 
		if(lng!="" && lat!="")
		{
			 
			map.setCenter(new GLatLng(lat,lng),zoom);
			var info=K_Function.GetQueryString("info");
			CreateMarker(new GLatLng(parseFloat(lat),parseFloat(lng)),getColorIcon("blue"));
		}
		else
		{
			map.setCenter(new GLatLng(36.94,106.08),zoom);
		}
		var pi=K_Function.GetQueryString("p");
		if(pi!="")
		{
			var ps=pi.split(',');
			zoom=17-((ps[2] && ps[2].length>0)?parseInt(ps[2]):12);
			map.setCenter(new GLatLng(parseInt(ps[1])/100000,parseInt(ps[0])/100000),zoom);
		}
		var info=K_Function.GetQueryString("i");
		if(info!="")
		{
			info=info.split(",");
			document.title=info[0]+"_"+document.title;
		}
		//map.addMapType(K_51ditu_MAP);
		map.addControl(new GOverviewMapControl(new GSize(200,150)));
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
		map.enableScrollWheelZoom() ;
	    if(!crossControl)crossControl=new K_CrossControl("/img/cross.gif");
		map.addControl(crossControl);
		var type=K_Function.GetQueryString("t");
		setType(type!=""?type:"Sat");
		GEvent.addListener(map,"moveend",showInfo);
		GEvent.trigger(map,"moveend");
		if(K_Function.GetQueryString("kml")!="")
		{
			LoadKmlFile(K_Function.GetQueryString("kml"));
		}
	}
	//��ʼ��������ѡ��
	function initOptions()
	{
		//addMapOption(ShowUserPosition,'��ʾ�ҵ�λ��(<span id="MyLocate">û������</span>)');
		//addMapOption(ShowCrossControl,'��ʾ��ͼ����ʮ��');
		//addMapOption(showPlaceInfo,'��ʾ���ĵ�����Ϣ');
		//addMapOption(showPanoramioPhoto,'����Panoramio��Ƭ');
	//	<input type="checkBox"/>KML�ر��ļ�<br/>
	}
	//��ʼ��һ����ͼ����
	function addMapOption(handle,html)
	{
		var obj={};
		var div=document.createElement("div");
		var input=document.createElement("input");
		input.type="checkBox";
		obj.input=input;
		GEvent.bindDom(input,"click",obj,handle);
		div.appendChild(input);
		var span=document.createElement("span");
		span.innerHTML=html;
		div.appendChild(span);
		document.getElementById("panelDiv").appendChild(div);
		obj.div=div;
		return obj;
	}
	var baseIcon;
	//����ָ����ɫ��ͼ��
	function getColorIcon(color)
	{
		if(!baseIcon)
		{
			baseIcon = new GIcon();
			baseIcon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
			baseIcon.iconSize = new GSize(12, 20);
			baseIcon.shadowSize = new GSize(22, 20);
			baseIcon.iconAnchor = new GPoint(6, 20);
			baseIcon.infoWindowAnchor = new GPoint(5, 1);
		}
		var icon=new GIcon(baseIcon);
		icon.image = "http://labs.google.com/ridefinder/images/mm_20_"+color+".png";
		return icon;
	}
	//����ָ�����꣬ͼ�����Ϣ�������ݵı��
	function CreateMarker(point,icon,html)
	{
		var marker = new GMarker(point,{icon:icon});
		if(html){GEvent.addListener(marker, "click", function(){marker.openInfoWindowHtml(html);});}
		map.addOverlay(marker);
		return marker;
	}
	//���õ�ͼ��ͼƬ����
	function setType(name)
	{
		mapTypes=map.getMapTypes();
		for(i=0;i<mapTypes.length;i++)if(mapTypes[i].getName(true)==name)map.setMapType(mapTypes[i]);
	}
	//���ص�ǰ��ͼ��URL��ַ
	function GetUrl()
	{
		return 'http://ditu.wofav.cn/maps.html?lng='+map.getCenter().lng()+'&lat='+map.getCenter().lat()+'&zoom='+map.getZoom()+'&t='+map.getCurrentMapType().getName(true);
	}
	//�ڵ�ͼ�ƶ���ʱ����ĵ�ͼ�ľ�γ����ʾ
	function showInfo()
	{
		var zoom=map.getZoom();
		var num=parseInt(Math.log(1/(map.getSize().width/map.getBounds().toSpan().lng()))/Math.log(10));
		var point=map.getCenter();
		var px=point.lng().toString();
		px=px.substring(0,px.indexOf(".")-num+2);
		var py=point.lat().toString();
		py=py.substring(0,py.indexOf(".")-num+2);
		document.getElementById("I_Center").value =px+","+py;
	}

	//��ʾ�û�����λ�õĴ���
	var userPosition;
	function ShowUserPosition()
	{
		if(this.input.checked)
		{
			if(userPosition && userPosition.loaded){userPosition.marker=CreateMarker(userPosition.point,getColorIcon("green"),"���ĵ���λ��");}
			else{document.getElementById('MyLocate').innerHTML="�����С�";userPosition=new K_UserPosition();userPosition.Load(SetUserPosition);}
		}
		else
		{
			if(userPosition.marker!=null){map.removeOverlay(userPosition.marker);}
		}
		return true;
	}
	function SetUserPosition()
	{
		document.getElementById('MyLocate').innerHTML='<a href="javascript:map.setCenter(new GLatLng('+this.point.lat()+','+this.point.lng()+'),'+this.zoom+');">�鿴λ��</a>';
		this.marker=CreateMarker(this.point,getColorIcon("green"),"���ĵ���λ��");
	}

	//������ʾ����ʮ�ֵĴ���
	var crossControl
	function ShowCrossControl(a)
	{
		if(this.input.checked)
		{
			if(!crossControl)crossControl=new K_CrossControl("/img/cross.gif");
			map.addControl(crossControl);
		}
		else
		{
			map.removeControl(crossControl);
		}
	}

	//������ʾ���ĵ�����Ϣ
	var placeInfoControl;
	function showPlaceInfo()
	{
		if(this.input.checked)
		{
			if(!placeInfoControl){placeInfoControl=new K_CenterPlaceControl();}
			map.addControl(placeInfoControl);
		}
		else
		{
			map.removeControl(placeInfoControl);
		}
	}
	//���ڼ���Panoramio��Ƭ�Ĵ���
	var panoramioPhoto;
	function showPanoramioPhoto()
	{
		if(this.input.checked)
		{
			if(!panoramioPhoto){panoramioPhoto=new K_PanoramioPhotoControl({content:document.getElementById("panoramioContent")});}
			map.addControl(panoramioPhoto);
		}
		else
		{
			map.removeControl(panoramioPhoto);
		}
	}
	var kmlFileOverlayTreeNode;
	function LoadKmlFile(url)
	{
		var overlayTree=new K_OverlayTree(map,kmlFileOverlayTreeNode);
		var kmlLoad=new K_JsLoader(K_Function.GetCallBack(overlayTree,overlayTree.ParseKml));
		if(url.indexOf("http://")==0)
			url="http://www.step1.cn/Kml/GetKmlFile.aspx?url="+url;
		 
		kmlLoad.load(url);
	}
	onLoad();