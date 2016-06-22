/*
 * Shadowbox.js, version 3.0.3
 * http://shadowbox-js.com/
 *
 * Copyright 2007-2010, Michael J. I. Jackson
 * Date: 2011-05-15 10:29:04 +0000
 */
(function(aw,k){var R={version:"3.0.3"};var L=navigator.userAgent.toLowerCase();if(L.indexOf("windows")>-1||L.indexOf("win32")>-1){R.isWindows=true}else{if(L.indexOf("macintosh")>-1||L.indexOf("mac os x")>-1){R.isMac=true}else{if(L.indexOf("linux")>-1){R.isLinux=true}}}R.isIE=L.indexOf("msie")>-1;R.isIE6=L.indexOf("msie 6")>-1;R.isIE7=L.indexOf("msie 7")>-1;R.isGecko=L.indexOf("gecko")>-1&&L.indexOf("safari")==-1;R.isWebKit=L.indexOf("applewebkit/")>-1;var ad=/#(.+)$/,ah=/^(light|shadow)box\[(.*?)\]/i,aB=/\s*([a-z_]*?)\s*=\s*(.+)\s*/,f=/[0-9a-z]+$/i,aG=/(.+\/)shadowbox\.js/i;var A=false,a=false,l={},z=0,T,ar;R.current=-1;R.dimensions=null;R.ease=function(E){return 1+Math.pow(E-1,3)};R.errorInfo={fla:{name:"Flash",url:"http://www.adobe.com/products/flashplayer/"},qt:{name:"QuickTime",url:"http://www.apple.com/quicktime/download/"},wmp:{name:"Windows Media Player",url:"http://www.microsoft.com/windows/windowsmedia/"},f4m:{name:"Flip4Mac",url:"http://www.flip4mac.com/wmv_download.htm"}};R.gallery=[];R.onReady=al;R.path=null;R.player=null;R.playerId="sb-player";R.options={animate:true,animateFade:true,autoplayMovies:true,continuous:false,enableKeys:true,flashParams:{bgcolor:"#000000",allowfullscreen:true},flashVars:{},flashVersion:"9.0.115",handleOversize:"resize",handleUnsupported:"link",onChange:al,onClose:al,onFinish:al,onOpen:al,showMovieControls:true,skipSetup:false,slideshowDelay:0,viewportPadding:20};R.getCurrent=function(){return R.current>-1?R.gallery[R.current]:null};R.hasNext=function(){return R.gallery.length>1&&(R.current!=R.gallery.length-1||R.options.continuous)};R.isOpen=function(){return A};R.isPaused=function(){return ar=="pause"};R.applyOptions=function(E){l=aE({},R.options);aE(R.options,E)};R.revertOptions=function(){aE(R.options,l)};R.init=function(S,aK){if(a){return}a=true;if(R.skin.options){aE(R.options,R.skin.options)}if(S){aE(R.options,S)}if(!R.path){var aJ,K=document.getElementsByTagName("script");for(var aI=0,E=K.length;aI<E;++aI){aJ=aG.exec(K[aI].src);if(aJ){R.path=aJ[1];break}}}if(aK){R.onReady=aK}Q()};R.open=function(K){if(A){return}var E=R.makeGallery(K);R.gallery=E[0];R.current=E[1];K=R.getCurrent();if(K==null){return}R.applyOptions(K.options||{});H();if(R.gallery.length){K=R.getCurrent();if(R.options.onOpen(K)===false){return}A=true;R.skin.onOpen(K,c)}};R.close=function(){if(!A){return}A=false;if(R.player){R.player.remove();R.player=null}if(typeof ar=="number"){clearTimeout(ar);ar=null}z=0;at(false);R.options.onClose(R.getCurrent());R.skin.onClose();R.revertOptions()};R.play=function(){if(!R.hasNext()){return}if(!z){z=R.options.slideshowDelay*1000}if(z){T=ay();ar=setTimeout(function(){z=T=0;R.next()},z);if(R.skin.onPlay){R.skin.onPlay()}}};R.pause=function(){if(typeof ar!="number"){return}z=Math.max(0,z-(ay()-T));if(z){clearTimeout(ar);ar="pause";if(R.skin.onPause){R.skin.onPause()}}};R.change=function(E){if(!(E in R.gallery)){if(R.options.continuous){E=(E<0?R.gallery.length+E:0);if(!(E in R.gallery)){return}}else{return}}R.current=E;if(typeof ar=="number"){clearTimeout(ar);ar=null;z=T=0}R.options.onChange(R.getCurrent());c(true)};R.next=function(){R.change(R.current+1)};R.previous=function(){R.change(R.current-1)};R.setDimensions=function(aT,aK,aR,aS,aJ,E,aP,aM){var aO=aT,aI=aK;var aN=2*aP+aJ;if(aT+aN>aR){aT=aR-aN}var S=2*aP+E;if(aK+S>aS){aK=aS-S}var K=(aO-aT)/aO,aQ=(aI-aK)/aI,aL=(K>0||aQ>0);if(aM&&aL){if(K>aQ){aK=Math.round((aI/aO)*aT)}else{if(aQ>K){aT=Math.round((aO/aI)*aK)}}}R.dimensions={height:aT+aJ,width:aK+E,innerHeight:aT,innerWidth:aK,top:Math.floor((aR-(aT+aN))/2+aP),left:Math.floor((aS-(aK+S))/2+aP),oversized:aL};return R.dimensions};R.makeGallery=function(aJ){var E=[],aI=-1;if(typeof aJ=="string"){aJ=[aJ]}if(typeof aJ.length=="number"){aH(aJ,function(aL,aM){if(aM.content){E[aL]=aM}else{E[aL]={content:aM}}});aI=0}else{if(aJ.tagName){var K=R.getCache(aJ);aJ=K?K:R.makeObject(aJ)}if(aJ.gallery){E=[];var aK;for(var S in R.cache){aK=R.cache[S];if(aK.gallery&&aK.gallery==aJ.gallery){if(aI==-1&&aK.content==aJ.content){aI=E.length}E.push(aK)}}if(aI==-1){E.unshift(aJ);aI=0}}else{E=[aJ];aI=0}}aH(E,function(aL,aM){E[aL]=aE({},aM)});return[E,aI]};R.makeObject=function(aI,S){var aJ={content:aI.href,title:aI.getAttribute("title")||"",link:aI};if(S){S=aE({},S);aH(["player","title","height","width","gallery"],function(aK,aL){if(typeof S[aL]!="undefined"){aJ[aL]=S[aL];delete S[aL]}});aJ.options=S}else{aJ.options={}}if(!aJ.player){aJ.player=R.getPlayer(aJ.content)}var E=aI.getAttribute("rel");if(E){var K=E.match(ah);if(K){aJ.gallery=escape(K[2])}aH(E.split(";"),function(aK,aL){K=aL.match(aB);if(K){aJ[K[1]]=K[2]}})}return aJ};R.getPlayer=function(S){if(S.indexOf("#")>-1&&S.indexOf(document.location.href)==0){return"inline"}var aI=S.indexOf("?");if(aI>-1){S=S.substring(0,aI)}var K,E=S.match(f);if(E){K=E[0].toLowerCase()}if(K){if(R.img&&R.img.ext.indexOf(K)>-1){return"img"}if(R.swf&&R.swf.ext.indexOf(K)>-1){return"swf"}if(R.flv&&R.flv.ext.indexOf(K)>-1){return"flv"}if(R.qt&&R.qt.ext.indexOf(K)>-1){if(R.wmp&&R.wmp.ext.indexOf(K)>-1){return"qtwmp"}else{return"qt"}}if(R.wmp&&R.wmp.ext.indexOf(K)>-1){return"wmp"}}return"iframe"};function H(){var aI=R.errorInfo,aJ=R.plugins,aL,aM,aP,S,aO,K,aN,E;for(var aK=0;aK<R.gallery.length;++aK){aL=R.gallery[aK];aM=false;aP=null;switch(aL.player){case"flv":case"swf":if(!aJ.fla){aP="fla"}break;case"qt":if(!aJ.qt){aP="qt"}break;case"wmp":if(R.isMac){if(aJ.qt&&aJ.f4m){aL.player="qt"}else{aP="qtf4m"}}else{if(!aJ.wmp){aP="wmp"}}break;case"qtwmp":if(aJ.qt){aL.player="qt"}else{if(aJ.wmp){aL.player="wmp"}else{aP="qtwmp"}}break}if(aP){if(R.options.handleUnsupported=="link"){switch(aP){case"qtf4m":aO="shared";K=[aI.qt.url,aI.qt.name,aI.f4m.url,aI.f4m.name];break;case"qtwmp":aO="either";K=[aI.qt.url,aI.qt.name,aI.wmp.url,aI.wmp.name];break;default:aO="single";K=[aI[aP].url,aI[aP].name]}aL.player="html";aL.content='<div class="sb-message">'+s(R.lang.errors[aO],K)+"</div>"}else{aM=true}}else{if(aL.player=="inline"){S=ad.exec(aL.content);if(S){aN=af(S[1]);if(aN){aL.content=aN.innerHTML}else{aM=true}}else{aM=true}}else{if(aL.player=="swf"||aL.player=="flv"){E=(aL.options&&aL.options.flashVersion)||R.options.flashVersion;if(R.flash&&!R.flash.hasFlashPlayerVersion(E)){aL.width=310;aL.height=177}}}}if(aM){R.gallery.splice(aK,1);if(aK<R.current){--R.current}else{if(aK==R.current){R.current=aK>0?aK-1:aK}}--aK}}}function at(E){if(!R.options.enableKeys){return}(E?G:N)(document,"keydown",ap)}function ap(S){if(S.metaKey||S.shiftKey||S.altKey||S.ctrlKey){return}var K=v(S),E;switch(K){case 81:case 88:case 27:E=R.close;break;case 37:E=R.previous;break;case 39:E=R.next;break;case 32:E=typeof ar=="number"?R.pause:R.play;break}if(E){n(S);E()}}function c(aL){at(false);var aK=R.getCurrent();var S=(aK.player=="inline"?"html":aK.player);if(typeof R[S]!="function"){throw"unknown player "+S}if(aL){R.player.remove();R.revertOptions();R.applyOptions(aK.options||{})}R.player=new R[S](aK,R.playerId);if(R.gallery.length>1){var aI=R.gallery[R.current+1]||R.gallery[0];if(aI.player=="img"){var K=new Image();K.src=aI.content}var aJ=R.gallery[R.current-1]||R.gallery[R.gallery.length-1];if(aJ.player=="img"){var E=new Image();E.src=aJ.content}}R.skin.onLoad(aL,Y)}function Y(){if(!A){return}if(typeof R.player.ready!="undefined"){var E=setInterval(function(){if(A){if(R.player.ready){clearInterval(E);E=null;R.skin.onReady(e)}}else{clearInterval(E);E=null}},10)}else{R.skin.onReady(e)}}function e(){if(!A){return}R.player.append(R.skin.body,R.dimensions);R.skin.onShow(J)}function J(){if(!A){return}if(R.player.onLoad){R.player.onLoad()}R.options.onFinish(R.getCurrent());if(!R.isPaused()){R.play()}at(true)}if(!Array.prototype.indexOf){Array.prototype.indexOf=function(K,S){var E=this.length>>>0;S=S||0;if(S<0){S+=E}for(;S<E;++S){if(S in this&&this[S]===K){return S}}return -1}}function ay(){return(new Date).getTime()}function aE(E,S){for(var K in S){E[K]=S[K]}return E}function aH(aI,aJ){var K=0,E=aI.length;for(var S=aI[0];K<E&&aJ.call(S,K,S)!==false;S=aI[++K]){}}function s(K,E){return K.replace(/\{(\w+?)\}/g,function(S,aI){return E[aI]})}function al(){}function af(E){return document.getElementById(E)}function C(E){E.parentNode.removeChild(E)}var h=true,x=true;function d(){var E=document.body,K=document.createElement("div");h=typeof K.style.opacity==="string";K.style.position="fixed";K.style.margin=0;K.style.top="20px";E.appendChild(K,E.firstChild);x=K.offsetTop==20;E.removeChild(K)}R.getStyle=(function(){var E=/opacity=([^)]*)/,K=document.defaultView&&document.defaultView.getComputedStyle;return function(aK,aJ){var aI;if(!h&&aJ=="opacity"&&aK.currentStyle){aI=E.test(aK.currentStyle.filter||"")?(parseFloat(RegExp.$1)/100)+"":"";return aI===""?"1":aI}if(K){var S=K(aK,null);if(S){aI=S[aJ]}if(aJ=="opacity"&&aI==""){aI="1"}}else{aI=aK.currentStyle[aJ]}return aI}})();R.appendHTML=function(S,K){if(S.insertAdjacentHTML){S.insertAdjacentHTML("BeforeEnd",K)}else{if(S.lastChild){var E=S.ownerDocument.createRange();E.setStartAfter(S.lastChild);var aI=E.createContextualFragment(K);S.appendChild(aI)}else{S.innerHTML=K}}};R.getWindowSize=function(E){if(document.compatMode==="CSS1Compat"){return document.documentElement["client"+E]}return document.body["client"+E]};R.setOpacity=function(S,E){var K=S.style;if(h){K.opacity=(E==1?"":E)}else{K.zoom=1;if(E==1){if(typeof K.filter=="string"&&(/alpha/i).test(K.filter)){K.filter=K.filter.replace(/\s*[\w\.]*alpha\([^\)]*\);?/gi,"")}}else{K.filter=(K.filter||"").replace(/\s*[\w\.]*alpha\([^\)]*\)/gi,"")+" alpha(opacity="+(E*100)+")"}}};R.clearOpacity=function(E){R.setOpacity(E,1)};var W=Event;function o(E){return W.element(E)}function X(E){return[W.pointerX(E),W.pointerY(E)]}function n(E){W.stop(E)}function v(E){return E.keyCode}function G(S,K,E){W.observe(S,K,E)}function N(S,K,E){W.stopObserving(S,K,E)}var y=false,an;if(document.addEventListener){an=function(){document.removeEventListener("DOMContentLoaded",an,false);R.load()}}else{if(document.attachEvent){an=function(){if(document.readyState==="complete"){document.detachEvent("onreadystatechange",an);R.load()}}}}function g(){if(y){return}try{document.documentElement.doScroll("left")}catch(E){setTimeout(g,1);return}R.load()}function Q(){if(document.readyState==="complete"){return R.load()}if(document.addEventListener){document.addEventListener("DOMContentLoaded",an,false);aw.addEventListener("load",R.load,false)}else{if(document.attachEvent){document.attachEvent("onreadystatechange",an);aw.attachEvent("onload",R.load);var E=false;try{E=aw.frameElement===null}catch(K){}if(document.documentElement.doScroll&&E){g()}}}}R.load=function(){if(y){return}if(!document.body){return setTimeout(R.load,13)}y=true;d();R.onReady();if(!R.options.skipSetup){R.setup()}R.skin.init()};R.plugins={};if(navigator.plugins&&navigator.plugins.length){var w=[];aH(navigator.plugins,function(E,K){w.push(K.name)});w=w.join(",");var ak=w.indexOf("Flip4Mac")>-1;R.plugins={fla:w.indexOf("Shockwave Flash")>-1,qt:w.indexOf("QuickTime")>-1,wmp:!ak&&w.indexOf("Windows Media")>-1,f4m:ak}}else{var p=function(E){var K;try{K=new ActiveXObject(E)}catch(S){}return !!K};R.plugins={fla:p("ShockwaveFlash.ShockwaveFlash"),qt:p("QuickTime.QuickTime"),wmp:p("wmplayer.ocx"),f4m:false}}var Z=/^(light|shadow)box/i,ao="shadowboxCacheKey",b=1;R.cache={};R.select=function(K){var S=[];if(!K){var E;aH(document.getElementsByTagName("a"),function(aK,aL){E=aL.getAttribute("rel");if(E&&Z.test(E)){S.push(aL)}})}else{var aJ=K.length;if(aJ){if(typeof K=="string"){if(R.find){S=R.find(K)}}else{if(aJ==2&&typeof K[0]=="string"&&K[1].nodeType){if(R.find){S=R.find(K[0],K[1])}}else{for(var aI=0;aI<aJ;++aI){S[aI]=K[aI]}}}}else{S.push(K)}}return S};R.setup=function(E,K){aH(R.select(E),function(S,aI){R.addCache(aI,K)})};R.teardown=function(E){aH(R.select(E),function(K,S){R.removeCache(S)})};R.addCache=function(S,E){var K=S[ao];if(K==k){K=b++;S[ao]=K;G(S,"click",u)}R.cache[K]=R.makeObject(S,E)};R.removeCache=function(E){N(E,"click",u);delete R.cache[E[ao]];E[ao]=null};R.getCache=function(K){var E=K[ao];return(E in R.cache&&R.cache[E])};R.clearCache=function(){for(var E in R.cache){R.removeCache(R.cache[E].link)}R.cache={}};function u(E){R.open(this);if(R.gallery.length){n(E)}}
/*
 * Sizzle CSS Selector Engine - v1.0
 *  Copyright 2009, The Dojo Foundation
 *  Released under the MIT, BSD, and GPL Licenses.
 *  More information: http://sizzlejs.com/
 *
 * Modified for inclusion in Shadowbox.js
 */
R.find=(function(){var aQ=/((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^[\]]*\]|['"][^'"]*['"]|[^[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,aR=0,aT=Object.prototype.toString,aL=false,aK=true;[0,0].sort(function(){aK=false;return 0});var S=function(a2,aX,a5,a6){a5=a5||[];var a8=aX=aX||document;if(aX.nodeType!==1&&aX.nodeType!==9){return[]}if(!a2||typeof a2!=="string"){return a5}var a3=[],aZ,ba,bd,aY,a1=true,a0=aI(aX),a7=a2;while((aQ.exec(""),aZ=aQ.exec(a7))!==null){a7=aZ[3];a3.push(aZ[1]);if(aZ[2]){aY=aZ[3];break}}if(a3.length>1&&aM.exec(a2)){if(a3.length===2&&aN.relative[a3[0]]){ba=aU(a3[0]+a3[1],aX)}else{ba=aN.relative[a3[0]]?[aX]:S(a3.shift(),aX);while(a3.length){a2=a3.shift();if(aN.relative[a2]){a2+=a3.shift()}ba=aU(a2,ba)}}}else{if(!a6&&a3.length>1&&aX.nodeType===9&&!a0&&aN.match.ID.test(a3[0])&&!aN.match.ID.test(a3[a3.length-1])){var a9=S.find(a3.shift(),aX,a0);aX=a9.expr?S.filter(a9.expr,a9.set)[0]:a9.set[0]}if(aX){var a9=a6?{expr:a3.pop(),set:aP(a6)}:S.find(a3.pop(),a3.length===1&&(a3[0]==="~"||a3[0]==="+")&&aX.parentNode?aX.parentNode:aX,a0);ba=a9.expr?S.filter(a9.expr,a9.set):a9.set;if(a3.length>0){bd=aP(ba)}else{a1=false}while(a3.length){var bc=a3.pop(),bb=bc;if(!aN.relative[bc]){bc=""}else{bb=a3.pop()}if(bb==null){bb=aX}aN.relative[bc](bd,bb,a0)}}else{bd=a3=[]}}if(!bd){bd=ba}if(!bd){throw"Syntax error, unrecognized expression: "+(bc||a2)}if(aT.call(bd)==="[object Array]"){if(!a1){a5.push.apply(a5,bd)}else{if(aX&&aX.nodeType===1){for(var a4=0;bd[a4]!=null;a4++){if(bd[a4]&&(bd[a4]===true||bd[a4].nodeType===1&&aO(aX,bd[a4]))){a5.push(ba[a4])}}}else{for(var a4=0;bd[a4]!=null;a4++){if(bd[a4]&&bd[a4].nodeType===1){a5.push(ba[a4])}}}}}else{aP(bd,a5)}if(aY){S(aY,a8,a5,a6);S.uniqueSort(a5)}return a5};S.uniqueSort=function(aY){if(aS){aL=aK;aY.sort(aS);if(aL){for(var aX=1;aX<aY.length;aX++){if(aY[aX]===aY[aX-1]){aY.splice(aX--,1)}}}}return aY};S.matches=function(aX,aY){return S(aX,null,null,aY)};S.find=function(a4,aX,a5){var a3,a1;if(!a4){return[]}for(var a0=0,aZ=aN.order.length;a0<aZ;a0++){var a2=aN.order[a0],a1;if((a1=aN.leftMatch[a2].exec(a4))){var aY=a1[1];a1.splice(1,1);if(aY.substr(aY.length-1)!=="\\"){a1[1]=(a1[1]||"").replace(/\\/g,"");a3=aN.find[a2](a1,aX,a5);if(a3!=null){a4=a4.replace(aN.match[a2],"");break}}}}if(!a3){a3=aX.getElementsByTagName("*")}return{set:a3,expr:a4}};S.filter=function(a7,a6,ba,a0){var aZ=a7,bc=[],a4=a6,a2,aX,a3=a6&&a6[0]&&aI(a6[0]);while(a7&&a6.length){for(var a5 in aN.filter){if((a2=aN.match[a5].exec(a7))!=null){var aY=aN.filter[a5],bb,a9;aX=false;if(a4===bc){bc=[]}if(aN.preFilter[a5]){a2=aN.preFilter[a5](a2,a4,ba,bc,a0,a3);if(!a2){aX=bb=true}else{if(a2===true){continue}}}if(a2){for(var a1=0;(a9=a4[a1])!=null;a1++){if(a9){bb=aY(a9,a2,a1,a4);var a8=a0^!!bb;if(ba&&bb!=null){if(a8){aX=true}else{a4[a1]=false}}else{if(a8){bc.push(a9);aX=true}}}}}if(bb!==k){if(!ba){a4=bc}a7=a7.replace(aN.match[a5],"");if(!aX){return[]}break}}}if(a7===aZ){if(aX==null){throw"Syntax error, unrecognized expression: "+a7}else{break}}aZ=a7}return a4};var aN=S.selectors={order:["ID","NAME","TAG"],match:{ID:/#((?:[\w\u00c0-\uFFFF-]|\\.)+)/,CLASS:/\.((?:[\w\u00c0-\uFFFF-]|\\.)+)/,NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF-]|\\.)+)['"]*\]/,ATTR:/\[\s*((?:[\w\u00c0-\uFFFF-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,TAG:/^((?:[\w\u00c0-\uFFFF\*-]|\\.)+)/,CHILD:/:(only|nth|last|first)-child(?:\((even|odd|[\dn+-]*)\))?/,POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^-]|$)/,PSEUDO:/:((?:[\w\u00c0-\uFFFF-]|\\.)+)(?:\((['"]*)((?:\([^\)]+\)|[^\2\(\)]*)+)\2\))?/},leftMatch:{},attrMap:{"class":"className","for":"htmlFor"},attrHandle:{href:function(aX){return aX.getAttribute("href")}},relative:{"+":function(a3,aY){var a0=typeof aY==="string",a2=a0&&!/\W/.test(aY),a4=a0&&!a2;if(a2){aY=aY.toLowerCase()}for(var aZ=0,aX=a3.length,a1;aZ<aX;aZ++){if((a1=a3[aZ])){while((a1=a1.previousSibling)&&a1.nodeType!==1){}a3[aZ]=a4||a1&&a1.nodeName.toLowerCase()===aY?a1||false:a1===aY}}if(a4){S.filter(aY,a3,true)}},">":function(a3,aY){var a1=typeof aY==="string";if(a1&&!/\W/.test(aY)){aY=aY.toLowerCase();for(var aZ=0,aX=a3.length;aZ<aX;aZ++){var a2=a3[aZ];if(a2){var a0=a2.parentNode;a3[aZ]=a0.nodeName.toLowerCase()===aY?a0:false}}}else{for(var aZ=0,aX=a3.length;aZ<aX;aZ++){var a2=a3[aZ];if(a2){a3[aZ]=a1?a2.parentNode:a2.parentNode===aY}}if(a1){S.filter(aY,a3,true)}}},"":function(a0,aY,a2){var aZ=aR++,aX=aV;if(typeof aY==="string"&&!/\W/.test(aY)){var a1=aY=aY.toLowerCase();aX=E}aX("parentNode",aY,aZ,a0,a1,a2)},"~":function(a0,aY,a2){var aZ=aR++,aX=aV;if(typeof aY==="string"&&!/\W/.test(aY)){var a1=aY=aY.toLowerCase();aX=E}aX("previousSibling",aY,aZ,a0,a1,a2)}},find:{ID:function(aY,aZ,a0){if(typeof aZ.getElementById!=="undefined"&&!a0){var aX=aZ.getElementById(aY[1]);return aX?[aX]:[]}},NAME:function(aZ,a2){if(typeof a2.getElementsByName!=="undefined"){var aY=[],a1=a2.getElementsByName(aZ[1]);for(var a0=0,aX=a1.length;a0<aX;a0++){if(a1[a0].getAttribute("name")===aZ[1]){aY.push(a1[a0])}}return aY.length===0?null:aY}},TAG:function(aX,aY){return aY.getElementsByTagName(aX[1])}},preFilter:{CLASS:function(a0,aY,aZ,aX,a3,a4){a0=" "+a0[1].replace(/\\/g,"")+" ";if(a4){return a0}for(var a1=0,a2;(a2=aY[a1])!=null;a1++){if(a2){if(a3^(a2.className&&(" "+a2.className+" ").replace(/[\t\n]/g," ").indexOf(a0)>=0)){if(!aZ){aX.push(a2)}}else{if(aZ){aY[a1]=false}}}}return false},ID:function(aX){return aX[1].replace(/\\/g,"")},TAG:function(aY,aX){return aY[1].toLowerCase()},CHILD:function(aX){if(aX[1]==="nth"){var aY=/(-?)(\d*)n((?:\+|-)?\d*)/.exec(aX[2]==="even"&&"2n"||aX[2]==="odd"&&"2n+1"||!/\D/.test(aX[2])&&"0n+"+aX[2]||aX[2]);aX[2]=(aY[1]+(aY[2]||1))-0;aX[3]=aY[3]-0}aX[0]=aR++;return aX},ATTR:function(a1,aY,aZ,aX,a2,a3){var a0=a1[1].replace(/\\/g,"");if(!a3&&aN.attrMap[a0]){a1[1]=aN.attrMap[a0]}if(a1[2]==="~="){a1[4]=" "+a1[4]+" "}return a1},PSEUDO:function(a1,aY,aZ,aX,a2){if(a1[1]==="not"){if((aQ.exec(a1[3])||"").length>1||/^\w/.test(a1[3])){a1[3]=S(a1[3],null,null,aY)}else{var a0=S.filter(a1[3],aY,aZ,true^a2);if(!aZ){aX.push.apply(aX,a0)}return false}}else{if(aN.match.POS.test(a1[0])||aN.match.CHILD.test(a1[0])){return true}}return a1},POS:function(aX){aX.unshift(true);return aX}},filters:{enabled:function(aX){return aX.disabled===false&&aX.type!=="hidden"},disabled:function(aX){return aX.disabled===true},checked:function(aX){return aX.checked===true},selected:function(aX){aX.parentNode.selectedIndex;return aX.selected===true},parent:function(aX){return !!aX.firstChild},empty:function(aX){return !aX.firstChild},has:function(aZ,aY,aX){return !!S(aX[3],aZ).length},header:function(aX){return/h\d/i.test(aX.nodeName)},text:function(aX){return"text"===aX.type},radio:function(aX){return"radio"===aX.type},checkbox:function(aX){return"checkbox"===aX.type},file:function(aX){return"file"===aX.type},password:function(aX){return"password"===aX.type},submit:function(aX){return"submit"===aX.type},image:function(aX){return"image"===aX.type},reset:function(aX){return"reset"===aX.type},button:function(aX){return"button"===aX.type||aX.nodeName.toLowerCase()==="button"},input:function(aX){return/input|select|textarea|button/i.test(aX.nodeName)}},setFilters:{first:function(aY,aX){return aX===0},last:function(aZ,aY,aX,a0){return aY===a0.length-1},even:function(aY,aX){return aX%2===0},odd:function(aY,aX){return aX%2===1},lt:function(aZ,aY,aX){return aY<aX[3]-0},gt:function(aZ,aY,aX){return aY>aX[3]-0},nth:function(aZ,aY,aX){return aX[3]-0===aY},eq:function(aZ,aY,aX){return aX[3]-0===aY}},filter:{PSEUDO:function(a3,aZ,a0,a4){var aY=aZ[1],a1=aN.filters[aY];if(a1){return a1(a3,a0,aZ,a4)}else{if(aY==="contains"){return(a3.textContent||a3.innerText||K([a3])||"").indexOf(aZ[3])>=0}else{if(aY==="not"){var a2=aZ[3];for(var a0=0,aX=a2.length;a0<aX;a0++){if(a2[a0]===a3){return false}}return true}else{throw"Syntax error, unrecognized expression: "+aY}}}},CHILD:function(aX,a0){var a3=a0[1],aY=aX;switch(a3){case"only":case"first":while((aY=aY.previousSibling)){if(aY.nodeType===1){return false}}if(a3==="first"){return true}aY=aX;case"last":while((aY=aY.nextSibling)){if(aY.nodeType===1){return false}}return true;case"nth":var aZ=a0[2],a6=a0[3];if(aZ===1&&a6===0){return true}var a2=a0[0],a5=aX.parentNode;if(a5&&(a5.sizcache!==a2||!aX.nodeIndex)){var a1=0;for(aY=a5.firstChild;aY;aY=aY.nextSibling){if(aY.nodeType===1){aY.nodeIndex=++a1}}a5.sizcache=a2}var a4=aX.nodeIndex-a6;if(aZ===0){return a4===0}else{return(a4%aZ===0&&a4/aZ>=0)}}},ID:function(aY,aX){return aY.nodeType===1&&aY.getAttribute("id")===aX},TAG:function(aY,aX){return(aX==="*"&&aY.nodeType===1)||aY.nodeName.toLowerCase()===aX},CLASS:function(aY,aX){return(" "+(aY.className||aY.getAttribute("class"))+" ").indexOf(aX)>-1},ATTR:function(a2,a0){var aZ=a0[1],aX=aN.attrHandle[aZ]?aN.attrHandle[aZ](a2):a2[aZ]!=null?a2[aZ]:a2.getAttribute(aZ),a3=aX+"",a1=a0[2],aY=a0[4];return aX==null?a1==="!=":a1==="="?a3===aY:a1==="*="?a3.indexOf(aY)>=0:a1==="~="?(" "+a3+" ").indexOf(aY)>=0:!aY?a3&&aX!==false:a1==="!="?a3!==aY:a1==="^="?a3.indexOf(aY)===0:a1==="$="?a3.substr(a3.length-aY.length)===aY:a1==="|="?a3===aY||a3.substr(0,aY.length+1)===aY+"-":false},POS:function(a1,aY,aZ,a2){var aX=aY[2],a0=aN.setFilters[aX];if(a0){return a0(a1,aZ,aY,a2)}}}};var aM=aN.match.POS;for(var aJ in aN.match){aN.match[aJ]=new RegExp(aN.match[aJ].source+/(?![^\[]*\])(?![^\(]*\))/.source);aN.leftMatch[aJ]=new RegExp(/(^(?:.|\r|\n)*?)/.source+aN.match[aJ].source)}var aP=function(aY,aX){aY=Array.prototype.slice.call(aY,0);if(aX){aX.push.apply(aX,aY);return aX}return aY};try{Array.prototype.slice.call(document.documentElement.childNodes,0)}catch(aW){aP=function(a1,a0){var aY=a0||[];if(aT.call(a1)==="[object Array]"){Array.prototype.push.apply(aY,a1)}else{if(typeof a1.length==="number"){for(var aZ=0,aX=a1.length;aZ<aX;aZ++){aY.push(a1[aZ])}}else{for(var aZ=0;a1[aZ];aZ++){aY.push(a1[aZ])}}}return aY}}var aS;if(document.documentElement.compareDocumentPosition){aS=function(aY,aX){if(!aY.compareDocumentPosition||!aX.compareDocumentPosition){if(aY==aX){aL=true}return aY.compareDocumentPosition?-1:1}var aZ=aY.compareDocumentPosition(aX)&4?-1:aY===aX?0:1;if(aZ===0){aL=true}return aZ}}else{if("sourceIndex" in document.documentElement){aS=function(aY,aX){if(!aY.sourceIndex||!aX.sourceIndex){if(aY==aX){aL=true}return aY.sourceIndex?-1:1}var aZ=aY.sourceIndex-aX.sourceIndex;if(aZ===0){aL=true}return aZ}}else{if(document.createRange){aS=function(a0,aY){if(!a0.ownerDocument||!aY.ownerDocument){if(a0==aY){aL=true}return a0.ownerDocument?-1:1}var aZ=a0.ownerDocument.createRange(),aX=aY.ownerDocument.createRange();aZ.setStart(a0,0);aZ.setEnd(a0,0);aX.setStart(aY,0);aX.setEnd(aY,0);var a1=aZ.compareBoundaryPoints(Range.START_TO_END,aX);if(a1===0){aL=true}return a1}}}}function K(aX){var aY="",a0;for(var aZ=0;aX[aZ];aZ++){a0=aX[aZ];if(a0.nodeType===3||a0.nodeType===4){aY+=a0.nodeValue}else{if(a0.nodeType!==8){aY+=K(a0.childNodes)}}}return aY}(function(){var aY=document.createElement("div"),aZ="script"+(new Date).getTime();aY.innerHTML="<a name='"+aZ+"'/>";var aX=document.documentElement;aX.insertBefore(aY,aX.firstChild);if(document.getElementById(aZ)){aN.find.ID=function(a1,a2,a3){if(typeof a2.getElementById!=="undefined"&&!a3){var a0=a2.getElementById(a1[1]);return a0?a0.id===a1[1]||typeof a0.getAttributeNode!=="undefined"&&a0.getAttributeNode("id").nodeValue===a1[1]?[a0]:k:[]}};aN.filter.ID=function(a2,a0){var a1=typeof a2.getAttributeNode!=="undefined"&&a2.getAttributeNode("id");return a2.nodeType===1&&a1&&a1.nodeValue===a0}}aX.removeChild(aY);aX=aY=null})();(function(){var aX=document.createElement("div");aX.appendChild(document.createComment(""));if(aX.getElementsByTagName("*").length>0){aN.find.TAG=function(aY,a2){var a1=a2.getElementsByTagName(aY[1]);if(aY[1]==="*"){var a0=[];for(var aZ=0;a1[aZ];aZ++){if(a1[aZ].nodeType===1){a0.push(a1[aZ])}}a1=a0}return a1}}aX.innerHTML="<a href='#'></a>";if(aX.firstChild&&typeof aX.firstChild.getAttribute!=="undefined"&&aX.firstChild.getAttribute("href")!=="#"){aN.attrHandle.href=function(aY){return aY.getAttribute("href",2)}}aX=null})();if(document.querySelectorAll){(function(){var aX=S,aZ=document.createElement("div");aZ.innerHTML="<p class='TEST'></p>";if(aZ.querySelectorAll&&aZ.querySelectorAll(".TEST").length===0){return}S=function(a3,a2,a0,a1){a2=a2||document;if(!a1&&a2.nodeType===9&&!aI(a2)){try{return aP(a2.querySelectorAll(a3),a0)}catch(a4){}}return aX(a3,a2,a0,a1)};for(var aY in aX){S[aY]=aX[aY]}aZ=null})()}(function(){var aX=document.createElement("div");aX.innerHTML="<div class='test e'></div><div class='test'></div>";if(!aX.getElementsByClassName||aX.getElementsByClassName("e").length===0){return}aX.lastChild.className="e";if(aX.getElementsByClassName("e").length===1){return}aN.order.splice(1,0,"CLASS");aN.find.CLASS=function(aY,aZ,a0){if(typeof aZ.getElementsByClassName!=="undefined"&&!a0){return aZ.getElementsByClassName(aY[1])}};aX=null})();function E(aY,a3,a2,a6,a4,a5){for(var a0=0,aZ=a6.length;a0<aZ;a0++){var aX=a6[a0];if(aX){aX=aX[aY];var a1=false;while(aX){if(aX.sizcache===a2){a1=a6[aX.sizset];break}if(aX.nodeType===1&&!a5){aX.sizcache=a2;aX.sizset=a0}if(aX.nodeName.toLowerCase()===a3){a1=aX;break}aX=aX[aY]}a6[a0]=a1}}}function aV(aY,a3,a2,a6,a4,a5){for(var a0=0,aZ=a6.length;a0<aZ;a0++){var aX=a6[a0];if(aX){aX=aX[aY];var a1=false;while(aX){if(aX.sizcache===a2){a1=a6[aX.sizset];break}if(aX.nodeType===1){if(!a5){aX.sizcache=a2;aX.sizset=a0}if(typeof a3!=="string"){if(aX===a3){a1=true;break}}else{if(S.filter(a3,[aX]).length>0){a1=aX;break}}}aX=aX[aY]}a6[a0]=a1}}}var aO=document.compareDocumentPosition?function(aY,aX){return aY.compareDocumentPosition(aX)&16}:function(aY,aX){return aY!==aX&&(aY.contains?aY.contains(aX):true)};var aI=function(aX){var aY=(aX?aX.ownerDocument||aX:0).documentElement;return aY?aY.nodeName!=="HTML":false};var aU=function(aX,a4){var a0=[],a1="",a2,aZ=a4.nodeType?[a4]:a4;while((a2=aN.match.PSEUDO.exec(aX))){a1+=a2[0];aX=aX.replace(aN.match.PSEUDO,"")}aX=aN.relative[aX]?aX+"*":aX;for(var a3=0,aY=aZ.length;a3<aY;a3++){S(aX,aZ[a3],a0)}return S.filter(a1,a0)};return S})();R.lang={code:"en",of:"of",loading:"loading",cancel:"Cancel",next:"Next",previous:"Previous",play:"Play",pause:"Pause",close:"Close",errors:{single:'You must install the <a href="{0}">{1}</a> browser plugin to view this content.',shared:'You must install both the <a href="{0}">{1}</a> and <a href="{2}">{3}</a> browser plugins to view this content.',either:'You must install either the <a href="{0}">{1}</a> or the <a href="{2}">{3}</a> browser plugin to view this content.'}};var D,av="sb-drag-proxy",F,j,ai;function az(){F={x:0,y:0,startX:null,startY:null}}function aC(){var E=R.dimensions;aE(j.style,{height:E.innerHeight+"px",width:E.innerWidth+"px"})}function P(){az();var E=["position:absolute","cursor:"+(R.isGecko?"-moz-grab":"move"),"background-color:"+(R.isIE?"#fff;filter:alpha(opacity=0)":"transparent")].join(";");R.appendHTML(R.skin.body,'<div id="'+av+'" style="'+E+'"></div>');j=af(av);aC();G(j,"mousedown",M)}function B(){if(j){N(j,"mousedown",M);C(j);j=null}ai=null}function M(K){n(K);var E=X(K);F.startX=E[0];F.startY=E[1];ai=af(R.player.id);G(document,"mousemove",I);G(document,"mouseup",i);if(R.isGecko){j.style.cursor="-moz-grabbing"}}function I(aJ){var E=R.player,aK=R.dimensions,aI=X(aJ);var S=aI[0]-F.startX;F.startX+=S;F.x=Math.max(Math.min(0,F.x+S),aK.innerWidth-E.width);var K=aI[1]-F.startY;F.startY+=K;F.y=Math.max(Math.min(0,F.y+K),aK.innerHeight-E.height);aE(ai.style,{left:F.x+"px",top:F.y+"px"})}function i(){N(document,"mousemove",I);N(document,"mouseup",i);if(R.isGecko){j.style.cursor="-moz-grab"}}R.img=function(K,S){this.obj=K;this.id=S;this.ready=false;var E=this;D=new Image();D.onload=function(){E.height=K.height?parseInt(K.height,10):D.height;E.width=K.width?parseInt(K.width,10):D.width;E.ready=true;D.onload=null;D=null};D.src=K.content};R.img.ext=["bmp","gif","jpg","jpeg","png"];R.img.prototype={append:function(K,aJ){var S=document.createElement("img");S.id=this.id;S.src=this.obj.content;S.style.position="absolute";var E,aI;if(aJ.oversized&&R.options.handleOversize=="resize"){E=aJ.innerHeight;aI=aJ.innerWidth}else{E=this.height;aI=this.width}S.setAttribute("height",E);S.setAttribute("width",aI);K.appendChild(S)},remove:function(){var E=af(this.id);if(E){C(E)}B();if(D){D.onload=null;D=null}},onLoad:function(){var E=R.dimensions;if(E.oversized&&R.options.handleOversize=="drag"){P()}},onWindowResize:function(){var aI=R.dimensions;switch(R.options.handleOversize){case"resize":var E=af(this.id);E.height=aI.innerHeight;E.width=aI.innerWidth;break;case"drag":if(ai){var S=parseInt(R.getStyle(ai,"top")),K=parseInt(R.getStyle(ai,"left"));if(S+this.height<aI.innerHeight){ai.style.top=aI.innerHeight-this.height+"px"}if(K+this.width<aI.innerWidth){ai.style.left=aI.innerWidth-this.width+"px"}aC()}break}}};R.iframe=function(K,S){this.obj=K;this.id=S;var E=af("sb-overlay");this.height=K.height?parseInt(K.height,10):E.offsetHeight;this.width=K.width?parseInt(K.width,10):E.offsetWidth};R.iframe.prototype={append:function(E,S){var K='<iframe id="'+this.id+'" name="'+this.id+'" height="100%" width="100%" frameborder="0" marginwidth="0" marginheight="0" style="visibility:hidden" onload="this.style.visibility=\'visible\'" scrolling="auto"';if(R.isIE){K+=' allowtransparency="true"';if(R.isIE6){K+=" src=\"javascript:false;document.write('');\""}}K+="></iframe>";E.innerHTML=K},remove:function(){var E=af(this.id);if(E){C(E);if(R.isGecko){delete aw.frames[this.id]}}},onLoad:function(){var E=R.isIE?af(this.id).contentWindow:aw.frames[this.id];E.location.href=this.obj.content}};R.html=function(E,K){this.obj=E;this.id=K;this.height=E.height?parseInt(E.height,10):300;this.width=E.width?parseInt(E.width,10):500};R.html.prototype={append:function(E,K){var S=document.createElement("div");S.id=this.id;S.className="html";S.innerHTML=this.obj.content;E.appendChild(S)},remove:function(){var E=af(this.id);if(E){C(E)}}};var aq=false,aa=[],q=["sb-nav-close","sb-nav-next","sb-nav-play","sb-nav-pause","sb-nav-previous"],ac,ag,ab,m=true;function O(S,aR,aO,aM,aS){var E=(aR=="opacity"),aN=E?R.setOpacity:function(aT,aU){aT.style[aR]=""+aU+"px"};if(aM==0||(!E&&!R.options.animate)||(E&&!R.options.animateFade)){aN(S,aO);if(aS){aS()}return}var aP=parseFloat(R.getStyle(S,aR))||0;var aQ=aO-aP;if(aQ==0){if(aS){aS()}return}aM*=1000;var aI=ay(),aL=R.ease,aK=aI+aM,aJ;var K=setInterval(function(){aJ=ay();if(aJ>=aK){clearInterval(K);K=null;aN(S,aO);if(aS){aS()}}else{aN(S,aP+aL((aJ-aI)/aM)*aQ)}},10)}function aD(){ac.style.height=R.getWindowSize("Height")+"px";ac.style.width=R.getWindowSize("Width")+"px"}function aF(){ac.style.top=document.documentElement.scrollTop+"px";ac.style.left=document.documentElement.scrollLeft+"px"}function aA(E){if(E){aH(aa,function(K,S){S[0].style.visibility=S[1]||""})}else{aa=[];aH(R.options.troubleElements,function(S,K){aH(document.getElementsByTagName(K),function(aI,aJ){aa.push([aJ,aJ.style.visibility]);aJ.style.visibility="hidden"})})}}function r(S,E){var K=af("sb-nav-"+S);if(K){K.style.display=E?"":"none"}}function aj(E,aK){var aJ=af("sb-loading"),S=R.getCurrent().player,aI=(S=="img"||S=="html");if(E){R.setOpacity(aJ,0);aJ.style.display="block";var K=function(){R.clearOpacity(aJ);if(aK){aK()}};if(aI){O(aJ,"opacity",1,R.options.fadeDuration,K)}else{K()}}else{var K=function(){aJ.style.display="none";R.clearOpacity(aJ);if(aK){aK()}};if(aI){O(aJ,"opacity",0,R.options.fadeDuration,K)}else{K()}}}function t(aP){var aK=R.getCurrent();af("sb-title-inner").innerHTML=aK.title||"";var aQ,aM,K,aR,aN;if(R.options.displayNav){aQ=true;var aO=R.gallery.length;if(aO>1){if(R.options.continuous){aM=aN=true}else{aM=(aO-1)>R.current;aN=R.current>0}}if(R.options.slideshowDelay>0&&R.hasNext()){aR=!R.isPaused();K=!aR}}else{aQ=aM=K=aR=aN=false}r("close",aQ);r("next",aM);r("play",K);r("pause",aR);r("previous",aN);var E="";if(R.options.displayCounter&&R.gallery.length>1){var aO=R.gallery.length;if(R.options.counterType=="skip"){var aJ=0,aI=aO,S=parseInt(R.options.counterLimit)||0;if(S<aO&&S>2){var aL=Math.floor(S/2);aJ=R.current-aL;if(aJ<0){aJ+=aO}aI=R.current+(S-aL);if(aI>aO){aI-=aO}}while(aJ!=aI){if(aJ==aO){aJ=0}E+='<a onclick="Shadowbox.change('+aJ+');"';if(aJ==R.current){E+=' class="sb-counter-current"'}E+=">"+(++aJ)+"</a>"}}else{E=[R.current+1,R.lang.of,aO].join(" ")}}af("sb-counter").innerHTML=E;aP()}function V(aI){var E=af("sb-title-inner"),S=af("sb-info-inner"),K=0.35;E.style.visibility=S.style.visibility="";if(E.innerHTML!=""){O(E,"marginTop",0,K)}O(S,"marginTop",0,K,aI)}function ax(S,aN){var aL=af("sb-title"),E=af("sb-info"),aI=aL.offsetHeight,aJ=E.offsetHeight,aK=af("sb-title-inner"),aM=af("sb-info-inner"),K=(S?0.35:0);O(aK,"marginTop",aI,K);O(aM,"marginTop",aJ*-1,K,function(){aK.style.visibility=aM.style.visibility="hidden";aN()})}function ae(E,aI,K,aK){var aJ=af("sb-wrapper-inner"),S=(K?R.options.resizeDuration:0);O(ab,"top",aI,S);O(aJ,"height",E,S,aK)}function au(E,aI,K,aJ){var S=(K?R.options.resizeDuration:0);O(ab,"left",aI,S);O(ab,"width",E,S,aJ)}function am(aN,S){var aJ=af("sb-body-inner"),aN=parseInt(aN),S=parseInt(S),K=ab.offsetHeight-aJ.offsetHeight,E=ab.offsetWidth-aJ.offsetWidth,aL=ag.offsetHeight,aM=ag.offsetWidth,aK=parseInt(R.options.viewportPadding)||20,aI=(R.player&&R.options.handleOversize!="drag");return R.setDimensions(aN,S,aL,aM,K,E,aK,aI)}var U={};U.markup='<div id="sb-container"><div id="sb-overlay"></div><div id="sb-wrapper"><div id="sb-title"><div id="sb-title-inner"></div></div><div id="sb-wrapper-inner"><div id="sb-body"><div id="sb-body-inner"></div><div id="sb-loading"><div id="sb-loading-inner"><span>{loading}</span></div></div></div></div><div id="sb-info"><div id="sb-info-inner"><div id="sb-counter"></div><div id="sb-nav"><a id="sb-nav-close" title="{close}" onclick="Shadowbox.close()"></a><a id="sb-nav-next" title="{next}" onclick="Shadowbox.next()"></a><a id="sb-nav-play" title="{play}" onclick="Shadowbox.play()"></a><a id="sb-nav-pause" title="{pause}" onclick="Shadowbox.pause()"></a><a id="sb-nav-previous" title="{previous}" onclick="Shadowbox.previous()"></a></div></div></div></div></div>';U.options={animSequence:"sync",counterLimit:10,counterType:"default",displayCounter:true,displayNav:true,fadeDuration:0.35,initialHeight:160,initialWidth:320,modal:false,overlayColor:"#000",overlayOpacity:0.5,resizeDuration:0.35,showOverlay:true,troubleElements:["select","object","embed","canvas"]};U.init=function(){R.appendHTML(document.body,s(U.markup,R.lang));U.body=af("sb-body-inner");ac=af("sb-container");ag=af("sb-overlay");ab=af("sb-wrapper");if(!x){ac.style.position="absolute"}if(!h){var S,E,K=/url\("(.*\.png)"\)/;aH(q,function(aJ,aK){S=af(aK);if(S){E=R.getStyle(S,"backgroundImage").match(K);if(E){S.style.backgroundImage="none";S.style.filter="progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true,src="+E[1]+",sizingMethod=scale);"}}})}var aI;G(aw,"resize",function(){if(aI){clearTimeout(aI);aI=null}if(A){aI=setTimeout(U.onWindowResize,10)}})};U.onOpen=function(E,S){m=false;ac.style.display="block";aD();var K=am(R.options.initialHeight,R.options.initialWidth);ae(K.innerHeight,K.top);au(K.width,K.left);if(R.options.showOverlay){ag.style.backgroundColor=R.options.overlayColor;R.setOpacity(ag,0);if(!R.options.modal){G(ag,"click",R.close)}aq=true}if(!x){aF();G(aw,"scroll",aF)}aA();ac.style.visibility="visible";if(aq){O(ag,"opacity",R.options.overlayOpacity,R.options.fadeDuration,S)}else{S()}};U.onLoad=function(K,E){aj(true);while(U.body.firstChild){C(U.body.firstChild)}ax(K,function(){if(!A){return}if(!K){ab.style.visibility="visible"}t(E)})};U.onReady=function(aI){if(!A){return}var K=R.player,S=am(K.height,K.width);var E=function(){V(aI)};switch(R.options.animSequence){case"hw":ae(S.innerHeight,S.top,true,function(){au(S.width,S.left,true,E)});break;case"wh":au(S.width,S.left,true,function(){ae(S.innerHeight,S.top,true,E)});break;default:au(S.width,S.left,true);ae(S.innerHeight,S.top,true,E)}};U.onShow=function(E){aj(false,E);m=true};U.onClose=function(){if(!x){N(aw,"scroll",aF)}N(ag,"click",R.close);ab.style.visibility="hidden";var E=function(){ac.style.visibility="hidden";ac.style.display="none";aA(true)};if(aq){O(ag,"opacity",0,R.options.fadeDuration,E)}else{E()}};U.onPlay=function(){r("play",false);r("pause",true)};U.onPause=function(){r("pause",false);r("play",true)};U.onWindowResize=function(){if(!m){return}aD();var E=R.player,K=am(E.height,E.width);au(K.width,K.left);ae(K.innerHeight,K.top);if(E.onWindowResize){E.onWindowResize()}};R.skin=U;aw.Shadowbox=R})(window);