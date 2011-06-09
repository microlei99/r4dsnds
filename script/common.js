// 切换
function switchTab(identify,index,count) {
    for(i=0;i<count;i++) {
        var CurTabObj = document.getElementById("Tab_"+identify+"_"+i) ;
        var CurListObj = document.getElementById("List_"+identify+"_"+i) ;
        if (i != index) {
            fRemoveClass(CurTabObj , "upTab") ;
            fRemoveClass(CurListObj , "upBox") ;
        }
    }
    try {
        for (ind=0;ind<CachePic['recommend'][index].length ;ind++ ) {
            var picobj = document.getElementById("recommend_pic_"+index+"_"+ind) ;
            //if (picobj.src == "http://images.movie.xunlei.com/img_default.gif") {
            picobj.src = CachePic['recommend'][index][ind] ;
        //}
        }
    }
    catch (e) {}
	
    fAddClass(document.getElementById("Tab_"+identify+"_"+index),"upTab") ;
    fAddClass(document.getElementById("List_"+identify+"_"+index),"upBox") ;
}

function fAddClass(XEle, XClass) {
    if(!XClass) throw new Error("XClass 不能为空!");
    if(XEle.className!="") {
        var Re = new RegExp("\\b"+XClass+"\\b\\s*", "");
        XEle.className = XEle.className.replace(Re, "");
        var OldClassName = XEle.className.replace(/^\s+|\s+$/g,"") ;
        if (OldClassName == "" ) {
            XEle.className = XClass;
        }
        else {
            XEle.className = OldClassName + " " + XClass;
        }
    }
    else XEle.className = XClass;
}

function fRemoveClass(XEle, XClass) {
    if(!XClass) throw new Error("XClass 不能为空!");
    var OldClassName = XEle.className.replace(/^\s+|\s+$/g,"") ;
    if(OldClassName!="") {
        var Re = new RegExp("\\b"+XClass+"\\b\\s*", "");
        XEle.className = OldClassName.replace(Re, "");
    }
}

// 收缩展开效果
$(document).ready(function(){
    $("#side-classCatalog li").toggle(function(){
        $(this).addClass("s-c-sel");
        $(this+"p").removeClass("hidden");
        $(this+"p").animate({
            height: 'toggle',
            opacity: 'toggle'
        }, "slow");
    },function(){
        $(this).addClass("s-c-sel");
        $(this+"p").removeClass("hidden");
        $(this+"p").animate({
            height: 'toggle',
            opacity: 'toggle'
        }, "slow");
    });
    var objStr = "#global-searchChoices";
    $(objStr).mouseover(function(){
        $(objStr + " ul").show();
    });
    $(objStr).mouseout(function(){
        $(objStr + " ul").hide();
    });
            
    $("#p-l-px1 ul").mouseover(function(){
        $("#p-l-px1 ul").show();
    });
    $("#p-l-px1 ul").mouseout(function(){
        $("#p-l-px1 ul").hide();
    });
          
    $("#p-l-px2 ul").mouseover(function(){
        $("#p-l-px2 ul").show();
    });
    $("#p-l-px2 ul").mouseout(function(){
        $("#p-l-px2 ul").hide();
    });
				
    $("#sub-searchChoices").mouseover(function(){
        $("#sub-searchChoices ul").show();
    });
    $("#sub-searchChoices").mouseout(function(){
        $("#sub-searchChoices ul").hide();
    });
});

// 收缩展开
var ShowMoreLinks = "" ;
var MoreLinksShowHandles = null ;
function showMoreLinks(elm,classname) {
 clearTimeout(MoreLinksShowHandles) ;
 document.getElementById(elm).style.display = "block" ;
 if (classname) {
 document.getElementById(elm+'Handle').className = classname ;
 }
 if (elm != ShowMoreLinks && ShowMoreLinks != "") {
 document.getElementById(ShowMoreLinks).style.display = "none" ;
 if (classname) {
 document.getElementById(elm+'Handle').className = classname ;
 }
 }
 ShowMoreLinks = elm ;

}
function hideMoreLinks(elm,classname) {
 MoreLinksShowHandles = setTimeout( function(){document.getElementById(elm).style.display = "none" ;if (classname){document.getElementById(elm+'Handle').className = classname;}}, 500) ;
} 

function showGougouMoreLink() {
 $("GougouMoreLink").style.display = "block" ;
}
function hideGougouMoreLink() {
 $("GougouMoreLink").style.display = "none" ;
} 
