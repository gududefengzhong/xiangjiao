/**
 * Created by rochestor on 16/7/30.
 */
"use strict";
var $ = function( item ) {
    return document.getElementById( item );
}
console.log($("donate"));
window.onload = function() {
    // 捐赠站长
    var donate = $("donate");
    var wechat_money = donate.getElementsByTagName("ul")[0].getElementsByTagName("li");

    for(var i = 0;i< wechat_money.length; i++ ) {
        wechat_money[i].onclick = wechat_tab;
    }
    function wechat_tab() {
        var donate = $("donate");
        var wechat_money = donate.getElementsByTagName("ul")[0].getElementsByTagName("li");

        var wechat_pic = donate.getElementsByTagName("ul")[1].getElementsByTagName("li");

        for( var i = 0; i< wechat_money.length; i++ ) {
            wechat_money[i].setAttribute("class", "");
            wechat_pic[i].setAttribute("class", "dn");
            if (wechat_money[i] == this) {
                wechat_pic[i].setAttribute("class", "show");
                wechat_money[i].setAttribute("class", "active");
            }
        }

    }

    var ali_money = donate.getElementsByTagName("ul")[2].getElementsByTagName("li");

    for(var i = 0;i< ali_money.length; i++ ) {
        ali_money[i].onclick = ali_tab;
    }
    function ali_tab() {
        var donate = $("donate");
        var ali_money = donate.getElementsByTagName("ul")[2].getElementsByTagName("li");

        var ali_pic = donate.getElementsByTagName("ul")[3].getElementsByTagName("li");

        for( var i = 0; i< ali_money.length; i++ ) {
            ali_money[i].setAttribute("class", "");
            ali_pic[i].setAttribute("class", "dn");
            if (ali_money[i] == this) {
                ali_pic[i].setAttribute("class", "show");
                ali_money[i].setAttribute("class", "active");
            }
        }

    }

};