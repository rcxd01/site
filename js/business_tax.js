var str = "";

function show_range(){

	var nVal = document.getElementById('type').options[document.getElementById('type').selectedIndex].value	;

	if (nVal > 0)
	{

		str = document.business_tax.fanwei[nVal-1].value;

		document.getElementById('range').innerHTML  = '<strong style="color:#000">���շ�Χ: </strong>'+str;


	}
	else
	{

		document.getElementById('range').innerText  = "";
	}

}

//�Ƿ�Ϊ��ֵ
String.prototype.is_number = function(){

	return /^[1-9][0-9]*(.[0-9]+)?$/.test(this);

}

function account(){
	var nVal =  document.getElementById('type').options[document.getElementById('type').selectedIndex].value	;
	var strtext = document.getElementById('type').options[document.getElementById('type').selectedIndex].text;

	var paynum=document.getElementById('number').value;

	if (nVal == "0")
	{
		alert("��ѡ��˰Ŀ");
		return false;
	}
	if(!checkData(document.getElementById('number'),"Ӫҵ��")) return;



	if(paynum.is_number() == false){
		alert("��ȷ���������Ӫҵ�������֣�");
		return false;
	}
	else{

	   paynum=eval(paynum);
	
	}

	var tax = paynum*document.business_tax.shuilv[nVal-1].value;
	tax=Math.round(tax*100)/100;
	var  remarks=" �������Ӫҵ��Ϊ��" + paynum + "\n �����˰ĿΪ��" +strtext
	+ "\n Ӧ��Ӫҵ˰��Ϊ��" + tax;
	alert(remarks);
}


function checkData(Obj,Str){
	if (Obj.value==""){alert("��������"+Str+"\n");Obj.focus();return false;}else{return true;}
}