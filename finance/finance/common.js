/**
 * ������ͨ��js
 * Author: xiaohong.liu
 * Date: 2008-9-11
 */
 
var validRegExp= /[<>%#^&~]/;

/**
 * ��֤һ��ֵ�Ƿ�Ϊ����
 * @param value��ֵ
 */
function checkNumber(value)
{
    var reNumber = /^[0-9]+.?[0-9]*$/;
    if (!reNumber.test(value))
    {
        return false;
    }
    return true;
}

/**
 * ��֤һ��ֵ�Ƿ�Ϊ����
 * @param value��ֵ
 */
function checkInteger(value)
{
    var reNumber = /^[-]{0,1}[0-9]{1,}$/;
    if (!reNumber.test(value))
    {
        return false;
    }
    return true;
}

/**
 * ���ؽ������ڣ���ʽ�磺2008-8-8
 */
function getTodayDate(){
    var today=new Date();
    var year=today.getFullYear();
    var month=today.getMonth()+1;
    var day=today.getDate();
    return year+"-"+month+"-"+day;
}

/**
 * ������ʼ���ں���ֹ���ڻ�ü������
 * @param startDate  ��ʼ���ڣ���ʽ��:2008-8-8
 * @param endDate    ��ֹ���ڣ���ʽ�磺2008-8-8
 * @return ���������ʧ�ܷ���0
 */
function getIntervalDays(startDate,endDate){
    try{
        var arrStartDay=startDate.split("-");
        var arrEndDay=endDate.split("-");
        if(!checkInteger(arrStartDay[0])||!checkInteger(arrStartDay[1])||!checkInteger(arrStartDay[2])){
            throw "e";
        }
        if(!checkInteger(arrEndDay[0])||!checkInteger(arrEndDay[1])||!checkInteger(arrEndDay[2])){
            throw "e";
        }
        if(arrStartDay[0].length!=4||arrStartDay[0]<1000||arrStartDay[1]<1||arrStartDay[1]>12||arrStartDay[2]<1||arrStartDay[2]>31){throw "e"};
        if(arrEndDay[0].length!=4||arrEndDay[0]<1000||arrEndDay[1]<1||arrEndDay[1]>12||arrEndDay[2]<1||arrEndDay[2]>31){throw "e"};
        var interval=(new Date(arrEndDay[0],arrEndDay[1],arrEndDay[2]).getTime()-new Date(arrStartDay[0],arrStartDay[1],arrStartDay[2]).getTime())/(1000*60*60*24);
        interval=parseInt(interval);
        return interval;
    }catch(e){
        return 0;
    }
}

/**
 * ��������
 * @param startDate ��ʽ��2008-8-8
 * @param num ����
 */
function AddYears(startDate,num){
    var arrStartDay=startDate.split("-");
    arrStartDay[0]=parseInt(arrStartDay[0])+num;
    document.getElementById("saving_endDate").value =arrStartDay[0]+"-"+arrStartDay[1]+"-"+arrStartDay[2];
}

/**
 * ��������
 * @param startDate ��ʽ��2008-8-8
 * @param num ����
 */
function AddMonths(startDate,num){
    var arrStartDay=startDate.split("-");
    arrStartDay[0]=parseInt(arrStartDay[0]);
    arrStartDay[1]=parseInt(arrStartDay[1]);
    if((arrStartDay[1]+num)>12){
        arrStartDay[0]=arrStartDay[0]+1;
        arrStartDay[1]=(arrStartDay[1]+num)-12;
    }else{
        arrStartDay[1]=arrStartDay[1]+num;
    }
    document.getElementById("saving_endDate").value =arrStartDay[0]+"-"+arrStartDay[1]+"-"+arrStartDay[2];
}
/**
 * ��������
 * @param startDate ��ʽ��2008-8-8
 * @param num ����
 */
function AddDays(startDate,num){
    var arrStartDay=startDate.split("-");
    arrStartDay[0]=parseInt(arrStartDay[0]);
    arrStartDay[1]=parseInt(arrStartDay[1]);
    arrStartDay[2]=parseInt(arrStartDay[2]);
    var monthDaysNum=30;
    //1,3,5,7,8,10,12 ����31��
    if(arrStartDay[1]==1||arrStartDay[1]==3||arrStartDay[1]==5||arrStartDay[1]==7||arrStartDay[1]==8||arrStartDay[1]==10||arrStartDay[1]==12){
        monthDaysNum=31;
    }else if(arrStartDay[1]==2){
        if(0==arrStartDay[0]%4&&((arrStartDay[0]%100!=0)||(arrStartDay[0]%400==0))){
            monthDaysNum=29;//����29��
        }else{
            monthDaysNum=28;//ƽ��28��
        }
    }else{
        monthDaysNum=30;
    }
    if((arrStartDay[2]+num)>monthDaysNum){
        arrStartDay[2]=arrStartDay[2]+num-monthDaysNum;
            if((arrStartDay[1]+1)>12){
                arrStartDay[0]=arrStartDay[0]+1;
                arrStartDay[1]=(arrStartDay[1]+1)-12;
            }else{
                arrStartDay[1]=arrStartDay[1]+1;
            }

    }else{
        arrStartDay[2]=arrStartDay[2]+num;
    }
    document.getElementById("saving_endDate").value =arrStartDay[0]+"-"+arrStartDay[1]+"-"+arrStartDay[2];
}

/**
 * ȡС�������λ����������
 * @param value������
 * @return ��������������
 */
function getRound(value)
{
    return Math.round((Math.floor(value*1000)/10))/100;
}

/**
 *ȥǰ��ո�
 */
String.prototype.trim = function()  {return this.replace(/(^\s*)|(\s*$)/g,"");} 


/**
 * У���ַ������Ƿ�����Ƿ��ַ�
 * @ parm string 
 * @ since 1.0
 */
function checkLegalChar(string){
	var isValid=validRegExp.test(string); 
	if (isValid){
		alert("�������ֵ\""+ string +"\"�����Ƿ��ַ�(<,>,%,#,^,&,~)��");	
		return true; 
	} 
	else{
		return false; 
	}
}

/**
 * У����е���������ؼ����Ƿ��зǷ��ַ�
 * �����������,Ĭ���� forms[0]
 */
function checkLegalTextInForm(formName){
	var formObj;
	if (formName == null || formName == "") {
		formObj = document.forms[0];  
	} else {
		formObj = document.forms[formName]; 
	} 
	var formEle = formObj.elements;    
	for (var i=0; i<formEle.length; i++)     {  
		var element = formEle[i];         
		if (element.type == "text") { 
			if(element.readOnly==true){
				continue;
			}else if(checkLegalChar(element.value)){
				//alert("�������ֵ\""+ element.value +"\"�����Ƿ��ַ�(<,>,#,^,&,~)��");
				return true;
			}
		}         
		if (element.type == "textarea") { 
			if(element.readOnly==true){
			continue;
		}else if(checkLegalChar(element.value)){
			//alert("�������ֵ\""+ element.value +"\"�����Ƿ��ַ�(<,>,#,^,&,~)��");
			return true;
		}
		}         
	} 
}

/**
 * У��绰�����ʽ�Ƿ���ȷ
 * ���¸�ʽ�ĵ绰��������
 * ����-�绰��(����)�绰�����ŵ绰���绰���ֻ��ţ�0�ֻ���
 * ���У������Ǳ�����0��ͷ������λ������λ���ֵĺ���
 * �绰��3��8λ���ֵĺ���
 * �ֻ����Ǳ�����13����15��ͷ����11λ���ֵĺ���
 * @ parm string 
 * @ since 1.0
 */
function checkLegalTel(string){
	/*var validRegExp=/^((\(\d{3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}$/;*/
	var validRegExp=/(^0[0-9]{2,3}\-?[0-9]{3,8}$)|(^[0-9]{3,8}$)|(^\(0[0-9]{2,3}\)[0-9]{3,8}$)|(^0{0,1}13[0-9]{9}$)|(^0{0,1}15[0-9]{9}$)/;
	var isValid=validRegExp.test(string); 
	if (isValid){
		return true; 
	} else {
		return false; 
	}
}




/**
 * ���form��(��������ո�ѡ�򣬵�ѡť)
 * �����������,Ĭ�����forms[0]
 * @ parm string 
 */
function clearForm(formName) {
   var formObj;
   if (formName == null || formName == "") {
   	 formObj = document.forms[0];  
   } else {
   	 formObj = document.forms[formName]; 
   }  
   var formEle = formObj.elements;    
   for (var i=0; i<formEle.length; i++)     {  
	 var element = formEle[i];         
	 if (element.type == "submit") { continue; }      
	 if (element.type == "reset") { continue; }         
	 if (element.type == "button") { continue; }         
	 if (element.type == "hidden") { continue; } 
	 if (element.type == "checkbox") { continue; }         
	 if (element.type == "radio") { continue; }
	 if (element.type == "text") { element.value = ""; }         
	 if (element.type == "textarea") { element.value = ""; }         
	 if (element.type == "select-multiple") { element.selectedIndex = ""; }         
	 if (element.type == "select-one") { element.selectedIndex = ""; }   
	   
   }  
}
/**
 * ���form��(������ո�ѡ�򣬵�ѡť)
 * �����������,Ĭ�����forms[0]
 * @ parm string 
 */
function clearForm2(formName) {   
   var formObj;
   if (formName == null || formName == "") {
   	 formObj = document.forms[0];  
   } else {
   	 formObj = document.forms[formName]; 
   }  
   var formEle = formObj.elements;    
   for (var i=0; i<formEle.length; i++)     {  
	 var element = formEle[i];         
	 if (element.type == "submit") { continue; }      
	 if (element.type == "reset") { continue; }         
	 if (element.type == "button") { continue; }         
	 if (element.type == "hidden") { continue; } 
	 if (element.type == "checkbox") { element.checked = false; }         
	 if (element.type == "radio") { element.checked = false; }
	 if (element.type == "text") { element.value = ""; }         
	 if (element.type == "textarea") { element.value = ""; }         
	 if (element.type == "select-multiple") { element.selectedIndex = -1; }         
	 if (element.type == "select-one") { element.selectedIndex = -1; }   
	   
   }  
}
/**
 * ��ʽ��float���ͣ�����С��������λ
 * @param {Object} src
 * @param {Object} pos
 */
function formatFloat(src, pos){
    return Math.round(src*Math.pow(10, pos))/Math.pow(10, pos);
}