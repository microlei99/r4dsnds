$(document).ready(function(){
  $('#side_accordion ul > li p')
    .click(function(e){
      e.stopPropagation();
    })
    /*.filter(':not(:first)')
    .hide();*/
    
  $('#side_accordion ul > li').click(function(){
    var selfClick = $(this).find('p:first').is(':visible');
    if(!selfClick) {
    $(this)
        .parent()
		.find("a.s-c1").andSelf().removeClass('s-c-sel')
        .find('> li p:visible')
		.find("a.s-c1").andSelf().removeClass('s-c-sel')
        .slideToggle();
    }
    $(this)
	  .find("a.s-c1").andSelf().addClass('s-c-sel')
	  .find('p:first')
      .stop(true, true)
      .slideToggle();
  });
});

(function($){
$.fn.viTab = function(options){
	options = jQuery.extend({
	 tabTime : 1000,
	 tabField : "h2>a",
	 tabScroll : 0,
	 tabEvent :1,
	 tabCss :"current"
	},options);
	return this.each(function(){
		var tabTime = options.tabTime;
		var tabScroll = options.tabScroll;
		var tabEvent = options.tabEvent;
		var tabField = options.tabField;
		var tabCss = options.tabCss;
		
		var tabDiv = $(tabField,$(this));
		var totalNum = $(tabDiv).length;
		var tabNum = 0;
		
		if(tabEvent){
		
		$(tabDiv).mouseover(function(){
			if(autoTab){clearInterval(autoTab);}
		    tabNum = $(tabDiv).index(this); 
			changeTab(tabDiv,tabNum,tabCss);
			})	
		$(tabDiv).mouseout(function(){
			  if(tabScroll){autoTab = setInterval(Tab,tabTime);	}
			});	
		}else{
		$(tabDiv).click(function(){
			if(autoTab){clearInterval(autoTab);}
		    tabNum = $(tabDiv).index(this); 
			changeTab(tabDiv,tabNum,tabCss);
			})
		}
		
		var Tab = function(){
			changeTab(tabDiv,tabNum,tabCss);
			tabNum++;
			if(tabNum == totalNum){tabNum = 0;}
		}
		
		var changeTab = function (tabDiv,i,tabCss){
		$(tabDiv).eq(i).addClass(tabCss).siblings().removeClass(tabCss).parent().siblings().hide().eq(i).show();
		}
		
		if(tabScroll && tabEvent){var autoTab = setInterval(Tab,tabTime);}
	})
}
})(jQuery)
