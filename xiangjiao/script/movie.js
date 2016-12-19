/**
 * Created by rochestor on 16/7/24.
 */

"use strict";
var $ = function( item ) {
    return document.getElementById( item );
}

var carousel = $("carousel");
var carousel_li = carousel.getElementsByTagName("li");
var li_len = carousel_li.length, cur_index=0;
var speed = 2500;

var dots_ul = $("dots");
dots_ul.getElementsByTagName("li")[0].style.backgroundColor = "#fff";
var dots_li = dots_ul.getElementsByTagName("li");

var auto_complete = setInterval( function(){
    if( cur_index < li_len ) {
        carousel.style.left = (-100 * cur_index) + '%';

        for(var i=0; i < dots_li.length; i++ ) {
            dots_ul.getElementsByTagName("li")[i].style.backgroundColor = "";
        }
        dots_ul.getElementsByTagName("li")[cur_index].style.backgroundColor = "#fff";
        cur_index++;
    }else{
        cur_index = 0;
        carousel.style.left = (-100 * cur_index) + '%';
    }


}, speed);

auto_complete;

function get_dd_siblings( ele ) {
    var res =[];
    var children = ele.parentNode.childNodes;
    for( var i = 0; i < children.length; i++ ) {
        if( children[i].nodeType == 1 & children[i].nodeName == 'DD' && children[i] != ele ) {
            res.push(children[i]);
        }
    }
    return res;
}

// 返回顶部
window.onload = function() {

    var top_btn = $("go-top");
    var go = top_btn.getElementsByTagName("a")[1];
    //可视区高度
    var client_height = document.documentElement.clientHeight;
    var timer = null;

    window.onscroll = function() {
        var os_top = document.documentElement.scrollTop || document.body.scrollTop;
        if( os_top > client_height ) {
            top_btn.style.display = 'block';
        }else{
            top_btn.style.display = 'none';
        }

    }

    go.onclick = function() {
        //设置定时器
        timer = setInterval(function() {
            //获取滚动条距离顶部的高度
            var os_top = document.documentElement.scrollTop || document.body.scrollTop;
            var is_speed = Math.floor( -os_top / 6 );

            document.documentElement.scrollTop = document.body.scrollTop = os_top + is_speed;

            if(!os_top) {
                clearInterval( timer );
            }
        },30);
    };

    // 显示隐藏二维码

    var uc_2wm = top_btn.getElementsByTagName("a")[0];
    var div_2wm = top_btn.getElementsByTagName("div")[0];
    uc_2wm.onmouseover = function() {
        div_2wm.style.display = 'inline-block';
    }

    uc_2wm.onmouseout = function() {
        div_2wm.style.display = 'none';
    }

    // 捐赠站长
    var donate = $("donate");
    var platforms = donate.getElementsByTagName("ul")[0].getElementsByTagName("li");

    // var money_range = donate.getElementsByTagName("ul")[1].getElementsByTagName("li");

    for(var i = 0;i< platforms.length; i++ ) {
        platforms[i].onclick = tab;
    }
    function tab() {
        var donate = $("donate");
        var platforms = donate.getElementsByTagName("ul")[0].getElementsByTagName("li");

        var money_range = donate.getElementsByTagName("ul")[1].getElementsByTagName("li");

        for( var i = 0; i< platforms.length; i++ ) {
            platforms[i].setAttribute("class", "");
            money_range[i].setAttribute("class", "dn");
            if (platforms[i] == this) {
                platforms[i].setAttribute("class", "active");
                money_range[i].setAttribute("class", "show");
            }
        }

    }






};


