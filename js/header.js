document.writeln("<div class=\"topbg\"><div class=\"w950 head1\"><div class=\"flo_l logo\"><a href=\"\/\" target=\"_self\"><img src=\"\/img\/logo.gif\" \/><\/a><\/div>");
document.writeln("<div class=\"flo_r head2\"><div class=\"rcor flo_r\"><ul><li><img src=\"\/img\/icon1.gif\" \/><a href=\"http:\/\/www.yowao.com\" target=\"_blank\">��ַ��ȫ<\/a><\/li>");
document.writeln("<li><img src=\"\/img\/icon3.gif\" \/><a href=\"http:\/\/www.yowao.com\/feedback\" target=\"_blank\">�������<\/a><\/li>");
document.writeln("<li><img src=\"\/img\/icon2.gif\" \/><a href=\"http:\/\/bbs.yowao.com\" target=_blank>������̳<\/a><\/li>");
document.writeln("<\/ul><\/div>")

function copyinfo(txt)
{
	window.clipboardData.setData( 'Text' , txt );
	if(arguments[1]=='1')alert('���Ƴɹ�');
}
function tishi()
{
	alert('����Ŀ������');
}
$=function(vid){return document.getElementById(vid);}