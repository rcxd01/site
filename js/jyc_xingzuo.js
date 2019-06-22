
function setClass(o,s){
	o.className = s;
}

function addClass(o,s){
	o.className += ' ' + s;
}

function delClass(o,s){
	o.className = o.className.replace(' ' + s,"");
}

function fGetStar(isInit){
	var month = document.getElementById('month').value;
	var day = document.getElementById('day').value;
	var nMonth = parseInt(month);
	var nDay = parseInt(day);
	var nPage = 1;
	if(isNaN(nMonth) || nMonth < 1 || nMonth >12  ){
		alert("��������ȷ���·�");
		document.getElementById("month").focus();
		return false;
	}else if(isNaN(nDay) || nDay < 1 || nDay >31 ){
		alert("��������ȷ������");
		document.getElementById("day").focus();
		return false;
	}
	var nDate = nMonth * 100 + nDay;
	var sStar = "";
	if(nDate >= 121 && nDate <= 219){
		sStar = "ˮƿ��";
		nPage = 11;
	}else if (nDate >= 220 && nDate <= 320){
		sStar = "˫����";
		nPage = 12;
	}else if (nDate >= 321 && nDate <= 420){
		sStar = "������";
		nPage = 1;
	}else if (nDate >= 421 && nDate <= 520){
		sStar = "��ţ��";
		nPage = 2;
	}else if (nDate >= 521 && nDate <= 621){
		sStar = "˫����";
		nPage = 3;
	}else if (nDate >= 622 && nDate <= 722){
		sStar = "��з��";
		nPage = 4;
	}else if (nDate >= 723 && nDate <= 822){
		sStar = "ʨ����";
		nPage = 5;
	}else if (nDate >= 823 && nDate <= 922){
		sStar = "��Ů��";
		nPage = 6;
	}else if (nDate >= 923 && nDate <= 1022){
		sStar = "�����";
		nPage = 7;
	}else if (nDate >= 1023 && nDate <= 1121){
		sStar = "��Ы��";
		nPage = 8;
	}else if (nDate >= 1122 && nDate <= 1221){
		sStar = "������";
		nPage = 9;
	}else if (nDate >= 1222 || nDate <= 119){
		sStar = "Ħ����";
		nPage = 10;
	}
	if(isInit){
		document.getElementById("sStar").innerHTML = sStar;			
	}else{
		var sHost = "";
		if(location.host.indexOf("lady") !=-1){
			sHost = location.search.substr(1);
		}else{
			sHost = location.host
		}
		location.href = "star_"+nPage+".html?"+sHost+"#"+nMonth+","+nDay;
	}
	return false;
}

function fInitStar(){
	if(location.host.indexOf("lady") != -1) return;
	var oNow = new Date();
	if(location.hash.length>0){
		sTime = location.hash.replace("#","");
		aTime = sTime.split(",");
		var month = aTime[0];
		var day = aTime[1];
	}else{
		var month = oNow.getMonth() + 1;
		var day = oNow.getDate();
	}
	document.getElementById('month').value = month;
	document.getElementById('day').value = day;
//	fGetStar(true);
}
