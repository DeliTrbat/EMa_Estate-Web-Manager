var _a;class DocumentHandler{static GETParamsToObj(params){return params.split("&").map(p=>p.split("=")).reduce((prev,[key,op])=>(prev[key]=op,prev),{})}static getGETParameters(){var params=window.location.search.substr(1);return null!=params&&""!==params?this.GETParamsToObj(params):{}}}function createSimpleElement(tagName,classes){const container=document.createElement(tagName);return container.setAttribute("class",classes),container}(_a=DocumentHandler).pipeline=[],DocumentHandler.whenReady=func=>{DocumentHandler.documentIsReady()?func():DocumentHandler.pipeline.push(func)},DocumentHandler.documentIsReady=()=>"complete"===document.readyState||"interactive"===document.readyState,DocumentHandler.runPipeline=()=>{DocumentHandler.pipeline.forEach(f=>f()),DocumentHandler.pipeline=[]},DocumentHandler.ready=()=>{let func=_a.runPipeline;DocumentHandler.documentIsReady()?func():document.addEventListener("DOMContentLoaded",func)};const createIcon=name=>createSimpleElement("span","icon icon-"+name),parseMoney=n=>{const s=n.toString();let rv="",l=0,u=s.length%3;for(0==u&&(u=3);u<=s.length;)rv+=s.slice(l,u)+" ",l=u,u+=3;return rv.slice(0,-1)},saveButtonClickHandler=element=>{element.classList.toggle("save-button--is-saved");const child=element.firstChild;child.classList.toggle("icon-saved"),child.classList.toggle("icon-save")},hamburgerClickHandler=()=>{document.getElementById("nav-list").classList.toggle("show")},getCookie=cookieName=>{let cookie={};return document.cookie.split(";").forEach(function(el){let[key,value]=el.split("=");cookie[key.trim()]=value}),cookie[cookieName]};function deleteCookie(name,path,domain){getCookie(name)&&(document.cookie=name+"="+(path?";path="+path:"")+(domain?";domain="+domain:"")+";expires=Thu, 01 Jan 1970 00:00:01 GMT")}const createLi=(text,href,liClass)=>{let li=document.createElement("li"),a=document.createElement("a");return a.appendChild(document.createTextNode(text)),a.href=href,li.appendChild(a),li.setAttribute("class",liClass),li},logout=()=>{deleteCookie("user","/","")},loggedIn=()=>{if(getCookie("user")){document.getElementById("login").remove(),document.getElementById("register").remove();var liProfile=createLi("Profil","/profile","right"),ul=document.getElementById("nav-list");ul.appendChild(liProfile);let liLogout=createLi("Deconectează-te","/login","");liLogout.setAttribute("onclick","logout()"),ul.appendChild(liLogout)}};DocumentHandler.whenReady(loggedIn),DocumentHandler.ready();