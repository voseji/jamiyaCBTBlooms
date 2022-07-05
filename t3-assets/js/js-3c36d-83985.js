

/*===============================
/jamiyaCBT/plugins/system/t3/base-bs3/js/nav-collapse.js
================================================================================*/;
/**
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org
 *------------------------------------------------------------------------------
 */

jQuery(document).ready(function ($) {

    // clone the collapse menu from mainnav (.t3-navbar)
    $('.t3-navbar').each(function(){
        var $navwrapper  = $(this),
            $menu        = null,
            $placeholder = null;

        if ($navwrapper.find('.t3-megamenu').length) {
            
            // clone for megamenu
            $menu        = $navwrapper.find('ul.level0').clone(),
            $placeholder = $navwrapper.prev('.navbar-collapse');

            if(!$placeholder.length){
                //get the empty one
                $placeholder = $navwrapper.closest('.container, .t3-mainnav').find('.navbar-collapse:empty');
            }
            
            var lis = $menu.find('li[data-id]'),
                liactive = lis.filter('.current');
            
            // clean class
            lis.removeClass('mega dropdown mega-align-left mega-align-right mega-align-center mega-align-adjust');
            // rebuild
            lis.each(function () {

                // get firstchild - a or span
                var $li = $(this),
                    $child = $li.find('>:first-child');

                if ($child[0].nodeName == 'DIV') {
                    $child.find('>:first-child').prependTo($li);
                    $child.remove();
                }

                // remove caret
                if($li.data('hidewcol')){
                    $child.find('.caret').remove();
                    $child.nextAll().remove();

                    return; //that is all for this item
                }

                // find subnav and inject into one ul
                var subul = $li.find('ul.level' + $li.data('level'));
                if (subul.length) {
                    // create subnav
                    $ul = $('<ul class="level' + $li.data('level') + ' dropdown-menu">');
                    subul.each(function () {
                        // check if the ul not in a hide when collapsed column
                        if ($(this).parents('.mega-col-nav').data('hidewcol')) return ;
                        $(this).find('>li').appendTo($ul);
                    });
                    if ($ul.children().length) {
                        $ul.appendTo($li);
                    }
                }

                // remove all child div
                $li.find('>div').remove();

                // clean caret if there was no real submenu
                if(!$li.children('ul').length){
                    $child.find('.caret').remove();
                }

                var divider = $li.hasClass('divider');

                // clear all attributes
                // $li.removeAttr('class');
                for (var x in $li.data()) {
                    $li.removeAttr('data-' + x)
                }
                $child.removeAttr('class');
                for (var x in $child.data()) {
                    $child.removeAttr('data-' + x)
                }

                if(divider){
                    $li.addClass('divider');
                }
            });

            // update class current
            liactive.addClass('current active');
            
        } else {
            // clone for bootstrap menu
            $menu = $navwrapper.find ('ul.nav').clone();
            $placeholder = $('.t3-navbar-collapse:empty, .navbar-collapse:empty').eq(0);
        }
        
        //so we have all structure, add standard bootstrap class
        $menu.find ('a[data-toggle="dropdown"]').removeAttr('data-toggle').removeAttr('data-target');
        $menu
            .find('> li > ul.dropdown-menu')
            .prev('a').attr('data-toggle', 'dropdown').attr('data-target', '#')
            .parent('li')
            .addClass(function(){
                return 'dropdown' + ($(this).data('level') > 1 ? ' dropdown-submenu' : '');
            });

        // inject into .t3-navbar-collapse
        $menu.appendTo ($placeholder);

    });
});



/*===============================
/jamiyaCBT/media/system/js/core.js
================================================================================*/;
Joomla=window.Joomla||{};Joomla.editors=Joomla.editors||{};Joomla.editors.instances=Joomla.editors.instances||{};(function(Joomla,document){"use strict";Joomla.submitform=function(task,form,validate){if(!form){form=document.getElementById("adminForm")}if(task){form.task.value=task}form.noValidate=!validate;if(!validate){form.setAttribute("novalidate","")}else if(form.hasAttribute("novalidate")){form.removeAttribute("novalidate")}var button=document.createElement("input");button.style.display="none";button.type="submit";form.appendChild(button).click();form.removeChild(button)};Joomla.submitbutton=function(pressbutton){Joomla.submitform(pressbutton)};Joomla.Text={strings:{},_:function(key,def){var newStrings=Joomla.getOptions("joomla.jtext");if(newStrings){this.load(newStrings);Joomla.loadOptions({"joomla.jtext":null})}def=def===undefined?"":def;key=key.toUpperCase();return this.strings[key]!==undefined?this.strings[key]:def},load:function(object){for(var key in object){if(!object.hasOwnProperty(key))continue;this.strings[key.toUpperCase()]=object[key]}return this}};Joomla.JText=Joomla.Text;Joomla.optionsStorage=Joomla.optionsStorage||null;Joomla.getOptions=function(key,def){if(!Joomla.optionsStorage){Joomla.loadOptions()}return Joomla.optionsStorage[key]!==undefined?Joomla.optionsStorage[key]:def};Joomla.loadOptions=function(options){if(!options){var elements=document.querySelectorAll(".joomla-script-options.new"),str,element,option,counter=0;for(var i=0,l=elements.length;i<l;i++){element=elements[i];str=element.text||element.textContent;option=JSON.parse(str);if(option){Joomla.loadOptions(option);counter++}element.className=element.className.replace(" new"," loaded")}if(counter){return}}if(!Joomla.optionsStorage){Joomla.optionsStorage=options||{}}else if(options){for(var p in options){if(options.hasOwnProperty(p)){Joomla.optionsStorage[p]=options[p]}}}};Joomla.replaceTokens=function(newToken){if(!/^[0-9A-F]{32}$/i.test(newToken)){return}var els=document.getElementsByTagName("input"),i,el,n;for(i=0,n=els.length;i<n;i++){el=els[i];if(el.type=="hidden"&&el.value=="1"&&el.name.length==32){el.name=newToken}}};Joomla.isEmail=function(text){console.warn("Joomla.isEmail() is deprecated, use the formvalidator instead");var regex=/^[\w.!#$%&‚Äô*+\/=?^`{|}~-]+@[a-z0-9-]+(?:\.[a-z0-9-]{2,})+$/i;return regex.test(text)};Joomla.checkAll=function(checkbox,stub){if(!checkbox.form)return false;stub=stub?stub:"cb";var c=0,i,e,n;for(i=0,n=checkbox.form.elements.length;i<n;i++){e=checkbox.form.elements[i];if(e.type==checkbox.type&&e.id.indexOf(stub)===0){e.checked=checkbox.checked;c+=e.checked?1:0}}if(checkbox.form.boxchecked){checkbox.form.boxchecked.value=c}return true};Joomla.renderMessages=function(messages){Joomla.removeMessages();var messageContainer=document.getElementById("system-message-container"),type,typeMessages,messagesBox,title,titleWrapper,i,messageWrapper,alertClass;for(type in messages){if(!messages.hasOwnProperty(type)){continue}typeMessages=messages[type];messagesBox=document.createElement("div");alertClass=type==="notice"?"alert-info":"alert-"+type;alertClass=type==="message"?"alert-success":alertClass;alertClass=type==="error"?"alert-error alert-danger":alertClass;messagesBox.className="alert "+alertClass;var buttonWrapper=document.createElement("button");buttonWrapper.setAttribute("type","button");buttonWrapper.setAttribute("data-dismiss","alert");buttonWrapper.className="close";buttonWrapper.innerHTML="×";messagesBox.appendChild(buttonWrapper);title=Joomla.JText._(type);if(typeof title!="undefined"){titleWrapper=document.createElement("h4");titleWrapper.className="alert-heading";titleWrapper.innerHTML=Joomla.JText._(type);messagesBox.appendChild(titleWrapper)}for(i=typeMessages.length-1;i>=0;i--){messageWrapper=document.createElement("div");messageWrapper.innerHTML=typeMessages[i];messagesBox.appendChild(messageWrapper)}messageContainer.appendChild(messagesBox)}};Joomla.removeMessages=function(){var messageContainer=document.getElementById("system-message-container");while(messageContainer.firstChild)messageContainer.removeChild(messageContainer.firstChild);messageContainer.style.display="none";messageContainer.offsetHeight;messageContainer.style.display=""};Joomla.ajaxErrorsMessages=function(xhr,textStatus,error){var msg={};if(textStatus==="parsererror"){var encodedJson=xhr.responseText.trim();var buf=[];for(var i=encodedJson.length-1;i>=0;i--){buf.unshift(["&#",encodedJson[i].charCodeAt(),";"].join(""))}encodedJson=buf.join("");msg.error=[Joomla.JText._("JLIB_JS_AJAX_ERROR_PARSE").replace("%s",encodedJson)]}else if(textStatus==="nocontent"){msg.error=[Joomla.JText._("JLIB_JS_AJAX_ERROR_NO_CONTENT")]}else if(textStatus==="timeout"){msg.error=[Joomla.JText._("JLIB_JS_AJAX_ERROR_TIMEOUT")]}else if(textStatus==="abort"){msg.error=[Joomla.JText._("JLIB_JS_AJAX_ERROR_CONNECTION_ABORT")]}else if(xhr.responseJSON&&xhr.responseJSON.message){msg.error=[Joomla.JText._("JLIB_JS_AJAX_ERROR_OTHER").replace("%s",xhr.status)+" <em>"+xhr.responseJSON.message+"</em>"]}else if(xhr.statusText){msg.error=[Joomla.JText._("JLIB_JS_AJAX_ERROR_OTHER").replace("%s",xhr.status)+" <em>"+xhr.statusText+"</em>"]}else{msg.error=[Joomla.JText._("JLIB_JS_AJAX_ERROR_OTHER").replace("%s",xhr.status)]}return msg};Joomla.isChecked=function(isitchecked,form){if(typeof form==="undefined"){form=document.getElementById("adminForm")}form.boxchecked.value=isitchecked?parseInt(form.boxchecked.value)+1:parseInt(form.boxchecked.value)-1;if(!form.elements["checkall-toggle"])return;var c=true,i,e,n;for(i=0,n=form.elements.length;i<n;i++){e=form.elements[i];if(e.type=="checkbox"&&e.name!="checkall-toggle"&&!e.checked){c=false;break}}form.elements["checkall-toggle"].checked=c};Joomla.popupWindow=function(mypage,myname,w,h,scroll){console.warn("Joomla.popupWindow() is deprecated without a replacement!");var winl=(screen.width-w)/2,wint=(screen.height-h)/2,winprops="height="+h+",width="+w+",top="+wint+",left="+winl+",scrollbars="+scroll+",resizable";window.open(mypage,myname,winprops).window.focus()};Joomla.tableOrdering=function(order,dir,task,form){if(typeof form==="undefined"){form=document.getElementById("adminForm")}form.filter_order.value=order;form.filter_order_Dir.value=dir;Joomla.submitform(task,form)};window.writeDynaList=function(selectParams,source,key,orig_key,orig_val,element){console.warn("window.writeDynaList() is deprecated without a replacement!");var select=document.createElement("select");var params=selectParams.split(" ");for(var l=0;l<params.length;l++){var par=params[l].split("=");if(par[0].trim().substr(0,2).toLowerCase()==="on"||par[0].trim().toLowerCase()==="href"){continue}select.setAttribute(par[0],par[1].replace(/\"/g,""))}var hasSelection=key==orig_key,i,selected,item;for(i=0;i<source.length;i++){item=source[i];if(item[0]!=key){continue}selected=hasSelection?orig_val==item[1]:i===0;var el=document.createElement("option");el.setAttribute("value",item[1]);el.innerText=item[2];if(selected){el.setAttribute("selected","selected")}select.appendChild(el)}if(element){element.appendChild(select)}else{document.body.appendChild(select)}};window.changeDynaList=function(listname,source,key,orig_key,orig_val){console.warn("window.changeDynaList() is deprecated without a replacement!");var list=document.adminForm[listname],hasSelection=key==orig_key,i,x,item,opt;while(list.firstChild)list.removeChild(list.firstChild);i=0;for(x in source){if(!source.hasOwnProperty(x)){continue}item=source[x];if(item[0]!=key){continue}opt=new Option;opt.value=item[1];opt.text=item[2];if(hasSelection&&orig_val==opt.value||!hasSelection&&i===0){opt.selected=true}list.options[i++]=opt}list.length=i};window.radioGetCheckedValue=function(radioObj){console.warn("window.radioGetCheckedValue() is deprecated without a replacement!");if(!radioObj){return""}var n=radioObj.length,i;if(n===undefined){return radioObj.checked?radioObj.value:""}for(i=0;i<n;i++){if(radioObj[i].checked){return radioObj[i].value}}return""};window.getSelectedValue=function(frmName,srcListName){console.warn("window.getSelectedValue() is deprecated without a replacement!");var srcList=document[frmName][srcListName],i=srcList.selectedIndex;if(i!==null&&i>-1){return srcList.options[i].value}else{return null}};window.listItemTask=function(id,task){console.warn("window.listItemTask() is deprecated use Joomla.listItemTask() instead");return Joomla.listItemTask(id,task)};Joomla.listItemTask=function(id,task){var f=document.adminForm,i=0,cbx,cb=f[id];if(!cb)return false;while(true){cbx=f["cb"+i];if(!cbx)break;cbx.checked=false;i++}cb.checked=true;f.boxchecked.value=1;window.submitform(task);return false};window.submitbutton=function(pressbutton){console.warn("window.submitbutton() is deprecated use Joomla.submitbutton() instead");Joomla.submitbutton(pressbutton)};window.submitform=function(pressbutton){console.warn("window.submitform() is deprecated use Joomla.submitform() instead");Joomla.submitform(pressbutton)};window.saveorder=function(n,task){console.warn("window.saveorder() is deprecated without a replacement!");window.checkAll_button(n,task)};window.checkAll_button=function(n,task){console.warn("window.checkAll_button() is deprecated without a replacement!");task=task?task:"saveorder";var j,box;for(j=0;j<=n;j++){box=document.adminForm["cb"+j];if(box){box.checked=true}else{alert("You cannot change the order of items, as an item in the list is `Checked Out`");return}}Joomla.submitform(task)};Joomla.loadingLayer=function(task,parentElement){task=task||"show";parentElement=parentElement||document.body;if(task==="load"){var systemPaths=Joomla.getOptions("system.paths")||{},basePath=systemPaths.root||"";var loadingDiv=document.createElement("div");loadingDiv.id="loading-logo";loadingDiv.style["position"]="fixed";loadingDiv.style["top"]="0";loadingDiv.style["left"]="0";loadingDiv.style["width"]="100%";loadingDiv.style["height"]="100%";loadingDiv.style["opacity"]="0.8";loadingDiv.style["filter"]="alpha(opacity=80)";loadingDiv.style["overflow"]="hidden";loadingDiv.style["z-index"]="10000";loadingDiv.style["display"]="none";loadingDiv.style["background-color"]="#fff";loadingDiv.style["background-image"]='url("'+basePath+'/media/jui/images/ajax-loader.gif")';loadingDiv.style["background-position"]="center";loadingDiv.style["background-repeat"]="no-repeat";loadingDiv.style["background-attachment"]="fixed";parentElement.appendChild(loadingDiv)}else{if(!document.getElementById("loading-logo")){Joomla.loadingLayer("load",parentElement)}document.getElementById("loading-logo").style["display"]=task=="show"?"block":"none"}return document.getElementById("loading-logo")};Joomla.extend=function(destination,source){for(var p in source){if(source.hasOwnProperty(p)){destination[p]=source[p]}}return destination};Joomla.request=function(options){options=Joomla.extend({url:"",method:"GET",data:null,perform:true},options);options.method=options.data?"POST":options.method.toUpperCase();try{var xhr=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("MSXML2.XMLHTTP.3.0");xhr.open(options.method,options.url,true);xhr.setRequestHeader("X-Requested-With","XMLHttpRequest");xhr.setRequestHeader("X-Ajax-Engine","Joomla!");if(options.method==="POST"){var token=Joomla.getOptions("csrf.token","");if(token){xhr.setRequestHeader("X-CSRF-Token",token)}if(typeof options.data==="string"&&(!options.headers||!options.headers["Content-Type"])){xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")}}if(options.headers){for(var p in options.headers){if(options.headers.hasOwnProperty(p)){xhr.setRequestHeader(p,options.headers[p])}}}xhr.onreadystatechange=function(){if(xhr.readyState!==4)return;if(xhr.status===200){if(options.onSuccess){options.onSuccess.call(window,xhr.responseText,xhr)}}else if(options.onError){options.onError.call(window,xhr)}};if(options.perform){if(options.onBefore&&options.onBefore.call(window,xhr)===false){return xhr}xhr.send(options.data)}}catch(error){window.console?console.log(error):null;return false}return xhr}})(Joomla,document);



/*===============================
/jamiyaCBT/media/system/js/polyfill.event.js
================================================================================*/;
(function(e){"Window"in this||!function(e){e.constructor?e.Window=e.constructor:(e.Window=e.constructor=new Function("return function Window() {}")()).prototype=this}(this),"Document"in this||(this.HTMLDocument?this.Document=this.HTMLDocument:(this.Document=this.HTMLDocument=document.constructor=new Function("return function Document() {}")(),this.Document.prototype=document)),"Element"in this&&"HTMLElement"in this||!function(){function e(){return s--||clearTimeout(t),document.body&&!document.body.prototype&&/(complete|interactive)/.test(document.readyState)?(a(document,!0),t&&document.body.prototype&&clearTimeout(t),!!document.body.prototype):!1}if(window.Element&&!window.HTMLElement)return void(window.HTMLElement=window.Element);window.Element=window.HTMLElement=new Function("return function Element() {}")();var t,n=document.appendChild(document.createElement("body")),o=n.appendChild(document.createElement("iframe")),r=o.contentWindow.document,i=Element.prototype=r.appendChild(r.createElement("*")),c={},a=function(e,t){var n,o,r,i=e.childNodes||[],u=-1;if(1===e.nodeType&&e.constructor!==Element){e.constructor=Element;for(n in c)o=c[n],e[n]=o}for(;r=t&&i[++u];)a(r,t);return e},u=document.getElementsByTagName("*"),l=document.createElement,s=100;i.attachEvent("onpropertychange",function(e){for(var t,n=e.propertyName,o=!c.hasOwnProperty(n),r=i[n],a=c[n],l=-1;t=u[++l];)1===t.nodeType&&(o||t[n]===a)&&(t[n]=r);c[n]=r}),i.constructor=Element,i.hasAttribute||(i.hasAttribute=function(e){return null!==this.getAttribute(e)}),e(!0)||(document.onreadystatechange=e,t=setInterval(e,25)),document.createElement=function(e){var t=l(String(e).toLowerCase());return a(t)},document.removeChild(n)}(),"defineProperty"in Object&&function(){try{var e={};return Object.defineProperty(e,"test",{value:42}),!0}catch(t){return!1}}()||!function(e){var t=Object.prototype.hasOwnProperty("__defineGetter__"),n="Getters & setters cannot be defined on this javascript engine",o="A property cannot both have accessors and be writable or have a value";Object.defineProperty=function(r,i,c){if(e&&(r===window||r===document||r===Element.prototype||r instanceof Element))return e(r,i,c);if(null===r||!(r instanceof Object||"object"==typeof r))throw new TypeError("Object must be an object (Object.defineProperty polyfill)");if(!(c instanceof Object))throw new TypeError("Descriptor must be an object (Object.defineProperty polyfill)");var a=String(i),u="value"in c||"writable"in c,l="get"in c&&typeof c.get,s="set"in c&&typeof c.set;if(l){if("function"!==l)throw new TypeError("Getter expected a function (Object.defineProperty polyfill)");if(!t)throw new TypeError(n);if(u)throw new TypeError(o);r.__defineGetter__(a,c.get)}else r[a]=c.value;if(s){if("function"!==s)throw new TypeError("Setter expected a function (Object.defineProperty polyfill)");if(!t)throw new TypeError(n);if(u)throw new TypeError(o);r.__defineSetter__(a,c.set)}return"value"in c&&(r[a]=c.value),r}}(Object.defineProperty),function(e){if(!("Event"in e))return!1;if("function"==typeof e.Event)return!0;try{return new Event("click"),!0}catch(t){return!1}}(this)||!function(){function t(e,t){for(var n=-1,o=e.length;++n<o;)if(n in e&&e[n]===t)return n;return-1}var n={click:1,dblclick:1,keyup:1,keypress:1,keydown:1,mousedown:1,mouseup:1,mousemove:1,mouseover:1,mouseenter:1,mouseleave:1,mouseout:1,storage:1,storagecommit:1,textinput:1},o=window.Event&&window.Event.prototype||null;window.Event=Window.prototype.Event=function(t,n){if(!t)throw new Error("Not enough arguments");if("createEvent"in document){var o=document.createEvent("Event"),r=n&&n.bubbles!==e?n.bubbles:!1,i=n&&n.cancelable!==e?n.cancelable:!1;return o.initEvent(t,r,i),o}var o=document.createEventObject();return o.type=t,o.bubbles=n&&n.bubbles!==e?n.bubbles:!1,o.cancelable=n&&n.cancelable!==e?n.cancelable:!1,o},o&&Object.defineProperty(window.Event,"prototype",{configurable:!1,enumerable:!1,writable:!0,value:o}),"createEvent"in document||(window.addEventListener=Window.prototype.addEventListener=Document.prototype.addEventListener=Element.prototype.addEventListener=function(){var e=this,o=arguments[0],r=arguments[1];if(e===window&&o in n)throw new Error("In IE8 the event: "+o+" is not available on the window object. Please see https://github.com/Financial-Times/polyfill-service/issues/317 for more information.");e._events||(e._events={}),e._events[o]||(e._events[o]=function(n){var o,r=e._events[n.type].list,i=r.slice(),c=-1,a=i.length;for(n.preventDefault=function(){n.cancelable!==!1&&(n.returnValue=!1)},n.stopPropagation=function(){n.cancelBubble=!0},n.stopImmediatePropagation=function(){n.cancelBubble=!0,n.cancelImmediate=!0},n.currentTarget=e,n.relatedTarget=n.fromElement||null,n.target=n.target||n.srcElement||e,n.timeStamp=(new Date).getTime(),n.clientX&&(n.pageX=n.clientX+document.documentElement.scrollLeft,n.pageY=n.clientY+document.documentElement.scrollTop);++c<a&&!n.cancelImmediate;)c in i&&(o=i[c],-1!==t(r,o)&&"function"==typeof o&&o.call(e,n))},e._events[o].list=[],e.attachEvent&&e.attachEvent("on"+o,e._events[o])),e._events[o].list.push(r)},window.removeEventListener=Window.prototype.removeEventListener=Document.prototype.removeEventListener=Element.prototype.removeEventListener=function(){var e,n=this,o=arguments[0],r=arguments[1];n._events&&n._events[o]&&n._events[o].list&&(e=t(n._events[o].list,r),-1!==e&&(n._events[o].list.splice(e,1),n._events[o].list.length||(n.detachEvent&&n.detachEvent("on"+o,n._events[o]),delete n._events[o])))},window.dispatchEvent=Window.prototype.dispatchEvent=Document.prototype.dispatchEvent=Element.prototype.dispatchEvent=function(e){if(!arguments.length)throw new Error("Not enough arguments");if(!e||"string"!=typeof e.type)throw new Error("DOM Events Exception 0");var t=this,n=e.type;try{if(!e.bubbles){e.cancelBubble=!0;var o=function(e){e.cancelBubble=!0,(t||window).detachEvent("on"+n,o)};this.attachEvent("on"+n,o)}this.fireEvent("on"+n,e)}catch(r){e.target=t;do e.currentTarget=t,"_events"in t&&"function"==typeof t._events[n]&&t._events[n].call(t,e),"function"==typeof t["on"+n]&&t["on"+n].call(t,e),t=9===t.nodeType?t.parentWindow:t.parentNode;while(t&&!e.cancelBubble)}return!0},document.attachEvent("onreadystatechange",function(){"complete"===document.readyState&&document.dispatchEvent(new Event("DOMContentLoaded",{bubbles:!0}))}))}()}).call("object"==typeof window&&window||"object"==typeof self&&self||"object"==typeof global&&global||{});



/*===============================
/jamiyaCBT/media/system/js/keepalive.js
================================================================================*/;
!function(){"use strict";document.addEventListener("DOMContentLoaded",function(){var o=Joomla.getOptions("system.keepalive"),n=o&&o.uri?o.uri.replace(/&amp;/g,"&"):"",t=o&&o.interval?o.interval:45e3;if(""===n){var e=Joomla.getOptions("system.paths");n=(e?e.root+"/index.php":window.location.pathname)+"?option=com_ajax&format=json"}window.setInterval(function(){Joomla.request({url:n,onSuccess:function(){},onError:function(){}})},t)})}(window,document,Joomla);



/*===============================
/jamiyaCBT/media/system/js/frontediting.js
================================================================================*/;
!function(t){t.fn.extend({jEditMakeAbsolute:function(e){return this.each(function(){var o,i=t(this);o=e?i.offset():i.position(),i.css({position:"absolute",marginLeft:0,marginTop:0,top:o.top,left:o.left,bottom:"auto",right:"auto"}),e&&i.detach().appendTo("body")})}}),t(document).ready(function(){var e=200,o=100,i=function(i,n){var d,a,l,r,s,p,u,m,c,h,f,v,j,b,g;return v=function(t){return u<t.top&&s<t.left&&p>t.left+e&&r>t.top+o},d=t(n),b=t.extend({},d.offset(),{width:n.offsetWidth,height:n.offsetHeight}),u=t(document).scrollTop(),s=t(document).scrollLeft(),p=s+t(window).width(),r=u+t(window).height(),m={top:b.top-o,left:b.left+b.width/2-e/2},c={top:b.top+b.height,left:b.left+b.width/2-e/2},h={top:b.top+b.height/2-o/2,left:b.left-e},f={top:b.top+b.height/2-o/2,left:b.left+b.width},a=v(m),l=v(c),j=v(h),g=v(f),a?"top":l?"bottom":j?"left":"right"};t(".jmoddiv").on({mouseenter:function(){var e=t(this).data("jmodediturl"),o=t(this).data("jmodtip"),n=t(this).data("target");t("body>.btn.jmodedit").clearQueue().tooltip("destroy").remove(),t(this).addClass("jmodinside").prepend('<a class="btn jmodedit" href="#" target="'+n+'"><span class="icon-edit"></span></a>').children(":first").attr("href",e).attr("title",o).tooltip({container:!1,html:!0,placement:i}).jEditMakeAbsolute(!0),t(".btn.jmodedit").on({mouseenter:function(){t(this).clearQueue()},mouseleave:function(){t(this).delay(500).queue(function(e){t(this).tooltip("destroy").remove(),e()})}})},mouseleave:function(){t("body>.btn.jmodedit").delay(500).queue(function(e){t(this).tooltip("destroy").remove(),e()})}});var n=null;t(".jmoddiv[data-jmenuedittip] .nav li,.jmoddiv[data-jmenuedittip].nav li,.jmoddiv[data-jmenuedittip] .nav .nav-child li,.jmoddiv[data-jmenuedittip].nav .nav-child li").on({mouseenter:function(){var e=/\bitem-(\d+)\b/.exec(t(this).attr("class"));if("string"==typeof e[1])var o=t(this).closest(".jmoddiv"),i=o.data("jmodediturl"),d=i.replace(/\/index.php\?option=com_config&controller=config.display.modules([^\d]+).+$/,"/administrator/index.php?option=com_menus&view=item&layout=edit$1"+e[1]);var a=o.data("jmenuedittip").replace("%s",e[1]),l=t('<div><a class="btn jfedit-menu" href="#" target="_blank"><span class="icon-edit"></span></a></div>');l.children("a.jfedit-menu").prop("href",d).prop("title",a),n&&t(n).popover("hide"),t(this).popover({html:!0,content:l.html(),container:"body",trigger:"manual",animation:!1,placement:"bottom"}).popover("show"),n=this,t("body>div.popover").on({mouseenter:function(){n&&t(n).clearQueue()},mouseleave:function(){n&&t(n).popover("hide")}}).find("a.jfedit-menu").tooltip({container:!1,html:!0,placement:"bottom"})},mouseleave:function(){t(this).delay(1500).queue(function(e){t(this).popover("hide"),e()})}})})}(jQuery);