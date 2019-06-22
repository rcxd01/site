/**
 * 储蓄存款计算器
 * Author: xiaohong.liu
 * Date: 2008-9-11 
 */

var intervalDays;   //存款天数
var savingMoney;    //存款总金额
var interestRate;   //年利率
var accrualTaxRate  //利息税率
var savingKind;     //存款种类
var savingTerm;     //存款期限
var dayScale=1.00;  //日期尺度
var monthScale=12.00;//月期尺度


//初始化计算器
function initSaving(){
    document.getElementById("saving_startDate").value=getTodayDate();
    document.getElementById("saving_endDate").value=getTodayDate();

    document.getElementById("moneyName").innerHTML="";
    document.getElementById("moneyName").options.add(new Option("--请选择--","0"));
    for(var i=0;i<savingMoneyArr.length;i++){
        document.getElementById("moneyName").options.add(new Option(savingMoneyArr[i][1],savingMoneyArr[i][0]));
    }
}

/**
 * 计算存款利息
 */
function calculateSaving(){
    if(document.getElementById("moneyName").value=="0"){
        alert("请选择货币种类");
        document.getElementById("moneyName").focus();
        return false;
    }
    if(document.getElementById("savingKind").value=="0"){
        alert("请选择存款种类");
        document.getElementById("savingKind").focus();
        return false;
    }
    if(document.getElementById("savingTerm").value=="0"){
        alert("请选择存款期限");
        document.getElementById("savingTerm").focus();
        return false;
    }
    intervalDays=getIntervalDays(document.getElementById("saving_startDate").value,document.getElementById("saving_endDate").value);
    intervalDays=parseInt(intervalDays);
    if(intervalDays<=0){
        alert("请正确输入起始日期和终止日期！");
        return false;
    }
    document.getElementById("savingDays").value=intervalDays;
    savingMoney=getSavingMoney();
    savingMoney=parseFloat(savingMoney);
    if(!savingMoney>0){
        alert("请输入正确的存款金额！");
        document.getElementById("savingMoney").focus();
        return false;
    }
    interestRate=getInterestRate();
    interestRate=parseFloat(interestRate);
    if(interestRate==0){
        alert("请输入正确的年利率！");
        document.getElementById("interestRate").focus();
        return false;
    }
    accrualTaxRate=getAccrualTaxRate();
    if(accrualTaxRate==-1){
        alert("请输入正确的利息税率！");
        document.getElementById("accrualTaxRate").focus();
        return false;
    }
    savingKind=document.getElementById("savingKind").options[document.getElementById("savingKind").selectedIndex].innerText;


	var totalAccrual;      //利息总额
    var totalTax;          //利息税额
    var gainedAccrual;     //实得利息
    var summation;         //本息合计
    var mensalAccrual=0.00;//每月利息
    if(savingKind=="整存整取"){
        totalAccrual = savingMoney*(interestRate/100.00)*dayScale;
        totalAccrual = formatFloat(totalAccrual,2);
        totalTax=totalAccrual*(accrualTaxRate/100.00);
        totalTax=formatFloat(totalTax,2);
        gainedAccrual=totalAccrual-totalTax;
        gainedAccrual=formatFloat(gainedAccrual,2);
        summation=gainedAccrual+savingMoney;
        summation=formatFloat(summation,2);

    }else if(savingKind=="零存整取"){
        totalAccrual = savingMoney*(interestRate/(12*100.00))*(1+monthScale)*monthScale/2;
        totalAccrual = formatFloat(totalAccrual,2);
        totalTax=totalAccrual*(accrualTaxRate/100.00);
        totalTax=formatFloat(totalTax,2);
        gainedAccrual=totalAccrual-totalTax;
        gainedAccrual=formatFloat(gainedAccrual,2);
        summation=gainedAccrual+savingMoney;
        summation=formatFloat(summation,2);
    }else if(savingKind=="存本取息"){
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
        totalAccrual = savingMoney*(interestRate/100.00)*intervalDays/365.00;//利息总额
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
 * 返回结果处理
 * @param response ：结果对象
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
 * 获取存款总金额
 * @return 存款总金额，失败返回0
 */
function getSavingMoney(){
    if(checkNumber(document.getElementById("savingMoney").value)){
        return document.getElementById("savingMoney").value;
    }else{
        return 0;
    }
}

/**
 * 获取年利率
 * @return 年利率，失败返回0
 */
function getInterestRate(){
    if(checkNumber(document.getElementById("interestRate").value)){
        return document.getElementById("interestRate").value;
    }else{
        return 0;
    }
}

/**
 * 获取利息税率
 * @return 利息税率，失败返回-1
 */
function getAccrualTaxRate(){
    if(checkNumber(document.getElementById("accrualTaxRate").value)){
        return document.getElementById("accrualTaxRate").value;
    }else{
        return -1;
    }   
}

/**
 * 清空数据
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
 * 当选择“货币种类”下拉菜单时执行
 */
function changeMoneyName(){
    var moneyNameId=document.getElementById("moneyName").value;
    document.getElementById("savingKind").innerHTML="";
    document.getElementById("savingKind").options.add(new Option("--请选择--","0"));
    for(var i=0;i<savingKindArr.length;i++){
        if(moneyNameId==savingKindArr[i][0]){
            document.getElementById("savingKind").options.add(new Option(savingKindArr[i][1],savingKindArr[i][2]));
        }
    }
}

/**
 * 当选择“存款种类”下拉菜单时执行
 */
function changeSavingKind(){
    var savingKindId=document.getElementById("savingKind").value;
    document.getElementById("savingTerm").innerHTML="";
    document.getElementById("savingTerm").options.add(new Option("--请选择--","0"));
    for(var i=0;i<savingTermArr.length;i++){
        if(savingTermArr[i][1].indexOf(savingKindId)==0){
            document.getElementById("savingTerm").options.add(new Option(savingTermArr[i][2],savingTermArr[i][0]));
        }
    }
}

/**
 * 当选择“存款期限”下拉菜单时执行
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
        case "一天":
            AddDays(document.getElementById("saving_startDate").value,7);
            break;
        case "七天":
            AddDays(document.getElementById("saving_startDate").value,7);
            break;
        case "一个月":
            AddMonths(document.getElementById("saving_startDate").value,1);
            break;
        case "三个月":
            dayScale = 0.25;
            AddMonths(document.getElementById("saving_startDate").value,3);
            break;
        case "六个月":
            AddMonths(document.getElementById("saving_startDate").value,6);
            break;
        case "半年":
            dayScale = 0.5;
            AddMonths(document.getElementById("saving_startDate").value,6);
            break;
        case "一年":
            dayScale = 1.0;
            monthScale = 12.0;
            AddYears(document.getElementById("saving_startDate").value,1);
            break;
        case "二年":
            dayScale = 2.0;
            AddYears(document.getElementById("saving_startDate").value,2);
            break;
        case "三年":
            dayScale = 3.0;
            monthScale = 36.0;
            AddYears(document.getElementById("saving_startDate").value,3);
            break;
        case "五年":
            dayScale = 5.0;
            monthScale = 60.0;
            AddYears(document.getElementById("saving_startDate").value,5);
            break;
        default:
            break;
    }
}
/**
 * 清空数据
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