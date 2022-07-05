

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
/jamiyaCBT/media/system/js/frontediting.js
================================================================================*/;
!function(t){t.fn.extend({jEditMakeAbsolute:function(e){return this.each(function(){var o,i=t(this);o=e?i.offset():i.position(),i.css({position:"absolute",marginLeft:0,marginTop:0,top:o.top,left:o.left,bottom:"auto",right:"auto"}),e&&i.detach().appendTo("body")})}}),t(document).ready(function(){var e=200,o=100,i=function(i,n){var d,a,l,r,s,p,u,m,c,h,f,v,j,b,g;return v=function(t){return u<t.top&&s<t.left&&p>t.left+e&&r>t.top+o},d=t(n),b=t.extend({},d.offset(),{width:n.offsetWidth,height:n.offsetHeight}),u=t(document).scrollTop(),s=t(document).scrollLeft(),p=s+t(window).width(),r=u+t(window).height(),m={top:b.top-o,left:b.left+b.width/2-e/2},c={top:b.top+b.height,left:b.left+b.width/2-e/2},h={top:b.top+b.height/2-o/2,left:b.left-e},f={top:b.top+b.height/2-o/2,left:b.left+b.width},a=v(m),l=v(c),j=v(h),g=v(f),a?"top":l?"bottom":j?"left":"right"};t(".jmoddiv").on({mouseenter:function(){var e=t(this).data("jmodediturl"),o=t(this).data("jmodtip"),n=t(this).data("target");t("body>.btn.jmodedit").clearQueue().tooltip("destroy").remove(),t(this).addClass("jmodinside").prepend('<a class="btn jmodedit" href="#" target="'+n+'"><span class="icon-edit"></span></a>').children(":first").attr("href",e).attr("title",o).tooltip({container:!1,html:!0,placement:i}).jEditMakeAbsolute(!0),t(".btn.jmodedit").on({mouseenter:function(){t(this).clearQueue()},mouseleave:function(){t(this).delay(500).queue(function(e){t(this).tooltip("destroy").remove(),e()})}})},mouseleave:function(){t("body>.btn.jmodedit").delay(500).queue(function(e){t(this).tooltip("destroy").remove(),e()})}});var n=null;t(".jmoddiv[data-jmenuedittip] .nav li,.jmoddiv[data-jmenuedittip].nav li,.jmoddiv[data-jmenuedittip] .nav .nav-child li,.jmoddiv[data-jmenuedittip].nav .nav-child li").on({mouseenter:function(){var e=/\bitem-(\d+)\b/.exec(t(this).attr("class"));if("string"==typeof e[1])var o=t(this).closest(".jmoddiv"),i=o.data("jmodediturl"),d=i.replace(/\/index.php\?option=com_config&controller=config.display.modules([^\d]+).+$/,"/administrator/index.php?option=com_menus&view=item&layout=edit$1"+e[1]);var a=o.data("jmenuedittip").replace("%s",e[1]),l=t('<div><a class="btn jfedit-menu" href="#" target="_blank"><span class="icon-edit"></span></a></div>');l.children("a.jfedit-menu").prop("href",d).prop("title",a),n&&t(n).popover("hide"),t(this).popover({html:!0,content:l.html(),container:"body",trigger:"manual",animation:!1,placement:"bottom"}).popover("show"),n=this,t("body>div.popover").on({mouseenter:function(){n&&t(n).clearQueue()},mouseleave:function(){n&&t(n).popover("hide")}}).find("a.jfedit-menu").tooltip({container:!1,html:!0,placement:"bottom"})},mouseleave:function(){t(this).delay(1500).queue(function(e){t(this).popover("hide"),e()})}})})}(jQuery);