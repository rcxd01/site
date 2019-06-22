document.writeln("<div class=\"topbg\"><div class=\"w950 head1\"><div class=\"flo_l logo\"><a href=\"\/\" target=\"_self\"><img src=\"\/img\/logo.gif\" \/><\/a><\/div>");
document.writeln("<div class=\"flo_r head2\"><div class=\"rcor flo_r\"><ul><li><img src=\"\/img\/icon1.gif\" \/><a href=\"http:\/\/www.yowao.com\" target=\"_blank\">网址大全<\/a><\/li>");
document.writeln("<li><img src=\"\/img\/icon3.gif\" \/><a href=\"http:\/\/www.yowao.com\/feedback\" target=\"_blank\">意见反馈<\/a><\/li>");
document.writeln("<li><img src=\"\/img\/icon2.gif\" \/><a href=\"http:\/\/bbs.yowao.com\" target=_blank>进入论坛<\/a><\/li>");
document.writeln("<\/ul><\/div>")

function copyinfo(txt)
{
	window.clipboardData.setData( 'Text' , txt );
	if(arguments[1]=='1')alert('复制成功');
}
function tishi()
{
	alert('该栏目建设中');
}
$=function(vid){return document.getElementById(vid);}