/**
 * �����������
 * Author: xiaohong.liu
 * Date: 2008-9-11 
 */

var intervalDays;   //�������
var savingMoney;    //����ܽ��
var interestRate;   //������
var accrualTaxRate  //��Ϣ˰��
var savingKind;     //�������
var savingTerm;     //�������
var dayScale=1.00;  //���ڳ߶�
var monthScale=12.00;//���ڳ߶�


//��ʼ��������
function initSaving(){
    document.getElementById("saving_startDate").value=getTodayDate();
    document.getElementById("saving_endDate").value=getTodayDate();

    document.getElementById("moneyName").innerHTML="";
    document.getElementById("moneyName").options.add(new Option("--��ѡ��--","0"));
    for(var i=0;i<savingMoneyArr.length;i++){
        document.getElementById("moneyName").options.add(new Option(savingMoneyArr[i][1],savingMoneyArr[i][0]));
    }
}

/**
 * ��������Ϣ
 */
function calculateSaving(){
    if(document.getElementById("moneyName").value=="0"){
        alert("��ѡ���������");
        document.getElementById("moneyName").focus();
        return false;
    }
    if(document.getElementById("savingKind").value=="0"){
        alert("��ѡ��������");
        document.getElementById("savingKind").focus();
        return false;
    }
    if(document.getElementById("savingTerm").value=="0"){
        alert("��ѡ��������");
        document.getElementById("savingTerm").focus();
        return false;
    }
    intervalDays=getIntervalDays(document.getElementById("saving_startDate").value,document.getElementById("saving_endDate").value);
    intervalDays=parseInt(intervalDays);
    if(intervalDays<=0){
        alert("����ȷ������ʼ���ں���ֹ���ڣ�");
        return false;
    }
    document.getElementById("savingDays").value=intervalDays;
    savingMoney=getSavingMoney();
    savingMoney=parseFloat(savingMoney);
    if(!savingMoney>0){
        alert("��������ȷ�Ĵ���");
        document.getElementById("savingMoney").focus();
        return false;
    }
    interestRate=getInterestRate();
    interestRate=parseFloat(interestRate);
    if(interestRate==0){
        alert("��������ȷ�������ʣ�");
        document.getElementById("interestRate").focus();
        return false;
    }
    accrualTaxRate=getAccrualTaxRate();
    if(accrualTaxRate==-1){
        alert("��������ȷ����Ϣ˰�ʣ�");
        document.getElementById("accrualTaxRate").focus();
        return false;
    }
    savingKind=document.getElementById("savingKind").options[document.getElementById("savingKind").selectedIndex].innerText;


	var totalAccrual;      //��Ϣ�ܶ�
    var totalTax;          //��Ϣ˰��
    var gainedAccrual;     //ʵ����Ϣ
    var summation;         //��Ϣ�ϼ�
    var mensalAccrual=0.00;//ÿ����Ϣ
    if(savingKind=="������ȡ"){
        totalAccrual = savingMoney*(interestRate/100.00)*dayScale;
        totalAccrual = formatFloat(totalAccrual,2);
        totalTax=totalAccrual*(accrualTaxRate/100.00);
        totalTax=formatFloat(totalTax,2);
        gainedAccrual=totalAccrual-totalTax;
        gainedAccrual=formatFloat(gainedAccrual,2);
        summation=gainedAccrual+savingMoney;
        summation=formatFloat(summation,2);

    }else if(savingKind=="�����ȡ"){
        totalAccrual = savingMoney*(interestRate/(12*100.00))*(1+monthScale)*monthScale/2;
        totalAccrual = formatFloat(totalAccrual,2);
        totalTax=totalAccrual*(accrualTaxRate/100.00);
        totalTax=formatFloat(totalTax,2);
        gainedAccrual=totalAccrual-totalTax;
        gainedAccrual=formatFloat(gainedAccrual,2);
        summation=gainedAccrual+savingMoney;
        summation=formatFloat(summation,2);
    }else if(savingKind=="�汾ȡϢ"){
        totalAccrual = savingMoney*(interestRate/100.00);
        totalAccrual = formatFloat(totalAccrual,2);
        totalTax=totalAccrual*(accrualTaxRate/100.00);
        totalTax=formatFloat(totalTax,2);
        gainedAccrual=totalAccrual-totalTax;
        gainedAccrual=formatFloat(gainedAccrual,2);
        summation=gainedAccrual+savingMoney;
        summation=formatFloat(summation,2);
        mensalAccrual = 0;
        mensalAccrual = formatFloat(totalAccrual / monthScale, 2);
    }
    else{
        totalAccrual = savingMoney*(interestRate/100.00)*intervalDays/365.00;//��Ϣ�ܶ�
        totalAccrual = formatFloat(totalAccrual,2);
        totalTax=totalAccrual*(accrualTaxRate/100.00);
        totalTax=formatFloat(totalTax,2);
        gainedAccrual=totalAccrual-totalTax;
        gainedAccrual=formatFloat(gainedAccrual,2);
        summation=gainedAccrual+savingMoney;
        summation=formatFloat(summation,2);
    }
	showData_saving(totalAccrual+"|"+totalTax+"|"+gainedAccrual+"|"+summation+"|"+mensalAccrual);
}

/**
 * ���ؽ������
 * @param response ���������
 */
function showData_saving(rt){
    var arrRt=rt.split("|");
    document.getElementById("totalAccrual").value=arrRt[0];
    document.getElementById("totalTax").value=arrRt[1];
    document.getElementById("gainedAccrual").value=arrRt[2];
    document.getElementById("saving_summation").value=arrRt[3];
//    document.getElementById("mensalAccrual").value=arrRt[4];
}

/**
 * ��ȡ����ܽ��
 * @return ����ܽ�ʧ�ܷ���0
 */
function getSavingMoney(){
    if(checkNumber(document.getElementById("savingMoney").value)){
        return document.getElementById("savingMoney").value;
    }else{
        return 0;
    }
}

/**
 * ��ȡ������
 * @return �����ʣ�ʧ�ܷ���0
 */
function getInterestRate(){
    if(checkNumber(document.getElementById("interestRate").value)){
        return document.getElementById("interestRate").value;
    }else{
        return 0;
    }
}

/**
 * ��ȡ��Ϣ˰��
 * @return ��Ϣ˰�ʣ�ʧ�ܷ���-1
 */
function getAccrualTaxRate(){
    if(checkNumber(document.getElementById("accrualTaxRate").value)){
        return document.getElementById("accrualTaxRate").value;
    }else{
        return -1;
    }   
}

/**
 * �������
 */
function resetAll(){
    document.getElementById("moneyName").value="0";
    document.getElementById("savingKind").value="0";
    document.getElementById("savingTerm").value="0";
    document.getElementById("interestRate").value="0.00";
    document.getElementById("savingMoney").value="0.00";
    document.getElementById("savingDays").value="0";
    document.getElementById("totalTax").value="0.00";
    document.getElementById("totalAccrual").value="0.00";
    document.getElementById("accrualTaxRate").value="0.00";
    document.getElementById("gainedAccrual").value="0.00";
    document.getElementById("saving_summation").value="0.00";
    document.getElementById("saving_startDate").value=getTodayDate();
    document.getElementById("saving_endDate").value=getTodayDate();  
}

/**
 * ��ѡ�񡰻������ࡱ�����˵�ʱִ��
 */
function changeMoneyName(){
    var moneyNameId=document.getElementById("moneyName").value;
    document.getElementById("savingKind").innerHTML="";
    document.getElementById("savingKind").options.add(new Option("--��ѡ��--","0"));
    for(var i=0;i<savingKindArr.length;i++){
        if(moneyNameId==savingKindArr[i][0]){
            document.getElementById("savingKind").options.add(new Option(savingKindArr[i][1],savingKindArr[i][2]));
        }
    }
}

/**
 * ��ѡ�񡰴�����ࡱ�����˵�ʱִ��
 */
function changeSavingKind(){
    var savingKindId=document.getElementById("savingKind").value;
    document.getElementById("savingTerm").innerHTML="";
    document.getElementById("savingTerm").options.add(new Option("--��ѡ��--","0"));
    for(var i=0;i<savingTermArr.length;i++){
        if(savingTermArr[i][1].indexOf(savingKindId)==0){
            document.getElementById("savingTerm").options.add(new Option(savingTermArr[i][2],savingTermArr[i][0]));
        }
    }
}

/**
 * ��ѡ�񡰴�����ޡ������˵�ʱִ��
 */
function doChangeSavingTerm(){
    
    var termId=document.getElementById("savingTerm").value;
    for(var i=0;i<savingRateArr.length;i++){
        if(savingRateArr[i][0]==termId){
            document.getElementById("interestRate").value=savingRateArr[i][1];
            break;
        }
    }

    savingTerm=document.getElementById("savingTerm").options[document.getElementById("savingTerm").selectedIndex].innerText;
    switch(savingTerm)
    {
        case "һ��":
            AddDays(document.getElementById("saving_startDate").value,7);
            break;
        case "����":
            AddDays(document.getElementById("saving_startDate").value,7);
            break;
        case "һ����":
            AddMonths(document.getElementById("saving_startDate").value,1);
            break;
        case "������":
            dayScale = 0.25;
            AddMonths(document.getElementById("saving_startDate").value,3);
            break;
        case "������":
            AddMonths(document.getElementById("saving_startDate").value,6);
            break;
        case "����":
            dayScale = 0.5;
            AddMonths(document.getElementById("saving_startDate").value,6);
            break;
        case "һ��":
            dayScale = 1.0;
            monthScale = 12.0;
            AddYears(document.getElementById("saving_startDate").value,1);
            break;
        case "����":
            dayScale = 2.0;
            AddYears(document.getElementById("saving_startDate").value,2);
            break;
        case "����":
            dayScale = 3.0;
            monthScale = 36.0;
            AddYears(document.getElementById("saving_startDate").value,3);
            break;
        case "����":
            dayScale = 5.0;
            monthScale = 60.0;
            AddYears(document.getElementById("saving_startDate").value,5);
            break;
        default:
            break;
    }
}
/**
 * �������
 */
function resetAll_saving(){
    document.getElementById("moneyName").value="0";
    document.getElementById("savingKind").value="0";
    document.getElementById("savingTerm").value="0";
    document.getElementById("interestRate").value="0.00";
    document.getElementById("savingMoney").value="0.00";
    document.getElementById("savingDays").value="0";
    document.getElementById("totalTax").value="0.00";
    document.getElementById("totalAccrual").value="0.00";
    document.getElementById("accrualTaxRate").value="0.00";
    document.getElementById("gainedAccrual").value="0.00";
    document.getElementById("saving_summation").value="0.00";
    document.getElementById("saving_startDate").value=getTodayDate();
    document.getElementById("saving_endDate").value=getTodayDate();  
}