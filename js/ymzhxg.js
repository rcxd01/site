document.writeln("<base target=\"_blank\"\/>")
function fadein(){
mytransition.innerHTML=''
if (cur!='x'){
mytransition.filters.revealTrans.Transition=cur
mytransition.filters.revealTrans.apply()
mytransition.innerHTML='<p align="center"><a href="http://www.wofav.com/"><font face="Verdana">Wofav��ҳ����ť(������վ����)</font></a></p><big><big><p align="center"><a href="http://www.wofav.com/daima.html"><img src="http://www.wofav.com/images/wofav_a.gif" border="0"></a></p><br><p align="center"><font face="Verdana">����"wo"��ϲ����</font></p>'
mytransition.filters.revealTrans.play()
}
else{
mytransition.filters.blendTrans.apply()
mytransition.innerHTML='<p align="center"><a href="http://www.wofav.com/"><font face="Verdana">Wofav��ҳ����ť(������վ����)</font></a></p><big><big><p align="center"><a href="http://www.wofav.com/daima.html"><img src="http://www.wofav.com/images/wofav_a.gif" border="0"></a></p><br><p align="center"><font face="Verdana">����"wo"��ϲ����</font></p>'
mytransition.filters.blendTrans.play()
}
}