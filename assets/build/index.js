!function(e){var t={};function r(n){if(t[n])return t[n].exports;var a=t[n]={i:n,l:!1,exports:{}};return e[n].call(a.exports,a,a.exports,r),a.l=!0,a.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)r.d(n,a,function(t){return e[t]}.bind(null,a));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=12)}([function(e,t){!function(){e.exports=this.wp.element}()},function(e,t){!function(){e.exports=this.wp.i18n}()},function(e,t){!function(){e.exports=this.wp.components}()},function(e,t){!function(){e.exports=this.wp.blocks}()},function(e,t){!function(){e.exports=this.wp.date}()},function(e,t){!function(){e.exports=this.wp.blockEditor}()},function(e,t){},function(e,t){},,,,,function(e,t,r){"use strict";r.r(t);var n=r(0),a=r(1),o=r(3),c=r(4),l=r(2),i=r(5);Object(o.registerBlockType)("gatherpress/event-times",{title:Object(a.__)("Event Times","gatherpress"),icon:{foreground:"#fff",background:"#23c3aa",src:"clock"},category:"gatherpress",keywords:[Object(a.__)("date","gatherpress"),Object(a.__)("event","gatherpress")],attributes:{startDate:{type:"string"},endDate:{type:"string"}},example:{attributes:{startDate:Object(a.__)("31 July 2020 10:00 am","gatherpress"),endDate:"31 July 2020 11:00 am"}},edit:function(e){var t=e.attributes,r=e.setAttributes,o=e.className,s=Object(c.__experimentalGetSettings)(),u=/a(?!\\)/i.test(s.formats.time.toLowerCase().replace(/\\\\/g,"").split("").reverse().join("")),m=t.startDate,f=t.endDate,d=moment(m),p=moment(f);p=moment(m).add(1,"hour");var b=d.format("dddd, MMMM D, YYYY"),O=p.format("dddd, MMMM D, YYYY"),j=d.format("h:mm A"),h=p.format("h:mm A"),g="";return g=b===O?b+" "+j+" to "+h:b+" "+j+" to "+O+" "+h,Object(n.createElement)(n.Fragment,null,Object(n.createElement)(i.InspectorControls,null,Object(n.createElement)(l.PanelBody,{title:Object(a.__)("Event Start","gatherpress"),initialOpen:!0},Object(n.createElement)(l.PanelRow,null,Object(n.createElement)(l.DateTimePicker,{currentDate:m,onChange:function(e){r({startDate:e})},locale:s.l10n.locale,is12Hour:u}))),Object(n.createElement)(l.PanelBody,{title:Object(a.__)("Event End","gatherpress"),initialOpen:!1},Object(n.createElement)(l.PanelRow,null,Object(n.createElement)(l.DateTimePicker,{currentDate:f,onChange:function(e){r({endDate:e})},locale:s.l10n.locale,is12Hour:u})))),Object(n.createElement)("div",{className:o,style:{border:"1px solid"}},Object(n.createElement)("div",null,Object(n.createElement)("h3",null,g))))},save:function(e){var t=e.attributes,r=e.className,a=t.startDate,o=t.endDate,c=moment(a),l=moment(o),i=c.format("dddd, MMMM D, YYYY"),s=l.format("dddd, MMMM D, YYYY"),u=c.format("h:mm A"),m=l.format("h:mm A"),f="";return f=i===s?i+" "+u+" to "+m:i+" "+u+" to "+s+" "+m,Object(n.createElement)("div",{className:r,style:{border:"1px solid"}},Object(n.createElement)("div",null,Object(n.createElement)("h3",null,f)))}});r(6),r(7);var s=Object(n.createElement)("svg",{id:"Layer_1","data-name":"Layer 1",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 147.1 147.1"},Object(n.createElement)("title",null,"GatherPress"),Object(n.createElement)("circle",{cx:"73.5",cy:"73.5",r:"73.5",fill:"#23c3aa"}),Object(n.createElement)("path",{d:"M791.8,520.2l-23.5,15.1s26.8,20.9,18.5,43.6l-42.8,34.5c-27.4-2.7-60.5-30.4-60.5-71l41.7-35.8c5.8.7,16.5-3.5,23.6-3.4C772.1,503.6,779.1,505,791.8,520.2Z",transform:"translate(-683.3 -467.9)",fill:"#36a08b"}),Object(n.createElement)("path",{d:"M763.6,538.1H797a2.9,2.9,0,0,1,2.9,2.9h0a59.4,59.4,0,0,1-2.3,17.4,36.9,36.9,0,0,1-7.6,13.1Q777.8,585,759.1,585a42.4,42.4,0,0,1-31.3-13.2,45.4,45.4,0,0,1,51.5-73,49.1,49.1,0,0,1,12.3,8.9,6.1,6.1,0,0,1,0,8.7l-.4.4a6,6,0,0,1-8.5-.1q-9.5-9.7-22.2-9.7a31.2,31.2,0,0,0-23.2,9.5Q728,526,728,540T738.4,564q9.7,8.7,21.1,8.7a26.2,26.2,0,0,0,17.4-6.5q7.7-6.6,8.6-15.8H763.6a6.2,6.2,0,0,1-6.2-6.2h0A6.2,6.2,0,0,1,763.6,538.1Z",transform:"translate(-683.3 -467.9)",fill:"#fff",stroke:"#fff","stroke-miterlimit":"10","stroke-width":"6"}));wp.blocks.updateCategory("gatherpress",{icon:s})}]);