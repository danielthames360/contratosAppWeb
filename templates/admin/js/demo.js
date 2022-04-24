!function(l,e){"use strict";var t=["skin-blue","skin-black","skin-red","skin-yellow","skin-purple","skin-green","skin-blue-light","skin-black-light","skin-red-light","skin-yellow-light","skin-purple-light","skin-green-light"],a=l("<div />",{id:"control-sidebar-theme-demo-options-tab",class:"tab-pane active"}),s=l("<li />",{class:"active"}).html("<a href='#control-sidebar-theme-demo-options-tab' data-toggle='tab'><i class='fa fa-wrench'></i></a>");l("[href='#control-sidebar-home-tab']").parent().before(s);var i=l("<div />");i.append("<h4 class='control-sidebar-heading'>AdminLTE Theme Settings</h4><div class='form-group'><label class='control-sidebar-subheading'><input type='checkbox' data-layout='fixed' class='pull-right'/> Fixed layout</label><p>Activate the fixed layout. You can't use fixed and boxed layouts together</p></div><div class='form-group'><label class='control-sidebar-subheading'><input type='checkbox' data-layout='layout-boxed'class='pull-right'/> Boxed Layout</label><p>Activate the boxed layout</p></div><div class='form-group'><label class='control-sidebar-subheading'><input type='checkbox' data-layout='sidebar-collapse' class='pull-right'/> Toggle Sidebar</label><p>Toggle the left sidebar's state (open or collapse)</p></div><div class='form-group'><label class='control-sidebar-subheading'><input type='checkbox' data-enable='expandOnHover' class='pull-right'/> Sidebar Expand on Hover</label><p>Let the sidebar mini expand on hover</p></div><div class='form-group'><label class='control-sidebar-subheading'><input type='checkbox' data-controlsidebar='control-sidebar-open' class='pull-right'/> Toggle Right Sidebar Slide</label><p>Toggle between slide over content and push content effects</p></div><div class='form-group'><label class='control-sidebar-subheading'><input type='checkbox' data-sidebarskin='toggle' class='pull-right'/> Toggle Right Sidebar Skin</label><p>Toggle between dark and light skins for the right sidebar</p></div>");var d=l("<ul />",{class:"list-unstyled clearfix"}),o=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-blue' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div><span style='display:block; width: 20%; float: left; height: 7px; background: #367fa9;'></span><span class='bg-light-blue' style='display:block; width: 80%; float: left; height: 7px;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin'>Blue</p>");d.append(o);var p=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-black' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div style='box-shadow: 0 0 2px rgba(0,0,0,0.1)' class='clearfix'><span style='display:block; width: 20%; float: left; height: 7px; background: #fefefe;'></span><span style='display:block; width: 80%; float: left; height: 7px; background: #fefefe;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #222;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin'>Black</p>");d.append(p);var n=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-purple' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-purple-active'></span><span class='bg-purple' style='display:block; width: 80%; float: left; height: 7px;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin'>Purple</p>");d.append(n);var c=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-green' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-green-active'></span><span class='bg-green' style='display:block; width: 80%; float: left; height: 7px;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin'>Green</p>");d.append(c);var r=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-red' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-red-active'></span><span class='bg-red' style='display:block; width: 80%; float: left; height: 7px;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin'>Red</p>");d.append(r);var h=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-yellow' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-yellow-active'></span><span class='bg-yellow' style='display:block; width: 80%; float: left; height: 7px;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin'>Yellow</p>");d.append(h);var f=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-blue-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div><span style='display:block; width: 20%; float: left; height: 7px; background: #367fa9;'></span><span class='bg-light-blue' style='display:block; width: 80%; float: left; height: 7px;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin' style='font-size: 12px'>Blue Light</p>");d.append(f);var b=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-black-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div style='box-shadow: 0 0 2px rgba(0,0,0,0.1)' class='clearfix'><span style='display:block; width: 20%; float: left; height: 7px; background: #fefefe;'></span><span style='display:block; width: 80%; float: left; height: 7px; background: #fefefe;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin' style='font-size: 12px'>Black Light</p>");d.append(b);var g=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-purple-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-purple-active'></span><span class='bg-purple' style='display:block; width: 80%; float: left; height: 7px;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin' style='font-size: 12px'>Purple Light</p>");d.append(g);var y=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-green-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-green-active'></span><span class='bg-green' style='display:block; width: 80%; float: left; height: 7px;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin' style='font-size: 12px'>Green Light</p>");d.append(y);var k=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-red-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-red-active'></span><span class='bg-red' style='display:block; width: 80%; float: left; height: 7px;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin' style='font-size: 12px'>Red Light</p>");d.append(k);var x=l("<li />",{style:"float:left; width: 33.33333%; padding: 5px;"}).append("<a href='javascript:void(0);' data-skin='skin-yellow-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'><div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-yellow-active'></span><span class='bg-yellow' style='display:block; width: 80%; float: left; height: 7px;'></span></div><div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div></a><p class='text-center no-margin' style='font-size: 12px;'>Yellow Light</p>");function v(a){l("body").toggleClass(a),e.layout.fixSidebar(),"layout-boxed"==a&&e.controlSidebar._fix(l(".control-sidebar-bg")),l("body").hasClass("fixed")&&"fixed"==a&&(e.pushMenu.expandOnHover(),e.layout.activate()),e.controlSidebar._fix(l(".control-sidebar-bg")),e.controlSidebar._fix(l(".control-sidebar"))}function u(a){return l.each(t,function(a){l("body").removeClass(t[a])}),l("body").addClass(a),function(a,l){"undefined"!=typeof Storage?localStorage.setItem(a,l):window.alert("Please use a modern browser to properly view this template!")}("skin",a),!1}d.append(x),i.append("<h4 class='control-sidebar-heading'>Skins</h4>"),i.append(d),a.append(i),l("#control-sidebar-home-tab").after(a),function(){var a=function(a){{if("undefined"!=typeof Storage)return localStorage.getItem(a);window.alert("Please use a modern browser to properly view this template!")}}("skin");a&&l.inArray(a,t)&&u(a);l("[data-skin]").on("click",function(a){l(this).hasClass("knob")||(a.preventDefault(),u(l(this).data("skin")))}),l("[data-layout]").on("click",function(){v(l(this).data("layout"))}),l("[data-controlsidebar]").on("click",function(){v(l(this).data("controlsidebar"));var a=!e.options.controlSidebarOptions.slide;(e.options.controlSidebarOptions.slide=a)||l(".control-sidebar").removeClass("control-sidebar-open")}),l("[data-sidebarskin='toggle']").on("click",function(){var a=l(".control-sidebar");a.hasClass("control-sidebar-dark")?(a.removeClass("control-sidebar-dark"),a.addClass("control-sidebar-light")):(a.removeClass("control-sidebar-light"),a.addClass("control-sidebar-dark"))}),l("[data-enable='expandOnHover']").on("click",function(){l(this).attr("disabled",!0),e.pushMenu.expandOnHover(),l("body").hasClass("sidebar-collapse")||l("[data-layout='sidebar-collapse']").click()}),l("body").hasClass("fixed")&&l("[data-layout='fixed']").attr("checked","checked");l("body").hasClass("layout-boxed")&&l("[data-layout='layout-boxed']").attr("checked","checked");l("body").hasClass("sidebar-collapse")&&l("[data-layout='sidebar-collapse']").attr("checked","checked")}()}(jQuery,$.AdminLTE);