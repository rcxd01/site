!function(n,t){jQuery.fn[t]=function(n){return n?this.bind("resize",function(i,r,e){var u;return function(){var n=this,t=arguments;u?clearTimeout(u):e&&i.apply(n,t),u=setTimeout(function(){e||i.apply(n,t),u=null},r||100)}}(n)):this.trigger(t)}}(jQuery,"smartresize");