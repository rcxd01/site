//window.onerror=function(){return true;};
String.prototype.ltrim=function()
{
	return this.replace(/^\s+/,"");
}
String.prototype.rtrim=function()
{
	return this.replace(/\s+$/,"");
}
String.prototype.trim=function()
{
	return this.ltrim().rtrim();
}
Url=
{
	get:function(name)
	{
		var url=document.location.href;
		var index=url.indexOf('?');
		var urls=null;
		if(index>-1)
		{
			url=url.substr(index+1);
			if(url.indexOf('&')>-1)
			{
				urls=url.split('&');
				for(var i=0;i<urls.length;i++)
				{
					if(urls[i].indexOf(name+'=')>-1)
					{
						return urls[i].substr(urls[i].indexOf('=')+1);
					}
				}
			}
			else
			{
				if(url.indexOf(name+'=')>-1)
				{
					return url.substr(url.indexOf('=')+1);
				}
			}
		}
	}
}
Cookie=
{
	set:function(name,value)
	{
		if(value==null||value=="")
		{
			Cookie.del(name);
		}
		else
		{
			var expdate = new Date();
			var argv = Cookie.set.arguments;
			var argc = Cookie.set.arguments.length;
			var expires = (argc > 2) ? argv[2] : null;
			var path = (argc > 3) ? argv[3] : null;
			var domain = (argc > 4) ? argv[4] : null;
			var secure = (argc > 5) ? argv[5] : false;
			if(expires!=null) expdate.setTime(expdate.getTime() + ( expires * 1000 ))
			document.cookie = name + "=" + escape (value) +((expires == null) ? "" : ("; expires="+ expdate.toGMTString()))
			+((path == null) ? "" : ("; path=" + path)) +((domain == null) ? "" : ("; domain=" + domain))
			+((secure == true) ? "; secure" : "");
		}
	},
	get:function(name)
	{
		try
		{
			var Cookie=document.cookie.split(';');
			var cLen=Cookie.length;
			for(var i=0;i<cLen;i++)
			{
				var temp=Cookie[i].split('=');
				if(temp[0].trim()==name.trim())
				{
					return unescape(temp[1].trim());
				}
			}
		}
		catch(e){}
		return null;
	},
	del:function(name)
	{
		var exp = new Date();
		exp.setTime (exp.getTime() - 1);
		var cval = Cookie.get(name);
		document.cookie = name + "=" + cval + "; expires="+ exp.toGMTString();
	},
	getAll:function()
	{
		var Cookies=null;
		try
		{
			Cookies=document.cookie.split(';');
		}
		catch(e){}
		return Cookies;
	},
	delAll:function()
	{
		try
		{
			var reg=/; expires=[^;]/
			document.cookie=document.cookie.replace(reg,';expires='+(new Date).setTime((new Date()).getTime()-1).toString());
		}
		catch(e){}
		return null;
	}
}

_$=window._$=function(str)
{
	if(typeof(str)=='object')
	{
		return str;
	}
	else
	{
		return document.getElementById(str);
	}
}
$=window.$=function(str){return new _$(str);};
var HTML={};
HTML.loadJs=function(file)
{
	var funExec=HTML.loadJs.arguments[1];
	var funcLoading=HTML.loadJs.arguments[2];
	var parent=document.getElementsByTagName('head')[0];var script=document.createElement('SCRIPT');script.setAttribute('type', 'text/javascript');
	script.setAttribute('src', file);parent.appendChild(script);
	script.onreadystatechange =  function (){
	if(typeof(funExec)=='function'){if(script.readyState == 'complete' || script.readyState =="loaded"){funExec()}}
	if(script.readyState == 'loading'&&typeof(funcLoading)=='function'){funcLoading()}
	};
	script.onload = function (){(typeof(funExec)=='function')?funExec():""};
	return script;
}

HTML.IE=function()
{
	var v=navigator.appVersion;
	var n=navigator.appName;
	if(v.indexOf('MSIE 7.0')>-1)
	{
		n='IE7';
	}
	else if(v.indexOf('MSIE 6.0')>-1)
	{
		n='IE6';
	}
	else if(v.indexOf('MSIE 8.0')>-1)
	{
		n='IE8';
	}
	else if(n.indexOf('Netscape')>-1)
	{
		n='FF';
	}
	else
	{
		n='';
	}
	return n;
}