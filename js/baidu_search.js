(function(){var a=T.event,c=T.dom;a.on("search-text-con","click",function(l){var l=a.get(l),k=l.target,f=c.getAttr(k,"search-des");if(f){var d=document.getElementById("search-text-con").getElementsByTagName("li"),j=d.length,h=null;for(var g=0;g<j;g++){h=d[g];if(c.hasClass(h,"selected")){c.removeClass(h,"selected");break}}c.addClass(k.parentNode,"selected");T.g("search-input-word").focus();b(T.g("baidu-search-sub"),f);l.preventDefault()}});function b(e,d){if(d=="tieba"){e.action="http://tieba.baidu.com/f";T.g("search-args").innerHTML='<input type="hidden" name="kw" value="'+e.word.value+'"><input type="hidden" name="sc" value="hao123">'}else{if(d=="img"){e.action="http://image.baidu.com/i";T.g("search-args").innerHTML='<input type="hidden" name="tn" value="baiduimage"><input type="hidden" name="ct" value="201326592"><input type="hidden" name="cl" value="2"><input type="hidden" name="lm" value="-1"><input type="hidden" name="fm" value="hao123">'}else{if(d=="zhidao"){e.action="http://zhidao.baidu.com/q";T.g("search-args").innerHTML='<input type="hidden" name="tn" value="ikaslist"><input type="hidden" name="ct" value="17"><input type="hidden" name="sc" value="hao123"><input type="hidden" name="rn" value="20">'}else{if(d=="web"){e.action="http://www.baidu.com/s";T.g("search-args").innerHTML='<input type="hidden" name="tn" value="sitehao123">'}else{if(d=="mp3"){e.action="http://mp3.baidu.com/m";T.g("search-args").innerHTML='<input type="hidden" name="tn" value="baidump3"><input type="hidden" name="ct" value="134217728"><input type="hidden" name="sc" value="hao123">'}else{if(d=="news"){e.action="http://news.baidu.com/ns";T.g("search-args").innerHTML='<input type="hidden" name="tn" value="news"><input type="hidden" name="sc" value="hao123">'}else{if(d=="video"){e.action="http://video.baidu.com/v";T.g("search-args").innerHTML='<input type="hidden" name="sc" value="hao123">'}}}}}}}return true}})();