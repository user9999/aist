var persisteduls=new Object()
var ddtreemenu=new Object()
ddtreemenu.closefolder="closed.gif"
ddtreemenu.openfolder="open.gif"
ddtreemenu.createTree=function(treeid,enablepersist,persistdays){var ultags=document.getElementById(treeid).getElementsByTagName("ul")
if(typeof persisteduls[treeid]=="undefined")
persisteduls[treeid]=(enablepersist==true&&ddtreemenu.getCookie(treeid)!="")?ddtreemenu.getCookie(treeid).split(","):""
for(var i=0;i<ultags.length;i++)
ddtreemenu.buildSubTree(treeid,ultags[i],i)
if(enablepersist==true){var durationdays=(typeof persistdays=="undefined")?1:parseInt(persistdays)
ddtreemenu.dotask(window,function(){ddtreemenu.rememberstate(treeid,durationdays)},"unload")}}
ddtreemenu.buildSubTree=function(treeid,ulelement,index){ulelement.parentNode.className="submenu"
if(typeof persisteduls[treeid]=="object"){if(ddtreemenu.searcharray(persisteduls[treeid],index)){ulelement.setAttribute("rel","open")
ulelement.style.display="block"
ulelement.parentNode.style.backgroundImage="url("+ddtreemenu.openfolder+")"}
else
ulelement.setAttribute("rel","closed")}
else if(ulelement.getAttribute("rel")==null||ulelement.getAttribute("rel")==false)
ulelement.setAttribute("rel","closed")
else if(ulelement.getAttribute("rel")=="open")
ddtreemenu.expandSubTree(treeid,ulelement)
ulelement.parentNode.onclick=function(e){var submenu=this.getElementsByTagName("ul")[0]
if(submenu.getAttribute("rel")=="closed"){submenu.style.display="block"
submenu.setAttribute("rel","open")
ulelement.parentNode.style.backgroundImage="url("+ddtreemenu.openfolder+")"}
else if(submenu.getAttribute("rel")=="open"){submenu.style.display="none"
submenu.setAttribute("rel","closed")
ulelement.parentNode.style.backgroundImage="url("+ddtreemenu.closefolder+")"}
ddtreemenu.preventpropagate(e)}
ulelement.onclick=function(e){ddtreemenu.preventpropagate(e)}}
ddtreemenu.expandSubTree=function(treeid,ulelement){var rootnode=document.getElementById(treeid)
var currentnode=ulelement
currentnode.style.display="block"
currentnode.parentNode.style.backgroundImage="url("+ddtreemenu.openfolder+")"
while(currentnode!=rootnode){if(currentnode.tagName=="UL"){currentnode.style.display="block"
currentnode.setAttribute("rel","open")
currentnode.parentNode.style.backgroundImage="url("+ddtreemenu.openfolder+")"}
currentnode=currentnode.parentNode}}
ddtreemenu.flatten=function(treeid,action){var ultags=document.getElementById(treeid).getElementsByTagName("ul")
for(var i=0;i<ultags.length;i++){ultags[i].style.display=(action=="expand")?"block":"none"
var relvalue=(action=="expand")?"open":"closed"
ultags[i].setAttribute("rel",relvalue)
ultags[i].parentNode.style.backgroundImage=(action=="expand")?"url("+ddtreemenu.openfolder+")":"url("+ddtreemenu.closefolder+")"}}
ddtreemenu.rememberstate=function(treeid,durationdays){var ultags=document.getElementById(treeid).getElementsByTagName("ul")
var openuls=new Array()
for(var i=0;i<ultags.length;i++){if(ultags[i].getAttribute("rel")=="open")
openuls[openuls.length]=i}
if(openuls.length==0)
openuls[0]="none open"
ddtreemenu.setCookie(treeid,openuls.join(","),durationdays)}
ddtreemenu.getCookie=function(Name){var re=new RegExp(Name+"=[^;]+","i");if(document.cookie.match(re))
return document.cookie.match(re)[0].split("=")[1]
return""}
ddtreemenu.setCookie=function(name,value,days){var expireDate=new Date()
var expstring=expireDate.setDate(expireDate.getDate()+parseInt(days))
document.cookie=name+"="+value+"; expires="+expireDate.toGMTString()+"; path=/";}
ddtreemenu.searcharray=function(thearray,value){var isfound=false
for(var i=0;i<thearray.length;i++){if(thearray[i]==value){isfound=true
thearray.shift()
break}}
return isfound}
ddtreemenu.preventpropagate=function(e){if(typeof e!="undefined")
e.stopPropagation()
else
event.cancelBubble=true}
ddtreemenu.dotask=function(target,functionref,tasktype){var tasktype=(window.addEventListener)?tasktype:"on"+tasktype
if(target.addEventListener)
target.addEventListener(tasktype,functionref,false)
else if(target.attachEvent)
target.attachEvent(tasktype,functionref)}