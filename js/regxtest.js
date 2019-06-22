function setVisible(idElement, visible) {
   var obj = document.getElementById(idElement);obj.style.visibility = visible ? "visible" : "hidden";}
function isValidFields() {
   var textSour = document.getElementById("textSour");
   if (null==textSour.value || textSour.value.length<1) {
       textSour.focus();alert("������Դ�ı�");return false;}
   var textPattern = document.getElementById("textPattern");
   if (null==textPattern.value || textPattern.value.length<1) {
       textPattern.focus();alert("������������ʽ");return false;}
   return true;}
function buildRegex() {
   var op = "";
   if (document.getElementById("optionGlobal").checked)op = "g";
   if (document.getElementById("optionIgnoreCase").checked)op = op + "i";
   return new RegExp(document.getElementById("textPattern").value, op);}
function onMatch() {
   if (!isValidFields())
   return false;document.getElementById("textMatchResult").value = "";
   var regex = buildRegex();
   var result = document.getElementById("textSour").value.match(regex);
   if (null==result || 0==result.length) {document.getElementById("textMatchResult").value = "��û��ƥ�䣩";
       return false;}
   if (document.getElementById("optionGlobal").checked) {
     var strResult = "���ҵ� " + result.length + " ��ƥ�䣺\r\n";
     for (var i=0; i < result.length; ++i)strResult = strResult + result[i] + "\r\n";
       document.getElementById("textMatchResult").value = strResult;
     } else {
       document.getElementById("textMatchResult").value= "ƥ��λ�ã�" + regex.lastIndex + "\r\nƥ������" + result[0];
     }return true;}
function onReplace() {
   var str = document.getElementById("textSour").value;
   var regex = buildRegex();document.getElementById("textReplaceResult").value= str.replace(regex, document.getElementById("textReplace").value);}