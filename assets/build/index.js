!function(e){var t={};function n(r){if(t[r])return t[r].exports;var a=t[r]={i:r,l:!1,exports:{}};return e[r].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)n.d(r,a,function(t){return e[t]}.bind(null,a));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=15)}([function(e,t){!function(){e.exports=this.wp.element}()},function(e,t){!function(){e.exports=this.wp.components}()},function(e,t){!function(){e.exports=this.wp.date}()},function(e,t){!function(){e.exports=this.wp.apiFetch}()},function(e,t){},function(e,t){},,,,,,,,,,function(e,t,n){"use strict";n.r(t);var r=n(0),a=n(1),i=n(2);function o(e){var t=e.date,n=e.updateDateTimeStart;t=t||GatherPress.event_datetime.datetime_start;var o=Object(i.__experimentalGetSettings)(),s=/a(?!\\)/i.test(o.formats.time.toLowerCase().replace(/\\\\/g,"").split("").reverse().join(""));return Object(r.createElement)(a.DateTimePicker,{currentDate:t,onChange:function(e){return n(e)},is12Hour:s})}function s(e){var t=e.date,n=(e.isOpen,Object(i.__experimentalGetSettings)());return Object(i.dateI18n)("".concat(n.formats.date," ").concat(n.formats.time),t)}function c(e){var t=e.date,n=e.updateDateTimeEnd;t=t||GatherPress.event_datetime.datetime_end;var o=Object(i.__experimentalGetSettings)(),s=/a(?!\\)/i.test(o.formats.time.toLowerCase().replace(/\\\\/g,"").split("").reverse().join(""));return Object(r.createElement)(a.DateTimePicker,{currentDate:t,onChange:function(e){return n(e)},is12Hour:s})}function m(e){var t=e.date,n=(e.isOpen,Object(i.__experimentalGetSettings)());return Object(i.dateI18n)("".concat(n.formats.date," ").concat(n.formats.time),t)}var l=n(3),d=n.n(l),u=wp.i18n.__,p=wp.plugins.registerPlugin,f=wp.editPost.PluginDocumentSettingPanel,_=moment().format("YYYY-MM-DThh:mm:ss");wp.data.subscribe((function(){var e=wp.data.select("core/editor").isSavingPost(),t=wp.data.select("core/editor").isAutosavingPost();e&&!t&&d()({path:"/gatherpress/v1/event/datetime/",method:"POST",data:{post_id:GatherPress.post_id,datetime_start:moment(GatherPress.event_datetime.datetime_start).format("YYYY-MM-DD HH:mm:ss"),datetime_end:moment(GatherPress.event_datetime.datetime_end).format("YYYY-MM-DD HH:mm:ss"),_wpnonce:GatherPress.nonce}}).then((function(e){}))}));var h=GatherPress.event_datetime.datetime_start,g=GatherPress.event_datetime.datetime_end;function b(){wp.data.dispatch("core/editor").editPost({meta:{_non_existing_meta:!0}})}function v(e){GatherPress.event_datetime.datetime_start=e,b()}function O(e){GatherPress.event_datetime.datetime_end=e,b()}h=""!==h?moment(h).format("YYYY-MM-DThh:mm:ss"):_,g=""!==g?moment(g).format("YYYY-MM-DThh:mm:ss"):moment(_).add(2,"hours").format("YYYY-MM-DThh:mm:ss"),GatherPress.event_datetime.datetime_start=h,GatherPress.event_datetime.datetime_end=g;p("date-and-time-setting-panel",{render:function(){return"gp_event"===wp.data.select("core/editor").getCurrentPostType()&&Object(r.createElement)(f,{name:"datetime",title:u("Date & Time","gatherpress"),initialOpen:!0,className:"datetime"},Object(r.createElement)(a.PanelRow,null,Object(r.createElement)("span",null,u("Start","gatherpress")),Object(r.createElement)(a.Dropdown,{position:"bottom left",contentClassName:"edit-post-post-schedule__dialog",renderToggle:function(e){var t=e.onToggle,n=e.isOpen;return Object(r.createElement)(r.Fragment,null,Object(r.createElement)(a.Button,{className:"edit-post-post-schedule__toggle",onClick:t,"aria-expanded":n,isLink:!0},Object(r.createElement)(s,{date:GatherPress.event_datetime.datetime_start,isOpen:n})))},renderContent:function(){return Object(r.createElement)(o,{updateDateTimeStart:v})}})),Object(r.createElement)(a.PanelRow,null,Object(r.createElement)("span",null,u("End","gatherpress")),Object(r.createElement)(a.Dropdown,{position:"bottom left",contentClassName:"edit-post-post-schedule__dialog",renderToggle:function(e){var t=e.onToggle,n=e.isOpen;return Object(r.createElement)(r.Fragment,null,Object(r.createElement)(a.Button,{className:"edit-post-post-schedule__toggle",onClick:t,"aria-expanded":n,isLink:!0},Object(r.createElement)(m,{date:GatherPress.event_datetime.datetime_end,isOpen:n})))},renderContent:function(){return Object(r.createElement)(c,{updateDateTimeEnd:O})}})))},icon:""});n(4),n(5);var j=Object(r.createElement)("svg",{id:"Layer_1","data-name":"Layer 1",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 147.1 147.1"},Object(r.createElement)("title",null,"GatherPress"),Object(r.createElement)("circle",{cx:"73.5",cy:"73.5",r:"73.5",fill:"#23c3aa"}),Object(r.createElement)("path",{d:"M791.8,520.2l-23.5,15.1s26.8,20.9,18.5,43.6l-42.8,34.5c-27.4-2.7-60.5-30.4-60.5-71l41.7-35.8c5.8.7,16.5-3.5,23.6-3.4C772.1,503.6,779.1,505,791.8,520.2Z",transform:"translate(-683.3 -467.9)",fill:"#36a08b"}),Object(r.createElement)("path",{d:"M763.6,538.1H797a2.9,2.9,0,0,1,2.9,2.9h0a59.4,59.4,0,0,1-2.3,17.4,36.9,36.9,0,0,1-7.6,13.1Q777.8,585,759.1,585a42.4,42.4,0,0,1-31.3-13.2,45.4,45.4,0,0,1,51.5-73,49.1,49.1,0,0,1,12.3,8.9,6.1,6.1,0,0,1,0,8.7l-.4.4a6,6,0,0,1-8.5-.1q-9.5-9.7-22.2-9.7a31.2,31.2,0,0,0-23.2,9.5Q728,526,728,540T738.4,564q9.7,8.7,21.1,8.7a26.2,26.2,0,0,0,17.4-6.5q7.7-6.6,8.6-15.8H763.6a6.2,6.2,0,0,1-6.2-6.2h0A6.2,6.2,0,0,1,763.6,538.1Z",transform:"translate(-683.3 -467.9)",fill:"#fff",stroke:"#fff","stroke-miterlimit":"10","stroke-width":"6"}));wp.blocks.updateCategory("gatherpress",{icon:j})}]);